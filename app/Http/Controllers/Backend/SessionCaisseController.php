<?php

// app/Http/Controllers/SessionCaisseController.php
namespace App\Http\Controllers;

use App\Models\CashSession;
use App\Models\Caisse;
use App\Models\CashMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionCaisseController extends Controller
{
    public function index(Request $request)
    {
        $sessions = CashSession::with(['cashRegister', 'user'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->register_id, function ($query, $registerId) {
                return $query->where('cash_register_id', $registerId);
            })
            ->orderBy('opened_at', 'desc')
            ->paginate(20);

        return response()->json($sessions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cash_register_id' => 'required|exists:cash_registers,id',
            'opening_balance' => 'required|numeric|min:0'
        ]);

        // Vérifier qu'il n'y a pas déjà une session ouverte pour cette caisse
        $existingSession = CashSession::where('cash_register_id', $request->cash_register_id)
            ->where('status', 'open')
            ->first();

        if ($existingSession) {
            return response()->json([
                'message' => 'Une session est déjà ouverte pour cette caisse'
            ], 422);
        }

        $session = CashSession::create([
            'cash_register_id' => $request->cash_register_id,
            'user_id' => Auth::id(),
            'opening_balance' => $request->opening_balance,
            'opened_at' => now(),
            'status' => 'open'
        ]);

        return response()->json([
            'message' => 'Session de caisse ouverte avec succès',
            'session' => $session->load(['cashRegister', 'user'])
        ], 201);
    }

    public function show(CashSession $session)
    {
        $session->load(['cashRegister', 'user', 'movements', 'sales']);

        $sessionData = $session->toArray();
        $sessionData['expected_balance'] = $session->calculateExpectedBalance();
        $sessionData['total_sales'] = $session->total_sales;
        $sessionData['total_cash_sales'] = $session->total_cash_sales;

        return response()->json($sessionData);
    }

    public function close(Request $request, CashSession $session)
    {
        $request->validate([
            'closing_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($session->status === 'closed') {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Cette session est déjà fermée'], 422);
            }
            return redirect()->route('cash-sessions.show', $session)
                ->with('status', 'Cette session est déjà fermée');
        }

        DB::transaction(function () use ($request, $session) {
            $expectedBalance = $session->calculateExpectedBalance();
            $difference = $request->closing_balance - $expectedBalance;

            $session->update([
                'closing_balance' => $request->closing_balance,
                'expected_balance' => $expectedBalance,
                'difference' => $difference,
                'closed_at' => now(),
                'status' => 'closed',
                'notes' => $request->notes
            ]);
        });

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Session fermée avec succès',
                'session' => $session->fresh()
            ]);
        }

        return redirect()->route('cash-sessions.show', $session)
            ->with('status', 'Session fermée avec succès');
    }

    public function addMovement(Request $request, CashSession $session)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'reference' => 'nullable|string'
        ]);

        if ($session->status === 'closed') {
            return response()->json([
                'message' => 'Impossible d\'ajouter un mouvement à une session fermée'
            ], 422);
        }

        $movement = CashMovement::create([
            'cash_session_id' => $session->id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'reference' => $request->reference
        ]);

        return response()->json([
            'message' => 'Mouvement ajouté avec succès',
            'movement' => $movement->load('user')
        ], 201);
    }

    public function getCurrentSession(Request $request)
    {
        $session = CashSession::with(['cashRegister', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();

        if (!$session) {
            return response()->json(['message' => 'Aucune session active'], 404);
        }

        return response()->json($session);
    }

    public function getReport(CashSession $session)
    {
        $report = [
            'session' => $session->load(['cashRegister', 'user']),
            'opening_balance' => $session->opening_balance,
            'closing_balance' => $session->closing_balance,
            'expected_balance' => $session->calculateExpectedBalance(),
            'difference' => $session->difference,
            'total_sales' => $session->total_sales,
            'sales_by_payment_method' => $session->sales()
                ->selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as total')
                ->groupBy('payment_method')
                ->get(),
            'movements' => $session->movements()
                ->selectRaw('type, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('type')
                ->get(),
            'hourly_sales' => $session->sales()
                ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count, SUM(total_amount) as total')
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
        ];

        return response()->json($report);
    }
}

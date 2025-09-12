<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CashRegisterController extends Controller
{
    /**
     * Vérifie l'état de la caisse pour l'utilisateur connecté
     */
    public function status(Request $request)
    {
        $cashRegister = CashRegister::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
        if ($cashRegister) {
            return response()->json([
                'status' => 'open',
                'cash_register' => $cashRegister
            ]);
        } else {
            return response()->json([
                'status' => 'closed'
            ]);
        }
    }
    /**
     * Ouvre une nouvelle caisse avec un fond initial
     */
    public function open(Request $request)
    {
        $request->validate([
            'opening_amount' => 'required|numeric|min:0',
        ]);

        // Vérifier si une caisse ouverte existe déjà pour l'utilisateur
        $existing = CashRegister::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
        if ($existing) {
            return response()->json(['message' => 'Une caisse est déjà ouverte.'], 422);
        }

        $cashRegister = CashRegister::create([
            'user_id' => Auth::id(),
            'opening_amount' => $request->opening_amount,
            'status' => 'open',
            'opened_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Caisse ouverte avec succès.', 'cash_register' => $cashRegister]);
    }

    /**
     * Ferme la caisse ouverte pour l'utilisateur
     */
    public function close(Request $request)
    {
        $request->validate([
            'closing_amount' => 'required|numeric|min:0',
        ]);

        $cashRegister = CashRegister::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
        if (!$cashRegister) {
            return response()->json(['message' => 'Aucune caisse ouverte à fermer.'], 404);
        }

        $cashRegister->update([
            'closing_amount' => $request->closing_amount,
            'status' => 'closed',
            'closed_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Caisse fermée avec succès.', 'cash_register' => $cashRegister]);
    }
}

<?php

// app/Http/Controllers/CaisseController.php
namespace App\Http\Controllers\Backend;

use App\Models\Caisse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trait\FileHandler;
use Yajra\DataTables\DataTables;


class CaisseController extends Controller
{
    public function indexold(Request $request)
    {
        $caisses = Caisse::with('currentSession')
            ->where('is_active', true)
            ->get();

        // return response()->json($caisses);
        return view('backend.caisses.index');
    }

     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('brand_view'), 403);
        if ($request->ajax()) {
            $caisses = Caisse::latest()->get();
            return DataTables::of($caisses)
                ->addIndexColumn()
                ->addColumn('nom', fn($data) => $data->nom)
                ->addColumn('lieu', fn($data) => $data->lieu)
                ->addColumn('is_active', fn($data) => $data->is_active
                    ? '<span class="badge bg-primary">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>')
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group">
                    <button type="button" class="btn bg-gradient-primary btn-flat">Action</button>
                    <button type="button" class="btn bg-gradient-primary btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="' . route('backend.admin.caisses.edit', $data->id) . '" ' . ' >
                    <i class="fas fa-edit"></i> Editer
                </a> <div class="dropdown-divider"></div>
<form action="' . route('backend.admin.caisses.destroy', $data->id) . '"method="POST" style="display:inline;">
                   ' . csrf_field() . '
                    ' . method_field("DELETE") . '
<button type="submit" class="dropdown-item" onclick="return confirm(\'Etes-vous sûr ?\')"><i class="fas fa-trash"></i> Supprimer</button>
                  </form>
                  </div>';
                })
                ->rawColumns(['nom', 'lieu', 'is_active','action'])
                ->toJson();
        }


        return view('backend.caisses.index');
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        abort_if(!auth()->user()->can('product_create'), 403);
       
        return view('backend.caisses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'lieu' => 'nullable|string|max:255',
        ]);

        $caisse = Caisse::create($request->all());

        // return response()->json([
        //     'message' => 'Caisse créée avec succès',
        //     'caisse' => $caisse
        // ], 201);

        return redirect()->route('backend.admin.caisses.index')->with('success', 'Caisse créée avec succès!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $caisse = Caisse::findOrFail($id);
        return view('backend.caisses.edit', compact(  'caisse'));
    }

  

    public function show(Caisse $caisse)
    {
        return response()->json($caisse->load(['sessions' => function($query) {
            $query->latest()->limit(10);
        }]));
    }

    public function update(Request $request, Caisse $caisse)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $caisse->update($request->all());

        return redirect()->route('backend.admin.caisses.index')->with('success', 'Caisse mise à jour avec succès!');

    }

    public function destroy(Caisse $caisse)
    {
        // Vérifier qu'il n'y a pas de session ouverte
        if ($caisse->currentSession) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Impossible de supprimer une caisse avec une session active'
                ], 422);
            }
            return redirect()->route('backend.admin.caisses.index')
                ->with('error', 'Impossible de supprimer une caisse avec une session active');
        }

        $caisse->update(['is_active' => false]);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Caisse désactivée avec succès'
            ]);
        }
        return redirect()->route('backend.admin.caisses.index')->with('status', 'Caisse désactivée avec succès');
    }
}

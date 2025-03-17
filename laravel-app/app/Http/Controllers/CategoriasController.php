<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Support\Facades\Gate;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::all();
        if ($categoria->isEmpty()) {
            return response()->json(['error' => 'Categoria ainda nao cadastradas!'], 404);
        } else {
            try {
                return response()->json(['msg' => 'Categoria localizados com sucesso!', 'categoria' => $categoria], 200);
            } catch (\Exception $e) {
                return response()->json(['msg' => 'Categoria localizados com sucesso!' . $e->getMessage()], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        #Gate::authorize('create', Categoria::class);
        try {
            $request->validated([]);

            $categoria = Categoria::create($request->all());
            return response()->json(['msg' => 'Categoria criada com sucesso!', 'categoria' => $categoria], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar Categoria: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
         try {
            return $categoria;
        } catch (\Exception $exception) {
            throw new Exception('categoria não encontrada!', $exception->getCode(), $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecategoriaRequest $request, Categoria $categoria)
    {
        try {
            // Validação dos dados
            $request->validate([]);

            if (!$categoria) {
                return response()->json(['error' => 'Categoria não encontrada.'], 404);
            } else {
                $categoria->update($request->all());
                return response()->json(['msg' => 'Categoria atualizada com sucesso!', 'categoria' => $categoria], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar tarefa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categoria $categoria)
    {
          try {
            if (!$categoria) {
                return response()->json(['error' => 'Categoria não encontrada.'], 404);
            } else {
                $categoria->delete();
                return response()->json(['msg' => 'Categoria excluída com sucesso!'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir tarefacategoria: ' . $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Response;

class ItemController 
{
    // Retorna uma lista de itens
    public function index(Request $request)
    {
        $orderBy = $request->query('order_by', 'created_at');
    
        $items = Item::orderBy($orderBy)->get();
        return response()->json($items);
    }

    // Armazena um novo item
    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    // Mostra um item específico
    public function show($id)
    {
        $item = Item::find($id);
        if ($item) {
            return response()->json($item);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }

    // Atualiza um item específico
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->update($request->all());
            return response()->json($item);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }

    public function updateFavorite(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        if (!$request->has('favorite')) {
            return response()->json(['message' => 'O campo favorite é obrigatório'], 400);
        }

        $item->update(['favorite' => $request->favorite]);

        return response()->json($item);
    }

    public function updateColor(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        if (!$request->has('color')) {
            return response()->json(['message' => 'O campo color é obrigatório'], 400);
        }

        $item->update(['color' => $request->color]);

        return response()->json($item);
    }


    // Remove um item específico
    public function destroy($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Item deleted']);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }
}

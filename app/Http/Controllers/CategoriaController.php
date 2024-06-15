<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Retorna uma lista de todas as categorias.
     */
    public function index()
    {
        return Categoria::select('nome')->get();
    }

    /**
     * Cria uma nova categoria e armazena no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos.
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Cria e armazena a nova categoria.
        $categoria = Categoria::create($validated);

        return Categoria::select('nome')->findOrFail($categoria->id);
    }

    /**
     * Retorna os detalhes de uma categoria específica.
     */
    public function show(string $id)
    {
        // Verifica se a categoria buscada de fato existe.
        $validator = Validator::make(['categoria_id' => $id], [
            'categoria_id' => 'exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        // Retorno dos detalhes da categoria específica.
        return Categoria::select('nome')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'destroy';
    }
}

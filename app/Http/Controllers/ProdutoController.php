<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    /**
     * Retorna uma lista de todos os produtos.
     */
    public function index()
    {
        return Produto::select('nome', 'descricao', 'preco', 'categoria_id')->get();
    }

    /**
     * Cria um novo produto e armazena no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos.
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'preco' => 'required|decimal:0,2',
            'categoria_id' => 'required|integer|exists:categorias,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Cria e armazena o novo produto atraves do relacionamento com a categoria.
        $categoria = Categoria::findOrFail($validated['categoria_id']);
        $produto = $categoria->produtos()->create($validated);

        return Produto::select('nome', 'descricao', 'preco', 'categoria_id')->findOrFail($produto->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Verifica se o produto buscado de fato existe.
        $validator = Validator::make(['produto_id' => $id], [
            'produto_id' => 'exists:produtos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        // Retorno dos detalhes do produto específico.
        return Produto::select('nome', 'descricao', 'preco', 'categoria_id')->findOrFail($id);
    }

    /**
     * Atualize o produto especificado.
     */
    public function update(Request $request, string $id)
    {
        // Verifica se o produto buscado de fato existe, e valida os dados recebidos.
        $validator = Validator::make($request->all() + ['produto_id' => $id], [
            'nome' => 'nullable|string',
            'descricao' => 'nullable|string',
            'preco' => 'nullable|decimal:0,2',
            'categoria_id' => 'nullable|integer|exists:categorias,id',
            'produto_id' => 'exists:produtos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Encontra o produto e atualiza com os dados validados.
        $produto = Produto::findOrFail($id)->update($validated);

        return Produto::select('nome', 'descricao', 'preco', 'categoria_id')->findOrFail($id);
    }

    /**
     * Deleta um produto específico.
     */
    public function destroy(string $id)
    {
        // Verifica se o produto buscado de fato existe.
        $validator = Validator::make(['produto_id' => $id], [
            'produto_id' => 'exists:produtos,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        // Encontra o produto e apaga.
        Produto::findOrFail($id)->delete();

        return response()->json('Produto foi excluído.', 200);
    }
}

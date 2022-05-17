<?php

namespace App\Http\Controllers;

use App\Interfaces\ProdutoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProdutoController extends Controller 
{
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository) 
    {
        $this->produtoRepository = $produtoRepository;
    }


    /**
     * @OA\Get(
     *     path="/projects",
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->produtoRepository->getAllProdutos()
        ]);
    }

    public function store(Request $request): JsonResponse 
    {
        $produtoDetails = $request->only([
            'descricao',
            'dimensoes',
            'codigo',
            'referencia',
            'saldo_estoque',
            'preco',
            'categoria_id',
        ]);

        return response()->json(
            [
                'data' => $this->produtoRepository->createProduto($produtoDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse 
    {
        $produtoId = $request->route('id');

        return response()->json([
            'data' => $this->produtoRepository->getProdutoById($produtoId)
        ]);
    }

    public function update(Request $request): JsonResponse 
    {
        $produtoId = $request->route('id');
        $produtoDetails = $request->only([
            'descricao',
            'dimensoes',
            'codigo',
            'referencia',
            'saldo_estoque',
            'preco',
            'categoria_id',
        ]);

        return response()->json([
            'data' => $this->produtoRepository->updateProduto($produtoId, $produtoDetails)
        ]);
    }

    public function destroy(Request $request): JsonResponse 
    {
        $produtoId = $request->route('id');
        $this->produtoRepository->deleteProduto($produtoId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

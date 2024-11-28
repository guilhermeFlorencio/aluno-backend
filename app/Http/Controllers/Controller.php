<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Retorna uma resposta de sucesso padronizada.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function successResponse($data, $message = '', $status = 200): JsonResponse
    {
        return response()->json([
            'sucesso' => true,
            'mensagem' => $message,
            'dados' => $data,
        ], $status);
    }

    /**
     * Retorna uma resposta de erro padronizada.
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function errorResponse($message, $status = 400): JsonResponse
    {
        return response()->json([
            'sucesso' => false,
            'mensagem' => $message,
        ], $status);
    }

    /**
     * Lida com exceções de "model not found" de forma padronizada.
     *
     * @param \Closure $callback
     * @return JsonResponse|mixed
     */
    protected function handleModelNotFound(\Closure $callback)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Recurso não encontrado.', 404);
        }
    }
}

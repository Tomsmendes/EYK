<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ApiResponseController extends Controller
{
    // Método para lidar com a requisição e retornar a resposta
    public function getResponse(Request $request)
    {
        // Validar a entrada do usuário
        $validated = $request->validate([
            'request' => 'required|string',
            'language' => 'required|string|in:pt,libras', // 'pt' para Português, 'libras' para Libras
        ]);

        // Buscar a resposta no banco de dados
        $response = Response::where('request', $validated['request'])
                            ->where('language', $validated['language'])
                            ->first();

        if (!$response) {
            return response()->json([
                'message' => 'Nenhuma resposta encontrada para essa solicitação.',
            ], 404);
        }

        // Retornar a resposta apropriada com base na linguagem
        if ($validated['language'] === 'pt') {
            return response()->json([
                'response' => $response->response_text,
            ]);
        } elseif ($validated['language'] === 'libras') {
            return response()->json([
                'response_video_url' => asset('storage/' . $response->response_video),
            ]);
        }
    }
}

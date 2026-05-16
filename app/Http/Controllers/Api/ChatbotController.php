<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Proxy vers l'API Google Gemini.
     * Route : POST /chatbot/recipe
     */
    public function recipe(Request $request)
    {
        $request->validate([
            'messages'           => 'required|array|min:1|max:20',
            'messages.*.role'    => 'required|in:user,assistant',
            'messages.*.content' => 'required|string|max:2000',
            'system'             => 'nullable|string|max:3000',
        ]);

        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return response()->json(['error' => 'Clé API Gemini manquante.'], 500);
        }

        // ── Convertir le format Anthropic → Gemini ────────────────
        // Anthropic : { role: "user"|"assistant", content: "..." }
        // Gemini    : { role: "user"|"model",     parts: [{ text: "..." }] }
        $contents = collect($request->messages)->map(function ($msg) {
            return [
                'role'  => $msg['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $msg['content']]],
            ];
        })->values()->all();

        $payload = [
            'contents'         => $contents,
            'generationConfig' => [
                'maxOutputTokens' => 1500,
                'temperature'     => 0.7,
            ],
        ];

        // System instruction (optionnel)
        if ($request->filled('system')) {
            $payload['systemInstruction'] = [
                'parts' => [['text' => $request->system]],
            ];
        }

        // Modèle gratuit : gemini-1.5-flash-8b (quota plus généreux)
        $model = 'gemini-1.5-flash-8b';
        $url   = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(30)->post($url, $payload);

        if ($response->failed()) {
            \Log::error('[Chatbot] Gemini API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return response()->json([
                'error'  => 'Erreur API IA.',
                'detail' => $response->json(),
            ], 502);
        }

        $data  = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return response()->json(['reply' => $reply]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\Klant;
use Illuminate\Support\Facades\Http;
use App\Models\Serie;

class CustomerServiceController extends Controller
{
    private $apiKey;
    private $apiBaseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = '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';
    }

    public function handleRequest(Request $request)
    {
        $question = $request->input('question');
        $baseText = $this->loadBaseText();

        $aantal_klanten = Klant::count();
        $aantal_series = Serie::count();

        $extraTekst = "Er zijn momenteel $aantal_klanten klanten geregistreerd." .
            " Er zijn $aantal_series series beschikbaar op hobo."; 

        $baseText .= $extraTekst;
        $baseText .= "\nVeelgestelde vragen:\n" . $this->loadFaq();

        $response = $this->ask($baseText, $question);
        $noQuotes = str_replace('"', '', $response);

        $this->saveConversation($request->user(), $question, $noQuotes);

        return response()->json(['response' => $noQuotes]);
    }

    private function ask($baseText, $userMessage)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiBaseUrl, [
            'model' => 'gryphe/mythomax-l2-13b',
            'messages' => [
                ['role' => 'system', 'content' => $baseText],
                ['role' => 'user', 'content' => $userMessage],
            ],
        ]);

        return $response->json()['choices'][0]['message']['content'];
    }

    private function loadBaseText()
    {
        return file_get_contents(storage_path('app/base_text.txt'));
    }

    private function loadFaq()
    {
        return file_get_contents(storage_path('app/faq.txt'));
    }

    private function saveConversation($user, $question, $response)
    {
        // Implementeer deze functie om het gesprek op te slaan.
    }
}
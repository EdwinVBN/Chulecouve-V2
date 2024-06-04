<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\Klant;
use App\Models\Serie;

class CustomerServiceController extends Controller
{
    public function handleRequest(Request $request)
    {
        $question = $request->input('question');

        $openai = new OpenAi(env('OPENAI_API_KEY'));
        $baseText = $this->loadBaseText();

        $aantal_klanten = Klant::count();
        $aantal_series = Serie::count();

        $extraTekst = "Er zijn momenteel $aantal_klanten klanten geregistreerd." .
            " Er zijn $aantal_series series beschikbaar op hobo."; 

        $baseText .= $extraTekst;

        // Add frequently asked questions
        $faq = $this->loadFaq();
        $baseText .= "\nVeelgestelde vragen:\n" . $faq;

        $response = $openai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $baseText],
                ['role' => 'user', 'content' => $question],
            ],
        ]);

        $decodedResponse = json_decode($response, true);
        $assistantMessage = $decodedResponse['choices'][0]['message']['content'];
        $this->saveConversation($request->user(), $question, $assistantMessage);

        return response()->json(['response' => $assistantMessage]);
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
    }
}

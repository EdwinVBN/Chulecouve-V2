<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;

class CustomerServiceController extends Controller
{
    public function handleRequest(Request $request)
    {
        $question = $request->input('question');

        $openai = new OpenAi(env('OPENAI_API_KEY'));
        $baseText = $this->loadBaseText();

        $response = $openai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $baseText],
                ['role' => 'user', 'content' => $question],
            ],
        ]);

        $decodedResponse = json_decode($response, true);
        $assistantMessage = $decodedResponse['choices'][0]['message']['content'];

        // Save the conversation to the database
        $this->saveConversation($request->user(), $question, $assistantMessage);

        return response()->json(['response' => $assistantMessage]);
    }

    private function loadBaseText()
    {
        return file_get_contents(storage_path('app/base_text.txt'));
    }

    private function saveConversation($user, $question, $response)
    {
        // Save the conversation to the database
        // Example: Conversation::create([...]);
    }
}

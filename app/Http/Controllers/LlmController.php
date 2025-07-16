<?php


namespace App\Services;

use Ollama\Client;
use Illuminate\Http\Request;

class LlmController
{
    private $client;

    // public function __construct()
    // {
    //     // Replace with your API key!  Never commit your API key to your repository.
    //     $this->client = new Client([
    //         'apiKey' => env('OPENAI_API_KEY'),
    //     ]);
    // }

    // public function generateText($prompt)
    // {
    //     try {
    //         $response = $this->client->completions()->create([
    //             'prompt' => $prompt,
    //             'max_tokens' => 100, // Adjust as needed
    //         ]);
    //         return $response->text;
    //     } catch (\Exception $e) {
    //         // Handle errors gracefully - logging is important!
    //         \Log::error('Error generating text: ' . $e->getMessage());
    //         return 'Error generating text.';
    //     }
    // }

    public function __construct()
    {
        // Replace with your API Key!  NEVER commit your API key to your repository.
        $this->client = new Client(getenv('OLLAMA_API_KEY'));  // Use environment variable.
    }

    public function generateText($prompt)
    {
        try {
            $response = $this->client->completions()->create([
                'model' => 'gemma3', // Or your desired model (e.g., llama2, mistral)
                'prompt' => $prompt,
                'max_tokens' => 100, // Adjust as needed
            ]);
            return $response->choices[0]->text; // Extract the text from the response
        } catch (\Exception $e) {
            // Handle errors gracefully - logging is critical!
            \Log::error('Error generating text: ' . $e->getMessage());
            return 'Error generating text.';
        }
    }
}

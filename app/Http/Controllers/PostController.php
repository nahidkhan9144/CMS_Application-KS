<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get_data()
    {
        $user = auth()->user();

        if ($user->id == 1) {
            $books = Post::orderBy('id', 'DESC')->cursorPaginate(2);
        } else {
            $books = Post::where('user_id', $user->id)
                ->orderBy('id', 'DESC')
                ->cursorPaginate(2);
        }

        return view('post.index', ['data' => $books]);
    }
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    public function updateGetData($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }


    public function generateSlug(Request $request)
    {
        return response()->json(['slug' => 'ai-error']);
        $request->validate([
            'title' => 'required|string',
        ]);

        // Compose your prompt
        $prompt = "Generate a short, URL-friendly brains quotes in lowercase with hyphens for the following title:\n\n" .
            "{$request->title}\n\n" .
            "Only return the quotes without any extra words.";

        $client = OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->make();

        $response = $client->completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => 20,
            'temperature' => 0.3,
        ]);

        if (isset($response['error'])) {
            // Instead of returning 500, return a fallback slug
            return response()->json(['slug' => 'ai-error']);
        }

        $slug = trim($response['choices'][0]['text']);

        return response()->json(['slug' => $slug]);
    }

    public function generateSummary(Request $request)
    {
        return response()->json(['summary' => 'ai-summary']);
        $request->validate([
            'title' => 'required|string',
        ]);

        // Compose your prompt
        $prompt = "Generate a short, URL-friendly brains quotes in lowercase with hyphens for the following title:\n\n" .
            "{$request->title}\n\n" .
            "Only return the quotes without any extra words.";

        $client = OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->make();

        $response = $client->completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => 20,
            'temperature' => 0.3,
        ]);

        if (isset($response['error'])) {
            // Instead of returning 500, return a fallback slug
            return response()->json(['slug' => 'ai-error']);
        }

        $slug = trim($response['choices'][0]['text']);

        return response()->json(['slug' => $slug]);
    }

    public function update(Request $request, $id)
    {
        $book = Post::findOrFail($id);
        $book->update($request->only([
            'title',
            'slug',
            'content',
            'summary',
            'status',
            'published_date',
            'author_name'
        ]));

        return response()->json(['message' => 'Book updated successfully.']);
    }

    public function create(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'status' => 'required|in:Draft,Published,Archived',
            'published_date' => 'nullable|date',
            'author_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        $post = Post::create($validated);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }
}

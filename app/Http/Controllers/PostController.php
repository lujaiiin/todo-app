<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::all(); // Retrieve all posts
        return view('posts.index', compact('posts')); // Pass posts to the view
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'publish_entry' => 'required',
        ]);
    
        $post = new Post;
        $post->title = $validatedData['title'];
        $post->content = $validatedData['publish_entry'];
        $post->save();
    
        return redirect()->back()->with('success', 'Post saved successfully!');
    }
    public function searchResults(Request $request)
    {
        $query = $request->get('query');
        $results = Post::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->paginate(10); // Adjust pagination as needed

        return view('posts.index', compact('results'));
    }



}

<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScreenshotController extends Controller
{
    public function index()
    {
        $screenshots = Screenshot::all(); // Adjust this query based on your model and relationships
        return view('screenshots.index', compact('screenshots'));
    }

    public function show($id)
    {
        $screenshot = Screenshot::findOrFail($id);
        return view('screenshot-view', compact('screenshot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'screenshot' => 'required|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->screenshot->extension();  
        $request->screenshot->move(public_path('images/screenshots'), $imageName);

        return response()->json(['success'=>'Image saved successfully.']);
    }
    


}
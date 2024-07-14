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
        $screenshotData = $request->getContent(); // Get the raw screenshot data
        $filename = time().'.png'; // Generate a unique filename
        $path = public_path('images/'.$filename); // Specify the full path to save the file

        file_put_contents($path, base64_decode($screenshotData)); // Write the file to the specified path

        return response()->json(['success' => true]); // Return a success response
    }
    


}
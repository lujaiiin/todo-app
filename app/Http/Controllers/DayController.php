<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DailyEntry;

class DayController extends Controller
{
    public function storeOrUpdate(Request $request, $day_id)
    {
        $validatedData = $request->validate([
            'updated_entry' => 'required|string|max:500',
        ]);
        
        try {
            
            DailyEntry::create([
                'day_id' => $day_id,
                'content' => $validatedData['updated_entry'],
            ]);
            return redirect()->back()->with('success', 'Entry saved successfully.');
        } catch 
        (\Exception $e) {
            // Update logic
            $day = DailyEntry::findOrFail($day_id);
            $day->update(['content' => $validatedData['updated_entry']]);
            return redirect()->back()->with('success', 'Entry updated successfully.');
        }
    }

    
    public function showDay(int $id)
    {
        // Fetch the most recent entry for the selected day, if any
        $latestEntry = DailyEntry::where('day_id', $id)->latest()->first();

        // Pass the latest entry to the view
        return view('day_view', [
            'day_id' => $id,
            'entries' => $entries = DailyEntry::whereDate('created_at', $id)->get(),
            'latestEntry' => $latestEntry // Pass the latest entry to the view
        ]);
    }

    /*public function store(Request $request, int $day_id)
    {
        // Validate the incoming request...
        $validatedData = $request->validate([
            'new_entry' => 'required|string|max:255',
        ]);

        // Attempt to create a new DailyEntry instance...
        try {
            DailyEntry::create([
                'day_id' => $day_id,
                'content' => $validatedData['new_entry'],
            ]);

            // On successful creation, redirect back with a success message...
            return back()->with('success', 'Entry saved successfully');
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the creation process...
            // For now, just log the exception and redirect back with an error message...
            \Log::error("Failed to save entry: {$e->getMessage()}");
            return back()->withErrors(['error' => 'There was an error saving your entry. Please try again.']);
        }
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'updated_entry' => 'required|string|max:255',
        ]);

        $entry = DailyEntry::findOrFail($id);

        $entry->content = $validatedData['updated_entry'];
        $entry->save();

        return back()->with('success', 'Entry updated successfully');
    }
/*
    public function destroy($day_id)
    {
        // Assuming you have a Day model and a relationship set up
        $entry = DailyEntry::find($day_id);
        $entry->delete();

        // Redirect back or return a JSON response
        return back()->with('success', 'Entry deleted successfully'); // Or return response()->json(['success' => true]);
    }*/

}

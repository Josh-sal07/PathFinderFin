<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\OfficePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function dashboard()
{
    $offices = Office::with('photos')->paginate(10); // eager load photos if needed
    return view('admin.dashboard', compact('offices'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('admin.offices.create');
}

public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $office = Office::create([
            'name' => $request->name
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store("offices/{$office->id}", 'public');
                OfficePhoto::create([
                    'office_id' => $office->id,
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Office created successfully!');
    }


public function edit(Office $office)
{
    return view('admin.offices.edit', compact('office'));
}

public function update(Request $request, Office $office)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
    ]);

    $oldName = $office->name;
    $office->update(['name' => $validated['name']]);

    // Rename folder if office name changed
    if ($oldName !== $validated['name']) {
        $oldFolder = public_path('offices/' . $oldName);
        $newFolder = public_path('offices/' . $validated['name']);

        if (File::exists($oldFolder)) {
            File::move($oldFolder, $newFolder);
        }

        // Update paths in DB
        foreach ($office->photos as $photo) {
            $photo->update([
                'photo_path' => str_replace("offices/$oldName", "offices/{$validated['name']}", $photo->photo_path)
            ]);
        }
    }

    // Upload new photos
    if ($request->hasFile('photos')) {
        $folder = public_path('offices/' . $office->name);

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        foreach ($request->file('photos') as $index => $photo) {
            $filename = 'step_' . time() . '_' . $index . '.' . $photo->getClientOriginalExtension();
            $photo->move($folder, $filename);

            // Save with the same column name used in store()
            OfficePhoto::create([
                'office_id' => $office->id,
                'photo_path' => 'offices/' . $office->name . '/' . $filename,
            ]);
        }
    }

    return redirect()->route('dashboard')->with('success', 'Office updated successfully!');
}


public function destroy($id)
{
    $office = Office::findOrFail($id);

    // Define the folder path
    $folderPath = public_path('offices/' . $office->name);

    // Delete folder and its contents if it exists
    if (File::exists($folderPath)) {
        File::deleteDirectory($folderPath);
    }

    // Delete the office record from database
    $office->delete();

    return redirect()->back()->with('success', 'Office and photos deleted successfully!');
}
    /**
     * Display the specified resource.
     */
  public function show(Office $office)
{
    $photos = $office->photos; // get the related photos from the OfficePhoto model

    return view('admin.offices.show', compact('office', 'photos'));
}



  public function destroyPhoto(OfficePhoto $photo)
    {
        // Delete the photo from storage if it exists
        if ($photo->photo_path && Storage::exists($photo->photo_path)) {
            Storage::delete($photo->photo_path);
        }

        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }

 

}

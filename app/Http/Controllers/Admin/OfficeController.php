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
     $office->load('photos');
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

    // Rename folder if office name changed (optional, you may skip if using office ID folder)
    // But since store uses office ID as folder name, no need to rename folders.
    // If you want to keep office name folder, you'll need to switch store() as well.

    // Upload new photos (match store() method: use storage disk 'public' and office ID folder)
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store("offices/{$office->id}", 'public');

            OfficePhoto::create([
                'office_id' => $office->id,
                'photo_path' => $path,
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

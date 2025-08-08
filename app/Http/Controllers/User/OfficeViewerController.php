<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;

class OfficeViewerController extends Controller
{
    //
     public function index()
{
    $offices = Office::all(); // Fetch all offices from DB
    return view('selectOffices.index', compact('offices'));
}
    public function show($id)
    {
        $office = Office::with(['photos'])->findOrFail($id);

        $photos = $office->photos->sortBy('photo_path')->values(); // sort by filename (e.g., step_0, step_1)

        return view('users.navigate', compact('office', 'photos'));
    }
}

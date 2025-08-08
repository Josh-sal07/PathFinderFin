<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use Illuminate\Support\Facades\Storage;

class NavigationController extends Controller
{
    public function show($officeId, $step)
    {
        $office = Office::findOrFail($officeId);
        $folderName = strtolower($office->name); // e.g. 'registrar'
        $extensions = ['png', 'jpg', 'jpeg'];
        $found = false;

        foreach ($extensions as $ext) {
            $path = "paths/{$folderName}/step_{$step}." . $ext;
            if (file_exists(public_path($path))) {
                $photoPath = $path;
                $found = true;
                break;
            }
        }

        if (!$found) {
            abort(404, 'Step image not found.');
        }

        // Optional label per step (could be replaced by DB or JSON file later)
        $labels = [
            0 => 'Start Here',
            1 => 'Go Straight',
            2 => 'Turn Left',
            3 => 'Room Ahead',
        ];

        $label = $labels[$step] ?? null;

       return view('navigation.step', [
    'photoPath' => $photoPath,
    'step' => $step,
    'office' => $office, // Required for $office->id
]);
    }

  public function navigate(Office $office, Request $request)
{
    $step = $request->input('step', 0); // default to step 0
    $photoPath = "offices/{$office->name}/step_{$step}.png";

    // Check if the file exists
    if (!Storage::disk('public')->exists($photoPath)) {
        return redirect()->route('selectOffices.index')->with('error', 'Navigation step not found.');
    }

    return view('users.navigate', [
        'office' => $office,
        'step' => $step,
        'photoPath' => asset("storage/{$photoPath}"),
        'nextStepExists' => Storage::disk('public')->exists("offices/{$office->name}/step_" . ($step + 1) . ".png"),
    ]);
}
}

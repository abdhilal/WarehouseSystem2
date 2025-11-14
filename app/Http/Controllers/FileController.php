<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Exports\FilesExport;
use App\Imports\FilesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateFileRequest;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = File::query();

        $query->where('warehouse_id', $user->warehouse_id);


        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('path', 'like', "%{$search}%");
            });
        }

        if ($request->filled('month')) {
            $query->where('month', (int) $request->input('month'));
        }
        if ($request->filled('year')) {
            $query->where('year', (int) $request->input('year'));
        }

        $files = $query->latest()->paginate(20);
        return view('pages.files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function upload()
    {
        return view('pages.files.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');
        $filename = 'FILE-' . now()->timestamp . '-00-' . $request['month'] . '-' . $request['year'] . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/files', $filename, 'public');

        $fileRecord = File::create([
            'code'         =>  $filename,
            'month'        => (int) $request->month,
            'year'         => (int) $request->year,
            'warehouse_id' => auth()->user()->warehouse_id,
            'path'         => $path,
        ]);

        Excel::import(new FilesImport($fileRecord->id, auth()->user()->warehouse_id), $file);
        return redirect()->route('files.index')
            ->with('success', __('File imported successfully.'));
    }


    public function downloadFile($id)
    {
        $file = File::findOrFail($id);

        if (!$file->path || !Storage::disk('public')->exists($file->path)) {
            abort(404);
        }

        return response()->download(storage_path('app/public/' . $file->path), basename($file->path));
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($file)
    {
        $file = File::findOrFail($file);
        if ($file->path) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();
        return redirect()->back()->with('success', __('File deleted successfully.'));
    }

    /**
     * Export the specified resource from storage.
     */
    public function export()
    {
        $filename = 'FILE-STANDER-' . now()->format('Y-m-d');
        return Excel::download(new FilesExport, $filename . '.xlsx');
    }
}

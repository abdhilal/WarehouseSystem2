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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {



        $fileRecord = File::create([
            'code' => 'FILE-' . now()->timestamp,
            'month' => $request->month,
            'year'  => $request->year,
            'warehouse_id' => auth()->user()->warehouse_id
        ]);
        $fileRecord->path = $request->file('file')->store('files');
        $fileRecord->save();




        Excel::import(new FilesImport($fileRecord->id, auth()->user()->warehouse_id), $request->file('file'));
        return response()->json(['success' => 'File imported successfully!']);
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
    public function destroy(File $file)
    {
        //
    }

    /**
     * Export the specified resource from storage.
     */
    public function export()
    {
        return Excel::download(new FilesExport, 'files.xlsx');
    }
}

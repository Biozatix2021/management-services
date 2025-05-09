<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pengaturan::first();
        return view('pengaturan', [
            'data' => $data,
        ]);
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
    public function store(Request $request)
    {
        $rules = [
            'logo_perusahaan' => 'required|mimes:jpeg,png,jpg|max:5048',
        ];

        $text = [
            'nama_perusahaan.required' => 'Nama Perusahaan tidak boleh kosong',
            'logo_perusahaan.required' => 'Logo Perusahaan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        if ($request->hasFile('logo_perusahaan')) {
            $file = $request->file('logo_perusahaan');
            $filename = 'app-icon.' . $file->getClientOriginalExtension();
            $file->storeAs('public/logo', $filename);
            $destinationPath = public_path('img'); // Folder tujuan
            $file->move($destinationPath, $filename);
        }

        // Save the settings to the database
        Pengaturan::updateOrCreate(
            ['id' => 1],
            [
                'nama_perusahaan' => $request->input('nama_perusahaan'),
                'logo_perusahaan' => isset($filename) ? $filename : null,
                'prefix_url' => $request->input('prefix_url'),
            ]
        );

        return response()->json(['success' => 1, 'text' => 'Pengaturan berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

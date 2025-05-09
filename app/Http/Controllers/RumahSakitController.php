<?php

namespace App\Http\Controllers;

use App\Models\rumah_sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RumahSakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return rumah_sakit::all();

        if (request()->ajax()) {
            $data = rumah_sakit::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('lokasi', function ($data) {
                    $lokasi = '
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="https://www.google.com/maps/search/?api=1&query=' . $data->latitude . ',' . $data->longitude . '" target="_blank" ><span class="badge badge-danger">Lihat Lokasi</span></a>
                                </div>';
                    return $lokasi;
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-warning btn-block" onclick="edit_data(' . $data->id . ')">Edit</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-block" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['action', 'lokasi'])
                ->make(true);
        }

        return view('m_data_rumah_sakit');
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
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $text = [
            'nama.required' => 'Nama Rumah Sakit Harus Diisi !',
            'latitude.required' => 'Latitude Harus Diisi !',
            'longitude.required' => 'Longitude Harus Diisi !',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            # code...
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        rumah_sakit::updateOrCreate(
            ['id' => $request->id],
            [
                'nama' => $request->nama,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );
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

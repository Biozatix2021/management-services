<?php

namespace App\Http\Controllers;

use App\Models\teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return teknisi::all();
        if (request()->ajax()) {
            $data = teknisi::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = ' <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="edit_data(' . $data->id . ')"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="delete_data(' . $data->id . ')"><i class="fas fa-trash"></i></button>
                                </div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('m_data_teknisi');
    }

    public function search_teknisi(Request $request)
    {
        $data = teknisi::where('nama', 'like', '%' . $request->search . '%')->get();
        return response()->json($data);
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
            'nama'              => 'required',
            'no_hp'             => 'required',
            'color'             => 'required',
        ];

        $text = [
            'nama.required' => 'Nama Teknisi Harus Diisi !',
            'no_hp.required' => 'No HP Teknisi Harus Diisi !',
            'color.required' => 'Silahkan Pilih Warna Untuk Teknisi !',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            # code...
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        teknisi::updateOrCreate(
            ['id' => $request->id],
            [
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'color' => $request->color,
            ]
        );

        return response()->json(['status' => true]);
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
        $data = teknisi::find($id);
        return response()->json($data);
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
        $data = teknisi::find($id);
        $data->delete();
    }
}

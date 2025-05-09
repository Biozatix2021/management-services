<?php

namespace App\Http\Controllers;

use App\Models\Garansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GaransiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Garansi::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-block btn-primary" onclick="edit_data(' . $data->id . ')">Edit</button>
                                    <button type="button" class="btn btn-xs btn-block btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('m_data_garansi');
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
            'IDGaransi' => 'required',
            'nama_garansi' => 'required',
            'durasi' => 'required',
            'penyedia' => 'required',
        ];

        $text = [
            'ID_garansi.required' => 'ID Garansi wajib diisi',
            'nama_garansi.required' => 'Nama Garansi wajib diisi',
            'durasi.required' => 'Durasi wajib diisi',
            'penyedia.required' => 'Penyedia wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $data = Garansi::updateOrCreate(
            [
                'ID_garansi' => $request->IDGaransi,
            ],
            [
                'ID_garansi' => $request->IDGaransi,
                'nama_garansi' => $request->nama_garansi,
                'durasi' => $request->durasi,
                'penyedia' => $request->penyedia,
                'catatan_tambahan' => $request->catatan_tambahan,
            ]
        );

        return response()->json(['success' => 1, 'text' => 'Data berhasil disimpan']);
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
        $data = Garansi::find($id);
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
        $data = Garansi::find($id);
        $data->delete();
        return response()->json(['success' => 1, 'text' => 'Data berhasil dihapus']);
    }
}

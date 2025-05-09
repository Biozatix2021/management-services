<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\sop_alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SopAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request('filter');
        $alat = Alat::select('id', 'nama', 'tipe')->get();
        // return $alat;
        if (request()->ajax()) {
            $data = sop_alat::select('id', 'alat_id', 'item')
                ->where('alat_id', $filter)
                ->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('m_data_sop_alat', [
            'alats' => $alat,
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
            'alat_id' => 'required',
        ];

        $text = [
            'alat_id.required' => 'ID Alat tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            # code...
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $alat_id = $request->input('alat_id');
        $item = $request->input('item');

        foreach ($item as $key => $value) {
            sop_alat::create([
                'alat_id' => $alat_id,
                'item' => $value,
            ]);
        }

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

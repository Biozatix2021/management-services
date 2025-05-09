<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\sop_alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Alat::where('is_deleted', 0);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('gambar', function ($data) {
                    $url = asset('storage/alat/' . $data->gambar);
                    return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <button type="button" class="btn btn-block btn-xs btn-primary" onclick="show_data(' . $data->id . ')">Lihat SOP</button>
                                    <button type="button" class="btn btn-block btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </center>';
                    return $button;
                })
                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        return view('m_data_alat');
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

        // dd($request->all());
        $rules = [
            'nama_alat'              => 'required',
            'merk'              => 'required',
            'tipe'              => 'required',
            'gambar'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $text = [
            'nama.required' => 'Nama Alat Harus Diisi !',
            'merk.required' => 'Merk Alat Harus Diisi !',
            'tipe.required' => 'Type Alat Harus Diisi !',
            'gambar.required' => 'Anda belum memilih gambar !',

        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            # code...
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('alat', $file, $filename);
            $request->merge(['gambar' => $filename]);
        }


        if ($path) {
            Alat::create([
                'nama'          => $request->nama_alat,
                'merk'          => $request->merk,
                'tipe'          => $request->tipe,
                'gambar'        => $filename,
            ]);
        }
        return response()->json(['status'   => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find data alat with sop_alat
        $data = sop_alat::where('alat_id', $id)->get();
        return response()->json($data);
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
        $data = Alat::find($id);
        Storage::disk('public')->delete('alat/' . $data->gambar);
        $data->is_deleted = 1;
        $data->save();
        return response()->json(['status' => true]);
    }
}

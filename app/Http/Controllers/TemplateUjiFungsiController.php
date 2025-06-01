<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\M_Uji_Fungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class TemplateUjiFungsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request('filter');
        $alat = Alat::select('id', 'brand', 'nama', 'tipe')
            ->where('is_deleted', 0)
            ->get();

        // return $alat;

        if (request()->ajax()) {
            $data = M_Uji_Fungsi::where('alat_id', $filter)->get();
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
        return view('m_template_uji_fungsi', [
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
        $qty = $request->input('qty');
        $satuan = $request->input('satuan');

        foreach ($item as $key => $value) {
            $data = new M_Uji_Fungsi();
            $data->alat_id = $alat_id;
            $data->item = $value;
            $data->qty = $qty[$key];
            $data->satuan = $satuan[$key];
            $data->save();
        }

        // clear cache
        Cache::forget('dbtemplate-' . $alat_id);

        return response()->json(['success' => 1, 'text' => 'Data berhasil disimpan'], 200);
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
        $data = M_Uji_Fungsi::find($id);
        $data->delete();
        return response()->json(['success' => 1, 'text' => 'Data berhasil dihapus'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Data_Uji_Fungsi;
use App\Models\DataUjiFungsi;
use App\Models\DetailUjiFungsi;
use App\Models\M_Uji_Fungsi;
use App\Models\teknisi;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DataUjiFungsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = request('filter');
        $alat = Alat::select('id', 'merk', 'nama', 'tipe')->get();
        $template = M_Uji_Fungsi::select('id', 'item', 'qty', 'satuan')->get();

        if (request()->ajax()) {
            if ($filter == null) {
                $data = DataUjiFungsi::all();
            } else {
                $data = DataUjiFungsi::where('alat_id', $filter)->get();
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <button type="button" class="btn btn-xs btn-primary btn-block" onclick="showData(' . $data->id . ')">Detail</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-block" onclick="delete_data(' . $data->id . ')">Delete</button>
                               </center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('v_uji_fungsi', [
            'alats' => $alat,
            'templates' => $template,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $alat = Alat::select('id', 'merk', 'nama', 'tipe')
            ->where('is_deleted', 0)
            ->get();
        $teknisi = teknisi::select('id', 'nama')->get();
        $template = M_Uji_Fungsi::select('id', 'item', 'qty', 'satuan')->get();
        return view('create_uji_fungsi', [
            'alats' => $alat,
            'templates' => $template,
            'teknisis' => $teknisi,
        ]);
    }

    public function form_qc(Request $request)
    {
        $alat_Id = request('alat_id');
        $teknisi = teknisi::select('id', 'nama')->get();
        $alat = Alat::select('id', 'merk', 'nama', 'tipe')
            ->where('id', $alat_Id)
            ->where('is_deleted', 0)
            ->get();

        $template = Cache::remember('dbtemplate-' . $alat_Id, 3600, function () use ($alat_Id) {
            return M_Uji_Fungsi::where('alat_id', $alat_Id)->get();
        });

        return response()->json([
            'alats' => $alat,
            'templates' => $template,
        ]);
    }

    public function validate_no_seri(Request $request)
    {
        $no_seri = request('no_seri');
        $data = DataUjiFungsi::where('no_seri', $no_seri)->first();
        if ($data) {
            return response()->json(['success' => 0, 'text' => 'No Seri sudah ada']);
        } else {
            return response()->json(['success' => 1, 'text' => 'No Seri belum ada']);
        }
    }

    public function upload_foto(Request $request)
    {
        $foto = $request->file('foto');
        $filename = time() . $foto->getClientOriginalName();
        $foto = Storage::disk('public')->putFileAs('temp_foto_dokumentasiQC', $foto, $filename);

        return response()->json(['success' => 1, 'text' => 'Foto berhasil diupload', 'foto' => $filename]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'no_seri' => 'required|unique:data_uji_fungsis,no_seri',
            'tgl_terima' => 'required',
            'tgl_selesai' => 'required',
        ];

        $messages = [
            'foto.*.required' => 'Foto harus diisi',
            'foto.*.image' => 'Foto harus berupa gambar',
            'foto.*.mimes' => 'Foto harus berformat jpeg, png, jpg, gif, svg',
            'foto.*.max' => 'Foto maksimal 10MB',
            'no_seri.required' => 'No Seri harus diisi',
            'no_seri.unique' => 'No Seri sudah ada',
            'tgl_terima.required' => 'Tanggal Terima harus diisi',
            'tgl_selesai.required' => 'Tanggal Selesai harus diisi',
            'teknisi.required' => 'Anda belum memilih teknisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();

        try {
            $data = DataUjiFungsi::create([
                'alat_id' => $request->alat_id,
                'no_seri' => $request->no_seri,
                'no_order' => $request->no_order,
                'no_faktur' => $request->no_faktur,
                'tgl_faktur' => date('Y-m-d', strtotime($request->tgl_faktur)),
                'tgl_terima' => date('Y-m-d', strtotime($request->tgl_terima)),
                'tgl_selesai' => date('Y-m-d', strtotime($request->tgl_selesai)),
                'status' => 1,
                'id_teknisi' => $request->teknisi,
                'keterangan' => $request->keterangan,
                'is_deleted' => 0,
                'created_by_user_id' => 2,
            ]);

            // save detail uji fungsi
            $foto = $request->foto_item;
            $index = 0;

            foreach ($foto as $key => $value) {

                // move foto from temp to foto_dokumentasiQC
                Storage::disk('public')->move('temp_foto_dokumentasiQC/' . $value, 'foto_dokumentasiQC/' . $value);



                DetailUjiFungsi::create([
                    'data_uji_fungsi_id' => $data->id,
                    'item' => $request->item_check[$index],
                    'qty' => $request->qty_item[$index],
                    'satuan' => $request->satuan_item[$index],
                    'status' => 1,
                    'foto' => $value
                ]);

                $index++;
            }

            DB::commit();
            return response()->json(['success' => 1, 'text' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => 0, 'text' => 'Data gagal disimpan', 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $data = DataUjiFungsi::find($id);
        $data = DataUjiFungsi::with('detail_uji_fungsi', 'alat', 'teknisi', 'user')->find($id);
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
        //
    }
}

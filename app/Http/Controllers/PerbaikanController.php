<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\FotoServices;
use App\Models\LampiranServices;
use App\Models\Perusahaan;
use App\Models\Service;
use App\Models\ServicesSparepart;
use App\Models\teknisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\kodeInstalasiBiozatix;
use function App\Helpers\kodeServisBiozatix;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = kodeServisBiozatix(1);
        $alat = Alat::all();
        $perusahaan = Perusahaan::all();

        if ($request->ajax()) {
            $data = Service::with('alat', 'teknisi')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->service_status == 0) {
                        return '<span class="badge badge-primary">On Process</span>';
                    } else {
                        return '<span class="badge badge-success">Selesai</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <button type="button" class="btn btn-xs btn-block btn-primary" onclick="show_data(' . $data->id . ')">Show</button>
                                    <button type="button" class="btn btn-danger btn-block btn-xs" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </center>';
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('v_data_service', [
            'alats'  => $alat,
            'perusahaans' => $perusahaan,
            'code' => $code,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $alat = Alat::all();
        $teknisi = teknisi::all();
        $perusahaan = Perusahaan::all();
        $code = kodeServisBiozatix(1);

        return view('create_services', [
            'alats' => $alat,
            'teknisis' => $teknisi,
            'perusahaans' => $perusahaan,
            'code' => $code,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return $request->all();

        $rules = [
            'no_seri' => 'required',
            'service_name' => 'required',
            'keluhan' => 'required',
            'service_description' => 'nullable',
            'service_duration' => 'required',
            'teknisi_id' => 'required',
        ];

        $messages = [
            'no_seri.required' => 'No Seri Alat Harus Diisi',
            'service_name.required' => 'Title Harus Diisi',
            'service_type.required' => 'Silahkan Pilih Tipe Service',
            'keluhan.required' => 'Keluhan Harus Diisi',
            'service_description.required' => 'Deskripsi Service Harus Diisi',
            'service_price.required' => 'Harga Service Harus Diisi',
            'service_duration.required' => 'Durasi Service Harus Diisi',
            'service_status.required' => 'Status Service Harus Diisi',
            'teknisi_id.required' => 'Teknisi Harus Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();

        try {

            $data = Service::create([
                'service_code' => kodeServisBiozatix($request->perusahaan_id),
                'alat_id' => $request->alat_Id,
                'no_seri' => $request->no_seri,
                'service_name' => $request->service_name,
                'service_type' => $request->service_type,
                'service_date' => $request->service_date,
                'keluhan' => $request->keluhan,
                'service_description' => $request->service_description,
                'service_duration' => $request->service_duration,
                'perusahaan_id' => $request->perusahaan_id,
                'teknisi_id' => session('id'),
                'created_by' => session('name'),
            ]);

            foreach ($request->nama_sparepart as $item => $value) {
                ServicesSparepart::create([
                    'service_id' => $data->id,
                    'nama_sparepart' => $request->nama_sparepart[$item],
                    'qty' => $request->jumlah_sparepart[$item],
                ]);
            }

            if ($request->hasFile('foto_services')) {
                foreach ($request->file('foto_services') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('foto_services', $filename, 'public');
                    FotoServices::create([
                        'service_code' => $data->service_code,
                        'path' => $path,
                    ]);
                }
            }


            if ($request->hasFile('file_lampiran')) {
                foreach ($request->file('file_lampiran') as $index => $file) {
                    $filename = $request->nama_lampiran[$index] . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('lampiran_services', $filename, 'public');
                    LampiranServices::create([
                        'service_code' => $data->service_code,
                        'lampiran_name' => $request->nama_lampiran[$index],
                        'lampiran_path' => $path
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'success' => 1,
                'text' => 'Data Berhasil Disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => 0,
                'text' => 'Data gagal disimpan',
                'error' => $e->getMessage()
            ], 422);
        }
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

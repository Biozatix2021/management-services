<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DataUjiFungsi;
use App\Models\FotoInstalasi;
use App\Models\Garansi;
use App\Models\Instalasi_Alat;
use App\Models\LampiranInstalasi;
use App\Models\Pengaturan;
use App\Models\Perusahaan;
use App\Models\rumah_sakit;
use App\Models\Service;
use App\Models\teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function App\Helpers\kodeInstalasiBiozatix;

class InstalasiAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $teknisi = Instalasi_Alat::select('teknisi')->distinct()->get();
        // $data = json_decode($teknisi[0]->teknisi);

        // return response()->json($data);
        $perusahaan = Perusahaan::select('id', 'nama')->get();

        $filter_perusahaan = $request->perusahaan;
        $filter_status_instalasi = $request->status_instalasi;

        if (request()->ajax()) {
            if ($filter_perusahaan != null && $filter_status_instalasi == null) {
                $data = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')
                    ->where('perusahaan_id', $filter_perusahaan)
                    ->get();
            } elseif ($filter_status_instalasi != null && $filter_perusahaan == null) {
                # code...
                $data = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')
                    ->where('status_instalasi', $filter_status_instalasi)
                    ->get();
            } else if ($filter_perusahaan != null && $filter_status_instalasi != null) {
                $data = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')
                    ->where('status_instalasi', $filter_status_instalasi)
                    ->where('perusahaan_id', $filter_perusahaan)
                    ->get();
            } else {
                $data = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')->get();
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <a href="' . route('instalasi-alat.show', encrypt($data->id)) . '" class="btn btn-info btn-block btn-sm" title="Detail" target="_blank">Detail</a>
                                </center>';
                    return $button;
                })
                ->addColumn('teknisi', function ($data) {
                    $teknisi = json_decode($data->teknisi);
                    $badges = '';
                    if (is_array($teknisi)) {
                        foreach ($teknisi as $t) {
                            $badges .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($t) . '</span>';
                        }
                    }
                    return $badges;
                })
                ->rawColumns(['action', 'teknisi'])
                ->make(true);
        }
        // return $data;
        return view('v_instalasi_alat', [
            'perusahaans' => $perusahaan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function upload_foto_instalasi(Request $request)
    {
        $foto = $request->file('foto_instalasi');
        $filename = time() . $foto->getClientOriginalName();
        $foto = Storage::disk('public')->putFileAs('temp_foto_instalasi', $foto, $filename);

        return response()->json(['success' => 1, 'text' => 'Foto berhasil diupload', 'foto' => $filename]);
    }

    public function get_alat($id)
    {
        $alat = DataUjiFungsi::where('alat_id', $id)->get();
        return response()->json($alat);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rumah_sakit = rumah_sakit::all();
        $perusahaan = Perusahaan::all();
        $garansi = Garansi::all();
        $alat = Alat::all();
        $teknisi = teknisi::all();
        return view('create_instalasi_alat', [
            'rumah_sakits' => $rumah_sakit,
            'perusahaans' => $perusahaan,
            'alats' => $alat,
            'teknisis' => $teknisi,
            'garansis' => $garansi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $rules = [
            'rumah_sakit_id' => 'required',
            'perusahaan_id' => 'required',
            'statusInstalasi' => 'required',
            'tgl_instalasi' => 'required',
            'alat_Id' => 'required',
            'no_seri' => 'required',
            'teknisi_id.*' => 'required',
            'foto_instalasi.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
        ];

        $messages = [
            'rumah_sakit_id.required' => 'Rumah Sakit harus diisi',
            'perusahaan_id.required' => 'Perusahaan harus diisi',
            'statusInstalasi.required' => 'Status Instalasi harus diisi',
            'tgl_instalasi.required' => 'Tanggal Instalasi harus diisi',
            'alat_Id.required' => 'Alat harus diisi',
            'no_seri.required' => 'No Seri harus diisi',
            'teknisi_id.required' => 'Teknisi harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();

        try {

            // cek logo berdasarkan instansi penginstalan
            if ($request->perusahaan_id == 1) {
                $logo = '/public/img/logo_biozatix.png';
            } elseif ($request->perusahaan_id == 2) {
                $logo = '/public/img/logo_vantage.png';
            } elseif ($request->perusahaan_id == 3) {
                $logo = '/public/img/logo_flexylabs.png';
            } else {
                $logo = '/public/img/logo_biozatix.png';
            }


            $prefixURL = Pengaturan::select('prefix_url')->first();
            $qrcode = QrCode::size(1000)
                ->format('png')->merge($logo, .3)
                ->errorCorrection('H')
                ->margin(2)
                ->generate(
                    $prefixURL->prefix_url . '?serial_number=' . $request->no_seri
                );
            $qrcode_path = 'qrcode/' . kodeInstalasiBiozatix() . '.png';
            Storage::disk('public')->put($qrcode_path, $qrcode);

            $data = Instalasi_Alat::create([
                'kode_instalasi' => kodeInstalasiBiozatix(),
                'rumah_sakit_id' => $request->rumah_sakit_id,
                'perusahaan_id' => $request->perusahaan_id,
                'status_instalasi' => $request->statusInstalasi,
                'tanggal_instalasi' => $request->tgl_instalasi,
                'tipe_garansi' => $request->garansi,
                'aktif_garansi' => $request->aktif_garansi,
                'habis_garansi' => $request->habis_garansi,
                'qrcode_path' => $qrcode_path,
                'alat_id' => $request->alat_Id,
                'no_seri' => $request->no_seri,
                'teknisi' => json_encode($request->teknisi),
                'user_id' => session('id'),
            ]);


            if ($request->hasFile('foto_instalasi')) {
                foreach ($request->file('foto_instalasi') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('foto_instalasi', $filename, 'public');

                    FotoInstalasi::create([
                        'kode_instalasi' => $data->kode_instalasi,
                        'path' => $path,
                    ]);
                }
            }

            if ($request->hasFile('file_lampiran')) {
                foreach ($request->file('file_lampiran') as $index => $file) {
                    $filename = $request->nama_lampiran[$index] . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('file_lampiran', $filename, 'public');

                    LampiranInstalasi::create([
                        'kode_instalasi' => $data->kode_instalasi,
                        'nama_dokumen' => $request->nama_lampiran[$index],
                        'path' => $path,
                    ]);
                }
            }




            DB::commit();
            return response()->json([
                'success' => 1,
                'text' => 'Data berhasil disimpan',
            ]);
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

        $instalasi_alat = Instalasi_Alat::with('alat', 'perusahaan', 'rumah_sakit', 'teknisi', 'user')->find(decrypt($id));
        $foto_instalasi = FotoInstalasi::where('kode_instalasi', $instalasi_alat->kode_instalasi)->get();
        $lampiran = LampiranInstalasi::where('kode_instalasi', $instalasi_alat->kode_instalasi)->get();
        $data_uji_fungsi = DataUjiFungsi::where('no_seri', $instalasi_alat->no_seri)->get();
        $data_services = Service::where('no_seri', $instalasi_alat->no_seri)->get();

        return view('detail_instalasi_alat', [
            'data' => $instalasi_alat,
            'foto_instalasi' => $foto_instalasi,
            'lampiran' => $lampiran,
            'data_uji_fungsi' => $data_uji_fungsi,
            'garansi' => Garansi::all(),
            'teknisi' => json_decode($instalasi_alat->teknisi),
            'services' => $data_services,
        ]);
    }

    public function get_uji_fungsi($id)
    {
        $instalasi = Instalasi_Alat::find($id);
        $data = DataUjiFungsi::with('detail_uji_fungsi', 'alat', 'teknisi', 'user')->where('no_seri', $instalasi->no_seri)->first();
        return response()->json($data);
    }

    /**
     * Download qrcode.
     */

    public function download_qrcode($id)
    {
        $instalasi_alat = Instalasi_Alat::find($id);
        $path = public_path('storage/' . $instalasi_alat->qrcode_path);
        return response()->download($path);
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
        $instalasi_alat = Instalasi_Alat::find($id);
        if ($instalasi_alat) {
            $instalasi_alat->delete();
            return response()->json(['success' => 1, 'text' => 'Data berhasil dihapus']);
        } else {
            return response()->json(['success' => 0, 'text' => 'Data tidak ditemukan']);
        }
    }
}

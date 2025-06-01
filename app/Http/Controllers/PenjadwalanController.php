<?php

namespace App\Http\Controllers;

use App\Models\Penjadwalan;
use App\Models\teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PenjadwalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teknisi = teknisi::all();
        if (request()->ajax()) {
            $data = Penjadwalan::with('teknisi');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 0) {
                        return '<span class="badge badge-primary">On Process</span>';
                    } else {
                        return '<span class="badge badge-success">Selesai</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('v_penjadwalan', [
            'teknisis' => $teknisi,
        ]);
    }

    public function kalender_teknisi()
    {
        $jadwal = Penjadwalan::all();
        $teknisi = teknisi::all();
        $data = Penjadwalan::with('teknisi')->get();

        $events = Penjadwalan::with('teknisi')->get();
        $data_event = [];

        foreach ($events as $row) {
            if ($row->fullday == 1) {
                $allDay = true;
            } else {
                $allDay = false;
            }

            $data_event[] = [
                'id' => $row->id,
                'title' => $row->title,
                'start' => $row->start,
                'end' => $row->end,
                'teknisi' => $row->teknisi->nama,
                'status' => $row->status,
                'backgroundColor' => $row->teknisi->color,
                'allDay' => $allDay,
                'keterangan' => $row->keterangan,
            ];
        }

        // return $data_event;

        return view('v_kalender_teknisi', [
            'data' => $data,
            'teknisis' => $teknisi,
            'jadwal' => $jadwal,
            'data_event' => $data_event,
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
            'title' => 'required',
            'teknisi' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ];

        $text = [
            'teknisi_id.required' => 'Teknisi harus dipilih',
            'title.required' => 'Title harus diisi',
            'start.required' => 'Tanggal mulai harus diisi',
            'start.date' => 'Format tanggal mulai tidak valid',
            'end.required' => 'Tanggal selesai harus diisi',
            'end.date' => 'Format tanggal selesai tidak valid',
            'end.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'keterangan.required' => 'Keterangan harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $data = Penjadwalan::create([
            'teknisi_id' => $request->teknisi,
            'groupId' => $request->groupId,
            'title' => $request->title,
            'start' => date('Y-m-d H:i:s', strtotime($request->start)),
            'end' => date('Y-m-d H:i:s', strtotime($request->end)),
            'fullday' => $request->fullday,
            'keterangan' => $request->keterangan,
            'status' => 0,
        ]);

        $teknisi = teknisi::where('no_hp', $data->teknisi_id)->first();
        // Send WhatsApp notification using Fonnte API
        $apiKey = '8RezdZZbCYB6FQCHgaTk';
        $phoneNumber = $teknisi; // Assuming the phone number is passed in the request
        $message = "Jadwal baru telah dibuat:\n\n" .
            "Title: {$request->title}\n" .
            "Teknisi: {$request->teknisi}\n" .
            "Start: {$request->start}\n" .
            "End: {$request->end}\n" .
            "Keterangan: {$request->keterangan}";

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => $phoneNumber,
            'message' => $message,
            'countryCode' => '62', // Replace with the appropriate country code
        ]);

        if ($response->failed()) {
            return response()->json(['success' => 0, 'text' => 'Data berhasil disimpan, tetapi gagal mengirim WhatsApp'], 500);
        }



        return response()->json(['success' => 1, 'text' => 'Data berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
        $data = Penjadwalan::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => 1, 'text' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['success' => 0, 'text' => 'Data tidak ditemukan'], 404);
        }
    }
}

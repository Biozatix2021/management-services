<?php

namespace App\Http\Controllers;

use App\Models\Instalasi_Alat;
use App\Models\Penjadwalan;
use App\Models\rumah_sakit;
use App\Models\Service;
use App\Models\teknisi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // return session('role');

        $jadwal = Penjadwalan::all();
        $teknisi = teknisi::all();
        $data = Penjadwalan::with('teknisi')->get();

        $events = Penjadwalan::with('teknisi')
            ->where('teknisi_id', session('id'))
            ->get();
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


        $instalasi_alat = Instalasi_Alat::with('rumah_sakit')->get();

        $terinstal = [];
        foreach ($instalasi_alat as $row) {
            $terinstal[] = [
                'name'  => $row->alat->merk,
                'latitude' => $row->rumah_sakit->latitude,
                'longitude' => $row->rumah_sakit->longitude,
                'title' => $row->rumah_sakit->nama_rumah_sakit,
            ];
        }

        $total_instalasi_alat = $instalasi_alat->count();

        $services = Service::selectRaw('DATEDIFF(service_end_date, service_start_date) as duration')
            ->whereNotNull('service_start_date')
            ->whereNotNull('service_end_date')
            ->get();

        $total_duration = $services->sum('duration');
        $service_count = $services->count();

        $average_maintenance_duration = $service_count > 0 ? $total_duration / $service_count : 0;


        $teknisis = teknisi::all();

        $rumah_sakit = rumah_sakit::count();
        // return $average_maintenance_duration;
        return view('welcome', [
            'instalasi_alat' => $instalasi_alat,
            'total_instalasi_alat' => $total_instalasi_alat,
            'location' => $terinstal,
            'average_maintenance_duration' => $average_maintenance_duration,
            'teknisi' => $teknisis->count(),
            'teknisis' => $teknisis,
            'rumah_sakit' => $rumah_sakit,
            'data_event' => $data_event,

        ]);
    }
}

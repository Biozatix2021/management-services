<?php

namespace App\Helpers;

use App\Models\Service;

function kodeServisBiozatix($perusahaan_id)
{
    $cek = Service::where('perusahaan_id', $perusahaan_id)->orderBy('id', 'desc')->first();
    $years = date('y');
    $months = date('m');

    if ($cek == null) {
        $urut = '0001';
        $kode = "SRV-" . $years . $months . "-" . $urut;
    } else {
        $data = explode('-', $cek->service_code);
        $urut = (int) $data[2] + 1;
        if ($urut < 10) {
            $urut = "000" . $urut;
        } elseif ($urut < 100) {
            $urut = "00" . $urut;
        } elseif ($urut < 1000) {
            $urut = "0" . $urut;
        } else {
            $urut = $urut;
        }
        $kode = "SRV-" . $years . $months . "-" . $urut;
    }

    return $kode;
}

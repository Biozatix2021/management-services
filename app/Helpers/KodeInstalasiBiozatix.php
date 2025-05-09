<?php

namespace App\Helpers;

use App\Models\Instalasi_Alat;

function kodeInstalasiBiozatix()
{
    $cek = Instalasi_Alat::where('kode_instalasi', 'like', 'BZT%')->orderBy('id', 'desc')->first();
    $years = date('y');
    $months = date('m');

    if ($cek == null) {
        $urut = '0001';
        $kode = "BZT-" . $years . $months . "-" . $urut;
    } else {
        $data = explode('-', $cek->kode_instalasi);
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
        $kode = "BZT-" . $years . $months . "-" . $urut;
    }

    return $kode;
}

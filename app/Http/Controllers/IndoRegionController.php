<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class IndoRegionController extends Controller
{
    // public function getProvinsi()
    // {
    //     $prov = Province::get();

    //     return view('team.create', compact('prov'));
    // }

    public function getKabupaten(Request $request)
    {
        $id_provinsi = $request->id_provinsi;
        $kabupaten = Regency::where('province_id', $id_provinsi)->orderBy('name', 'asc')->get();

        echo "<option disabled selected>--Pilih--</option>";
        foreach ($kabupaten as $kab) {
            echo "<option value='$kab->id'>$kab->name</option>";
        }
    }

    public function getKecamatan(Request $request)
    {
        $id_kabupaten = $request->id_kabupaten;
        $kecamatan = District::where('regency_id', $id_kabupaten)->orderBy('name', 'asc')->get();

        echo "<option disabled selected>--Pilih--</option>";
        foreach ($kecamatan as $kec) {
            echo "<option value='$kec->id'>$kec->name</option>";
        }
    }

    public function getDesa(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;
        $desa = Village::where('district_id', $id_kecamatan)->orderBy('name', 'asc')->get();

        echo "<option disabled selected>--Pilih--</option>";
        foreach ($desa as $d) {
            echo "<option value='$d->id'>$d->name</option>";
        }
    }
}

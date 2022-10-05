<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';

    protected $fillable = [
        'team_id',
        'tps_id',
        'nik',
        'nama',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'status'
    ];


    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function anggota()
    {

        return $anggota = Anggota::join('provinces', 'provinces.id', '=', 'anggota.provinsi_id')
            ->join('regencies', 'regencies.id', '=', 'anggota.kabupaten_id')
            ->join('districts', 'districts.id', '=', 'anggota.kecamatan_id')
            ->join('villages', 'villages.id', '=', 'anggota.desa_id')
            ->join('team', 'team.id', '=', 'anggota.team_id')
            ->join('tps', 'tps.id', '=', 'anggota.tps_id')
            ->select('anggota.id as id', 'anggota.nik as nik', 'anggota.status as status', 'anggota.nama as nama', 'anggota.status as status', 'provinces.name as provinsi_id', 'regencies.name as kabupaten_id', 'districts.name as kecamatan_id', 'villages.name as desa_id', 'team.nama as team_id', 'tps.name as tps_id');
    }


    public  function filterNoDate($team, $kel, $status)
    {
        return $anggota = Anggota::anggota()
            ->where('team_id', $team)
            ->where('desa_id', $kel)
            ->where('status', $status);
    }

    public  function filterKel($kel)
    {
        return $kel = Anggota::anggota()->where('desa_id', $kel);
    }

    public  function filterTeam($team)
    {
        return $team = Anggota::anggota()->where('team_id', $team);
    }

    public  function filterStatus($status)
    {
        return $team = Anggota::anggota()->where('status', $status);
    }

    public  function filterKelStatus($kel, $status)
    {
        return $team = Anggota::anggota()
            ->where('status', $status)
            ->where('desa_id', $kel);
    }

    public  function filterTeamStatus($team, $status)
    {
        return $team = Anggota::anggota()
            ->where('status', $status)
            ->where('team_id', $team);
    }

    public  function filterTeamKel($team, $kel)
    {
        return $team = Anggota::anggota()
            ->where('desa_id', $kel)
            ->where('team_id', $team);
    }

    public function pie_chart_js($min, $max)
    {

        return $pie = DB::table('anggota')
            ->select('name', DB::raw('COUNT(desa_id) as count'))
            ->join('villages', 'villages.id', '=', 'anggota.desa_id')
            ->whereBetween('anggota.created_at', [$min, $max])
            ->groupBy('desa_id', 'name')
            ->get();
    }

    public function getKel()
    {
        return $kel = DB::table('anggota')
            ->select('villages.id', 'villages.name')
            ->join('villages', 'anggota.desa_id', '=', 'villages.id')
            ->distinct()
            ->get();
    }
}

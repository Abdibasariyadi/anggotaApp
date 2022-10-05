<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\District;
use Validator;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Team;
use App\Models\Tps;
use App\Models\Village;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Response;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $title = "Anggota";
        $kel = Anggota::getKel();
        $team = Team::get();
        $tps = Tps::get();

        if ($request->ajax()) {
            $anggota = Anggota::anggota();

            return DataTables::of($anggota)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row->id);
                    $btn = '<a href="' . url('anggota/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                    $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteAnggota">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('anggota.index', compact('title', 'team', 'kel', 'tps'));
    }

    public function filter(Request $request)
    {
        // $min = date('Y-m-d 00:00:00', strtotime($request->get('min')));
        // $max = date('Y-m-d 23:59:59', strtotime($request->get('max')));
        $team = $request->get('team_id');
        $kel = $request->get('kelurahan');
        // $tps = $request->get('tps_id');
        $status = $request->get('status');
        // dd($status);

        if (!empty($team) && !empty($kel) && !empty($status)) {

            if ($team == 'all' && $kel == 'all' && $status == 'all') {

                $service = Anggota::anggota();
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($team == 'all' && $kel == 'all') {

                $service = Anggota::filterStatus($status);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($kel == 'all' && $status == 'all') {

                $service = Anggota::filterTeam($team);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($status == 'all' && $team == 'all') {

                $service = Anggota::filterKel($kel);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($team == 'all') {

                $service = Anggota::filterKelStatus($kel, $status);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($kel == 'all') {

                $service = Anggota::filterTeamStatus($team, $status);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($status == 'all') {

                $service = Anggota::filterTeamKel($team, $kel);
                return Datatables::eloquent($service)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                        $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            $service = Anggota::filterNoDate($team, $kel, $status);
            return Datatables::eloquent($service)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . url('team/edit/' . $row->id) . '" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                    $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteAnggota">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function create()
    {
        $title = "Create Anggota";
        $team = Team::get();
        $prov = Province::get()->where('id', '=', '73');
        $tps = Tps::get();
        return view('anggota.create', compact('title', 'team', 'prov', 'tps'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'tps_id' => 'required',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        Anggota::updateOrCreate(
            ['id' => $request->anggota_id],
            [
                'team_id' => $request->team_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tps_id' => $request->tps_id,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'desa_id' => $request->desa_id,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => 'Anggota Added Successfully!']);
    }

    public function check_nik(Request $request)
    {
        if ($request->input('nik') !== '') {
            if ($request->input('nik')) {
                $rule = array('nik' => 'Required|numeric|unique:anggota');
                $validator = Validator::make($request->all(), $rule);
            }
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');
    }

    public function edit($id)
    {
        $title = "Edit Data Anggota";
        $anggota = Anggota::findOrFail($id);
        $team = Team::get();
        $tps = Tps::get();
        $prov = Province::get()->where('id', '=', '73');
        $kab = Regency::where('province_id', $anggota->provinsi_id)->orderBy('name', 'asc')->get();
        $kec = District::where('regency_id', $anggota->kabupaten_id)->orderBy('name', 'asc')->get();
        $desa = Village::where('district_id', $anggota->kecamatan_id)->orderBy('name', 'asc')->get();
        return view('anggota.edit', compact('anggota', 'title', 'team', 'prov', 'kab', 'kec', 'desa', 'tps'));
    }

    public function update(Request $request, $id)
    {
        $post = Anggota::findOrFail($id);

        $post->update([
            'team_id' => $request->team_id,
            'tps_id' => $request->tps_id,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_id' => $request->kecamatan_id,
            'desa_id' => $request->desa_id,
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Anggota Added Successfully!']);
    }

    public function destroy($id)
    {
        Anggota::find($id)->delete();
        return response()->json(['success' => 'Role Delete Successfully!']);
    }
}

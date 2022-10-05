<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $title = "Team";
        $team = Team::get();

        if ($request->ajax()) {
            $allData = DataTables::of($team)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole">Edit</a> | ';
                    $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteRole">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }

        return view('team.index', compact('title', 'team'));
    }

    public function store(Request $request)
    {
        Team::updateOrCreate(
            ['id' => $request->team_id],
            [
                'nama' => $request->nama,
            ]
        );

        return response()->json(['succes' => 'Team Added Successfully!']);
    }

    public function edit($id)
    {
        $team = Team::find($id);
        return response()->json($team);
    }

    public function destroy($id)
    {
        Team::find($id)->delete();
        return response()->json(['succes' => 'Team Delete Successfully!']);
    }
}

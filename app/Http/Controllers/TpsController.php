<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use Illuminate\Http\Request;
use DataTables;

class TpsController extends Controller
{
    public function index(Request $request)
    {
        $title = "TPS";
        $tps = Tps::get();

        if ($request->ajax()) {
            $allData = DataTables::of($tps)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editTps">Edit</a> | ';
                    $btn .= '<a href="javascript:void(0)" data-toogle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteTps">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }

        return view('tps.index', compact('title', 'tps'));
    }

    public function store(Request $request)
    {
        Tps::updateOrCreate(
            ['id' => $request->tps_id],
            [
                'name' => $request->name,
            ]
        );

        return response()->json(['succes' => 'Tps Added Successfully!']);
    }

    public function edit($id)
    {
        $tps = Tps::find($id);
        return response()->json($tps);
    }

    public function destroy($id)
    {
        Tps::find($id)->delete();
        return response()->json(['succes' => 'Tps Delete Successfully!']);
    }
}

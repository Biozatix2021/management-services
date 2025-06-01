<?php

namespace App\Http\Controllers;

use App\Models\DetailStock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Warehouse::with(['detailStocks' => function ($query) {
                $query->where('is_out', 0);
            }])
                ->where('is_delete', 0)
                ->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 'Aktif') {
                        return '<span class="badge badge-success"><i class="fas fa-circle fa-xs" style="color: #ffffff;"></i> Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-circle fa-xs" style="color: #ffffff;"></i> Tidak Aktif</span>';
                    }
                })
                ->addColumn('total_produk', function ($data) {
                    return $data->detailStocks->count();
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="edit_data(' . $data->id . ')"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Data" onclick="delete_data(' . $data->id . ')"><i class="fas fa-trash"></i></button>
                                </div>';
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('m_data_gudang');
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
        // return $request->all();
        $rules = [
            'name'                  => 'required',
            'contact_person'        => 'required',
            'phone'                 => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        Warehouse::create([
            'name'              => $request->name,
            'contact_person'    => $request->contact_person,
            'phone'             => $request->phone,
            'status'            => $request->status,
        ]);

        return response()->json(['status' => true, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Warehouse::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // return $request->all();
        if ($request->status == 'active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $id = $request->id;
        Warehouse::where('id', $id)
            ->update([
                'name'              => $request->name,
                'contact_person'    => $request->contact_person,
                'phone'             => $request->phone,
                'status'            => $status,
            ]);

        return response()->json($data = $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Warehouse::find($id);
        $data->is_delete = 1;
        $data->save();
        return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}

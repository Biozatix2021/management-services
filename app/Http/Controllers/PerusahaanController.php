<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Perusahaan::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($data) {
                    $url = asset('storage/' . $data->logo);
                    $logo = '<center><img src="' . $url . '" width="100px" height="100px"></center>';
                    return $logo;
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </div></center>';
                    return $button;
                })
                ->rawColumns(['logo', 'action'])
                ->make(true);
        }
        return view('m_data_perusahaan');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'logo' => 'required|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'website' => 'required',
        ];

        $text = [
            'nama.required' => 'Nama Perusahaan tidak boleh kosong',
            'alamat.required' => 'Alamat Perusahaan tidak boleh kosong',
            'telp.required' => 'Telepon Perusahaan tidak boleh kosong',
            'email.required' => 'Email Perusahaan tidak boleh kosong',
            'website.required' => 'Website Perusahaan tidak boleh kosong',
            'logo.required' => 'Logo Perusahaan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $fileName = $file->getClientOriginalName(); // Nama asli file
            $fileTmpPath = $file->getPathname();       // Path sementara file
            $destinationPath = public_path('storage/uploads'); // Folder tujuan
            $file->move($destinationPath, $fileName);

            $data = new Perusahaan();
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->telp = $request->telp;
            $data->email = $request->email;
            $data->website = $request->website;
            $data->logo = 'uploads/' . $fileName;
            $data->save();

            return response()->json(['status'   => true]);
        }
    }

    public function destroy($id)
    {
        $data = Perusahaan::find($id);
        $data->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}

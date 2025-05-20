<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Perusahaan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        $perusahaan = Perusahaan::all();
        // $data = Product::all();
        // $data = Product::with('supplier', 'category')->get();
        // return $data;
        if (request()->ajax()) {
            $data = Product::with('supplier', 'category');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <button type="button" class="btn btn-block btn-xs btn-primary" onclick="edit_data(' . $data->id . ')">Edit</button>
                                    <button type="button" class="btn btn-block btn-xs btn-danger" onclick="delete_data(' . $data->id . ')">Delete</button>
                                </center>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('m_data_produk', [
            'perusahaans' => $perusahaan,
            'categories' => $category,
        ]);
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
        $rules = [
            'name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ];

        $text = [
            'name.required' => 'Nama produk wajib diisi',
            'category_id.required' => 'Kategori produk wajib diisi',
            'supplier_id.required' => 'Supplier produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'price.numeric' => 'Harga produk harus berupa angka',
        ];

        $validator = Validator::make($request->all(), $rules, $text);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        Product::create([
            'catalog_number' => $request->catalog_number,
            'name' => $request->name,
            'price' => $request->price,
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,

        ]);

        return response()->json(['success' => 1, 'text' => 'Data berhasil disimpan']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

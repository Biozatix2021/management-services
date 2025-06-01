<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailStock;
use App\Models\Perusahaan;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $produk = Alat::with('stocks')->get();
        $perusahaan = Perusahaan::all();
        // return $produk;
        $warehouses = Warehouse::where('is_delete', 0)
            ->where('status', 1)
            ->get();

        if (request()->ajax()) {
            $data = Stock::with(['alat']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('product', function ($data) {
                    $url = asset('storage/alat/' . $data->alat->gambar);
                    return '<div style="display: flex; align-items: center;">
                                <img src="' . $url . '" alt="' . $data->alat->nama . '" class="img-circle img-size-32 mr-2" style="margin-right:8px;">
                                <span>' . $data->alat->nama . '</span>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                    <a href="/detail-stock?stock_ref=' . $data->id . '" type="button" class="btn btn-xs btn-info"><i class="fas fa-search"></i></a>
                                </center>';
                    return $button;
                })
                ->rawColumns(['product', 'action'])
                ->make(true);
        }
        return view('m_data_StockAlat', [
            'produk' => $produk,
            'warehouses' => $warehouses,
            'perusahaan' => $perusahaan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $search = $request->search;
        $data = Stock::with(['alat'])
            ->whereHas('alat', function ($query) use ($search) {
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%')
                            ->orWhere('catalog_number', 'like', '%' . $search . '%');
                    });
                }
            })
            ->get();
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function detail_stock(Request $request)
    {
        $produk = Stock::with(['alat'])->get();
        $brand = Alat::select('brand')->distinct()->get();

        $warehouses = Warehouse::where('is_delete', 0)
            ->where('status', 1)
            ->get();

        if ($request->ajax()) {

            $ref_stock = $request->get('stock_ref');
            $filterProduct = $request->get('filterProduct');
            $filterBrand = $request->get('filterBrand');
            $filterStatus = $request->get('filterStatus');
            $filterCondition = $request->get('filterCondition');
            $filterWarehouse = $request->get('filterWarehouse');

            $data = DetailStock::with(['alat', 'stock', 'warehouse', 'perusahaan'])
                ->where('is_out', 0)
                ->when($ref_stock != 'all', function ($query) use ($ref_stock) {
                    return $query->where('stock_id', $ref_stock);
                })
                ->when($filterProduct, function ($query) use ($filterProduct) {
                    return $query->where('alat_id', $filterProduct);
                })
                ->when($filterBrand, function ($query) use ($filterBrand) {
                    return $query->whereHas('alat', function ($q) use ($filterBrand) {
                        $q->where('brand', $filterBrand);
                    });
                })
                ->when($filterStatus, function ($query) use ($filterStatus) {
                    return $query->where('status', $filterStatus);
                })
                ->when($filterCondition, function ($query) use ($filterCondition) {
                    return $query->where('condition', $filterCondition);
                })
                ->when($filterWarehouse, function ($query) use ($filterWarehouse) {
                    return $query->where('warehouse_id', $filterWarehouse);
                })
                ->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('product', function ($data) {
                    $url = asset('storage/alat/' . $data->alat->gambar);
                    return '<div style="display: flex; align-items: center;">
                            <img src="' . $url . '" alt="' . $data->alat->nama . '" class="img-circle img-size-32 mr-2" style="margin-right:8px;">
                            <span>' . $data->alat->nama . '-' . $data->alat->tipe . '</span>
                        </div>';
                })
                ->addColumn('action', function ($data) {
                    $button = '<center>
                                <button type="button" class="btn btn-xs btn-info" onclick="edit_stock(' . $data->id . ')"><i class="fas fa-edit"></i></button>
                            </center>';
                    return $button;
                })
                ->rawColumns(['action', 'product'])
                ->make(true);
        }


        return view('detail_stock', [
            'produk' => $produk,
            'brands' => $brand,
            'warehouses' => $warehouses,
            'request_stock_ref' => $request->get('stock_ref') ?? 'all',
        ]);
    }

    /**
     * Show the form for stock transfer.
     */
    public function stock_transfer(Request $request)
    {
        $produk = Stock::with(['alat'])->get();
        // return $produk;
        $warehouses = Warehouse::where('is_delete', 0)
            ->where('status', 1)
            ->get();

        // return $data;

        if ($request->ajax()) {
            $data = StockTransfer::with(['fromWarehouse', 'toWarehouse', 'alat'])
                ->orderByDesc('created_at');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('product', function ($data) {
                    $url = asset('storage/alat/' . $data->alat->gambar);
                    return '<div style="display: flex; align-items: center;">
                                <img src="' . $url . '" alt="' . $data->alat->nama . '" class="img-circle img-size-32 mr-2" style="margin-right:8px;">
                                <span>' . $data->alat->nama . '</span>
                            </div>';
                })
                ->addColumn('SN', function ($data) {
                    $snList = json_decode($data->no_seri_transfer, true);
                    $badges = '';
                    if (is_array($snList)) {
                        foreach ($snList as $t) {
                            $badges .= '<span class="badge badge-primary mr-1">' . htmlspecialchars($t) . '</span>';
                        }
                    }
                    return $badges;
                })

                ->rawColumns(['product', 'SN'])
                ->make(true);
        }
        return view('m_data_stock_transfer', [
            'produk' => $produk,
            'warehouses' => $warehouses,
        ]);
    }

    /**
     * Store a newly created stock transfer in storage.
     */
    public function stock_transfer_store(Request $request)
    {
        // return $request->all();

        if ($request->has('sn_list') && is_array($request->sn_list)) {
            foreach ($request->sn_list as $sn) {
                DetailStock::where('no_seri', $sn)->update([
                    'warehouse_id' => $request->to_warehouse,
                ]);
            }
        }

        StockTransfer::create([
            'alat_id' => $request->product,
            'from_warehouse_id' => $request->from_warehouse,
            'to_warehouse_id' => $request->to_warehouse,
            'no_seri_transfer' => json_encode($request->sn_list),
            'transfer_date' => now(),
            'qty_transfer' => $request->qty,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Stock transfer successful']);
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
        // Find stock reference from $request->alat_id
        $stock = Stock::where('alat_id', $request->alat_id)->first();

        if (!$stock) {
            // Create new stock if not found
            $stock = Stock::create([
                'alat_id' => $request->alat_id,
                'low_stock_alert' => $request->low_stock_alert,
                'stock' => $request->qty,
                'unit' => $request->unit,
            ]);
            $request->merge(['stock_id' => $stock->id]);
        } else {
            // Update existing stock
            $stock->update([
                'low_stock_alert' => $request->low_stock_alert,
                'stock' => $stock->stock + $request->qty,
            ]);
            $request->merge(['stock_id' => $stock->id]);
        }

        for ($i = 0; $i < $request->qty; $i++) {
            DetailStock::create([
                'stock_id' => $request->stock_id,
                'alat_id' => $request->alat_id,
                'warehouse_id' => $request->warehouse_id,
                'no_seri' => $request->sn_list[$i],
                'keterangan' => $request->keterangan,
                'date_in' => $request->tgl_masuk,
                'status' => $request->status,
                'condition' => $request->condition,
                'perusahaan_id' => 1,
                'description' => $request->keterangan,
            ]);
        }





        return response()->json(['success' => true, 'message' => 'Stock updated successfully']);
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
        $data = DetailStock::with(['alat', 'stock', 'warehouse', 'perusahaan'])
            ->where('stock_id', $id)
            ->where('is_out', 0);

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('product', function ($data) {
                $url = asset('storage/alat/' . $data->alat->gambar);
                return '<div style="display: flex; align-items: center;">
                            <span>' . $data->alat->nama . '-' . $data->alat->tipe . '</span>
                        </div>';
            })
            ->addColumn('action', function ($data) {
                $button = '<center>
                                <button type="button" class="btn btn-xs btn-info" onclick="detail_stock(' . $data->id . ')"><i class="fas fa-search"></i></button>
                            </center>';
                return $button;
            })
            ->rawColumns(['action', 'product'])
            ->make(true);
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

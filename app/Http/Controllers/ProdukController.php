<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use Intervention\Image\Facades\Image;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('produk.index');
    }

    public function data()
    {
        $produk = Produk::all();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id_produk[]" value="' . $produk->id_produk . '">';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('nama_produk', function ($produk) {
                return ($produk->nama_produk);
            })
            ->addColumn('unit', function ($produk) {
                return ($produk->unit);
            })
            ->addColumn('image', function ($produk) {
                return ($produk->image);
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                    <div class="btn-group">
                        <button type="button" onclick="editForm(\'' . route('produk.update', $produk->id_produk) . '\')" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        <button type="button" onclick="deleteData(\'' . route('produk.destroy', $produk->id_produk) . '\')" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = new Produk($request->except('image'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = $image->getClientOriginalName();
                $imagePath = public_path('product/' . $imageName);

                // Resize dan simpan gambar menggunakan Intervention Image
                Image::make($image)
                    ->fit(300, 300)
                    ->save($imagePath);

                $produk->image = 'product/' . $imageName;
            } else {
                return response()->json('Gagal mengunggah gambar', 422);
            }
        } else {
            $produk->image = ''; // Mengatur kolom 'image' menjadi string kosong jika tidak ada gambar yang diunggah
        }

        $produk->save();

        return response()->json('Data berhasil disimpan', 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        // Cek apakah stok produk kosong
        if ($produk->stok == 0) {

            $penjualan_detail = PenjualanDetail::where('id_produk', $id)->exists();



            // Jika tidak ada penjualan detail atau penjualan open yang menggunakan produk ini, maka hapus produk
            if (!$penjualan_detail) {
                $produk->delete();
                return response()->json('Produk berhasil dihapus', 200);
            } else {
                return response()->json('Produk gagal dihapus karena masih digunakan dalam penjualan', 422);
            }
        } else {
            return response()->json('Produk gagal dihapus karena masih memiliki stok', 422);
        }
    }




    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}

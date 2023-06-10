<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('kode_member')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_member[]" value="' . $produk->id_member . '">
                ';
            })
            ->addColumn('kode_member', function ($member) {
                return '<span class="label label-success">' . $member->kode_member . '<span>';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('member.update', $member->id_member) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id_member) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_member'])
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
        $member = Member::latest()->first() ?? new Member();
        $kode_member = (int) $member->kode_member + 1;

        $newMember = new Member();
        $newMember->kode_member = tambah_nol_didepan($kode_member, 5);
        $newMember->nama = $request->nama;
        $newMember->telepon = $request->telepon;
        $newMember->alamat = $request->alamat;
        $newMember->email = $request->email;
        $newMember->diskon = $request->diskon;
        $newMember->tipe_diskon = $request->tipe_diskon;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('member'), $imageName);
            $newMember->image = 'member/' . $imageName;
        }

        $newMember->save();

        return redirect()->route('member.index');
    }

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         if ($image->isValid()) {
    //             $imageName = $image->getClientOriginalName();
    //             $imagePath = public_path('product/' . $imageName);

    //             // Resize dan simpan gambar menggunakan Intervention Image
    //             Image::make($image)
    //                 ->fit(300, 300)
    //                 ->save($imagePath);

    //             $member->image = 'product/' . $imageName;
    //         } else {
    //             return response()->json('Gagal mengunggah gambar', 422);
    //         }
    //     } else {
    //         $member->image = ''; // Mengatur kolom 'image' menjadi string kosong jika tidak ada gambar yang diunggah
    //     }


    //     $member->save();

    //     return response()->json('Data berhasil disimpan', 200);
    // }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);

        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();

        return response(null, 204);
    }

    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $datamember[] = $member;
        }

        $datamember = $datamember->chunk(2);
        $setting    = Setting::first();

        $no  = 1;
        $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
        return $pdf->stream('member.pdf');
    }
}

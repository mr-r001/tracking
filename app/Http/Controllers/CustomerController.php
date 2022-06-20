<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\District;
use App\Models\KTP;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    protected $customMessages = [
        'required'              => ':Attribute harus diisi',
        'unique'                => ':Attribute sudah ada.',
        'integer'               => ':Attribute must be a number.',
        'min'                   => ':Attribute harus :min.',
        'max'                   => ':Attribute tidak boleh lebih dari :max karakter.',
        'exists'                => 'Not found.',
    ];

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Customer::orderBy('updated_at', 'ASC')->get())
                ->addColumn('action', 'admin.customer.action')
                ->addColumn('tgl_beli', 'admin.customer.date')
                ->rawColumns(['action', 'date'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.customer.index');
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'nama'                  => 'required|string',
            'alamat'                => 'required|string',
            'handphone'             => 'required|string',
            'tgl_beli'              => 'required|date',
        ], $this->customMessages);


        $data = new Customer();
        $data->nama                     = strip_tags(request()->post('nama'));
        $data->alamat                   = strip_tags(request()->post('alamat'));
        $data->handphone                = strip_tags(request()->post('handphone'));
        $data->tgl_beli                 = request()->post('tgl_beli');
        $data->save();

        return redirect()->route('admin.customer.index')->with('success', "Data berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('data'));
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
        $data = Customer::findOrFail($id);

        request()->validate([
            'nama'                  => 'required|string',
            'alamat'                => 'required|string',
            'handphone'             => 'required|string',
            'tgl_beli'              => 'required|date',
        ], $this->customMessages);

        $data->nama                     = strip_tags(request()->post('nama'));
        $data->alamat                   = strip_tags(request()->post('alamat'));
        $data->handphone                = strip_tags(request()->post('handphone'));
        $data->tgl_beli                 = request()->post('tgl_beli');

        $data->save();

        return redirect()->route('admin.customer.index')->with('success', "Data berhasil di edit!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = Customer::findOrFail($id);

        $itemDelete = $item->delete();

        return response()->json($itemDelete);
    }
}

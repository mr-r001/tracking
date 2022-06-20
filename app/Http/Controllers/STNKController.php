<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\STNK;
use Illuminate\Http\Request;

class STNKController extends Controller
{
    protected $customMessages = [
        'required' => 'Please input the :attribute.',
        'unique' => 'This :attribute has already been taken.',
        'max' => ':Attribute may not be more than :max characters.',
    ];

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(STNK::with('customer')->orderBy('created_at', 'ASC')->get())
                ->addColumn('customer', 'admin.stnk.name')
                ->addColumn('cust_address', 'admin.stnk.address')
                ->addColumn('cust_phone', 'admin.stnk.phone')
                ->addColumn('cust_buy', 'admin.stnk.buy')
                ->addColumn('status', 'admin.stnk.status')
                ->addColumn('change', 'admin.stnk.change')
                ->addColumn('action', 'admin.stnk.action')
                ->rawColumns(['customer', 'status', 'change', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        $customers = Customer::all();
        return view('admin.stnk.index', compact('customers'));
    }

    public function create()
    {
        // 
    }

    public function store(Request $request)
    {
        request()->validate([
            'cust_id' => 'required',
            'status' => 'required|string',
        ], $this->customMessages);

        $data = STNK::create([
            'cust_id' => strip_tags(request()->post('cust_id')),
            'status' => strip_tags(request()->post('status')),
        ]);

        return response()->json($data);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = STNK::findOrFail($id);

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        $data = STNK::findOrFail($id);

        request()->validate([
            'cust_id' => 'required',
            'status' => 'required|string',
        ], $this->customMessages);

        $data->update([
            'cust_id' => strip_tags(request()->post('cust_id')),
            'status' => strip_tags(request()->post('status')),
        ]);

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = STNK::destroy($id);

        return response()->json($data);
    }
}

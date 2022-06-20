<?php

namespace App\Http\Controllers;

use App\Models\BPKB;
use App\Models\Customer;
use Illuminate\Http\Request;

class BPKBController extends Controller
{
    protected $customMessages = [
        'required' => 'Please input the :attribute.',
        'unique' => 'This :attribute has already been taken.',
        'max' => ':Attribute may not be more than :max characters.',
    ];

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(BPKB::with('customer')->orderBy('created_at', 'ASC')->get())
                ->addColumn('customer', 'admin.bpkb.name')
                ->addColumn('cust_address', 'admin.bpkb.address')
                ->addColumn('cust_phone', 'admin.bpkb.phone')
                ->addColumn('cust_buy', 'admin.bpkb.buy')
                ->addColumn('status', 'admin.bpkb.status')
                ->addColumn('change', 'admin.bpkb.change')
                ->addColumn('action', 'admin.bpkb.action')
                ->rawColumns(['customer', 'status', 'change', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        $customers = Customer::all();
        return view('admin.bpkb.index', compact('customers'));
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

        $data = BPKB::create([
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
        $data = BPKB::findOrFail($id);

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        $data = BPKB::findOrFail($id);

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
        $data = BPKB::destroy($id);

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Message;
use App\Imports\SupplierImport;
use App\Models\Member;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');	
	}

	// set index page view
	public function index() {

        $member = auth()->user()->member_id;
        $user = auth()->user()->id;
		$level = auth()->user()->level;
    	
        if ( $level == 1 ) {
            $menus = Menu::where('level1','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 2 ) {
            $menus = Menu::where('level2','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 3 ) {
            $menus = Menu::where('level3','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 4 ) {
            $menus = Menu::where('level4','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 5 ) {
            $menus = Menu::where('level5','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 6 ) {
            $menus = Menu::where('level6','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 7 ) {
            $menus = Menu::where('level7','=',1)->orderBy('kode', 'ASC')->get();
        } elseif ( $level == 8 ) {
            $menus = Menu::where('level8','=',1)->orderBy('kode', 'ASC')->get();
        }
	
		$messages = Message::where('user_kirim','=',$user)->where('jenis','=','M')->orderBy('created_at', 'ASC')->skip(0)->take(4)->get();
        $messagecount = $messages->count();

        $not = Message::where('user_kirim','=',$user)->where('jenis','=','N')->orderBy('created_at', 'ASC')->skip(0)->take(5)->get();
        $notcount = $not->count();

		$customers = Customer::where('member_id', $member)->orderBy('name', 'ASC')->get();
		return view('customer.tampil', compact('menus','customers','messages','messagecount','not','notcount')); 
	}

	// set index page view
	public function cs_index2(Request $request) {
        $member = auth()->user()->member_id;
		
		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$customer = Customer::where('member_id', $member)
					->where('email', $request->filter_gender)
					->where('address', $request->filter_country)
					->orderBy('name', 'ASC')
					->get();
		 	} else {
				$customer = Customer::where('member_id', $member)->orderBy('name', 'ASC')->get();
		 	}

			return datatables()->of($customer)
					->addColumn('action', 'customer.action')
					->rawColumns(['action'])
					->addIndexColumn()
					->make(true);
		}
		
		$customers = Customer::where('member_id', $member)->orderBy('name', 'ASC')->get();
		return view('customer.tampil', compact('customers')); 
	
	}

	// handle insert ajax request
	public function cs_store(Request $request) {
		$empData = ['kta'=>$request->kta, 
                    'name'=>$request->name,
					'phone'=>$request->phone,
					'address'=>$request->address,
					'email'=>$request->email,
					'pimpinan'=>$request->pimpinan,
					'member_id'=>$request->member_id];
			
		Customer::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function cs_edit(Request $request) {		
		$id = $request->id;
		$emp = Customer::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function cs_update(Request $request) {
		$emp = Customer::find($request->emp_id);
		$empData = ['kta'=>$request->kta, 
                    'name'=>$request->name,
					'phone'=>$request->phone,
					'address'=>$request->address,
					'email'=>$request->email,
					'pimpinan'=>$request->pimpinan,
					'member_id'=>$request->member_id];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function cs_delete(Request $request) {
		$id = $request->id;
		$emp = Customer::find($id);
		Customer::destroy($id);
	}

	//Export xls
	public function cs_export() {
        $customers = Customer::orderBy('name', 'ASC')->get();
		return view('customer.export',compact('customers'));
	}

	//Importxls
	public function cs_import(Request $request) {
        Excel::import(new SupplierImport, request()->file('filexlsimport'));
		return response()->json(['status' => 200]);
	}

	//Export pdf
	public function cs_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $customers = Customer::orderBy('name', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('supplier.lappdf', compact('customers','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}


	
}

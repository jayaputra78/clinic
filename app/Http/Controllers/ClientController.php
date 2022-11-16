<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Menu;
use App\Models\Message;
use App\Imports\SupplierImport;
use App\Models\Member;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
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

		$clients = Client::where('member_id', $member)->orderBy('name', 'ASC')->get();
		return view('client.tampil', compact('menus','clients','messages','messagecount','not','notcount')); 
	}

	// set index page view
	public function cl_index2(Request $request) {
        $member = auth()->user()->member_id;
		
		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$client = Client::where('member_id', $member)
					->where('email', $request->filter_gender)
					->where('address', $request->filter_country)
					->orderBy('name', 'ASC')
					->get();
		 	} else {
				$client = Client::where('member_id', $member)->orderBy('name', 'ASC')->get();
		 	}

			return datatables()->of($client)
					->addColumn('action', 'client.action')
					->rawColumns(['action'])
					->addIndexColumn()
					->make(true);
		}
		
		$clients = Client::where('member_id', $member)->orderBy('name', 'ASC')->get();
		return view('client.tampil', compact('clients')); 
	
	}

	// handle insert ajax request
	public function cl_store(Request $request) {
		$empData = ['kta'=>$request->kta, 
                    'name'=>$request->name,
					'phone'=>$request->phone,
					'address'=>$request->address,
					'email'=>$request->email,
					'pimpinan'=>$request->pimpinan,
					'member_id'=>$request->member_id];
			
		Client::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function cl_edit(Request $request) {		
		$id = $request->id;
		$emp = Client::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function cl_update(Request $request) {
		$emp = Client::find($request->emp_id);
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
	public function cl_delete(Request $request) {
		$id = $request->id;
		$emp = Client::find($id);
		Client::destroy($id);
	}

	//Export xls
	public function cl_export() {
        $clients = Client::orderBy('name', 'ASC')->get();
		return view('client.export',compact('clients'));
	}

	//Importxls
	public function cl_import(Request $request) {
        Excel::import(new SupplierImport, request()->file('filexlsimport'));
		return response()->json(['status' => 200]);
	}

	//Export pdf
	public function cl_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $clients = Client::orderBy('name', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('client.lappdf', compact('clients','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}


	
}

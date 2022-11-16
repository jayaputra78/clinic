<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Menu;
use App\Models\Message;
use App\Imports\SupplierImport;
use App\Models\Member;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
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

		$supplier = Supplier::orderBy('nama', 'ASC')->get();
		return view('supplier.tampil', compact('menus','supplier','messages','messagecount','not','notcount')); 
	}

	// set index page view
	public function sp_index2(Request $request) {

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$supplier = Supplier::where('status', $request->filter_gender)
					->where('kota', $request->filter_country)
					->orderBy('nama', 'ASC')
					->get();
		 	} else {
				$supplier = Supplier::orderBy('nama', 'ASC')->get();
		 	}

			return datatables()->of($supplier)
					->addColumn('action', 'supplier.action')
					->rawColumns(['action'])
					->addIndexColumn()
					->make(true);
		}
		
		$supplier = Supplier::orderBy('nama', 'ASC')->get();
		return view('supplier.tampil', compact('supplier')); 
	
	}

	// handle insert ajax request
	public function sp_store(Request $request) {
		$empData = ['nama'=>$request->nama, 
                    'alamat'=>$request->alamat,
					'telp'=>$request->telp,
					'kota'=>$request->kota,
					'pic'=>$request->pic,
					'status'=>$request->status];
			
		Supplier::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function sp_edit(Request $request) {		
		$id = $request->id;
		$emp = Supplier::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function sp_update(Request $request) {
		$emp = Supplier::find($request->emp_id);
		$empData = ['nama'=>$request->nama, 
                    'alamat'=>$request->alamat,
					'telp'=>$request->telp,
					'kota'=>$request->kota,
					'pic'=>$request->pic,
					'status'=>$request->status];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function sp_delete(Request $request) {
		$id = $request->id;
		$emp = Supplier::find($id);
		Supplier::destroy($id);
	}

	//Export xls
	public function sp_export() {
        $suppliers = Supplier::orderBy('nama', 'ASC')->get();
		return view('supplier.export',compact('suppliers'));
	}

	//Importxls
	public function sp_import(Request $request) {
        Excel::import(new SupplierImport, request()->file('filexlsimport'));
		return response()->json(['status' => 200]);
	}

	//Export pdf
	public function sp_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $suppliers = Supplier::orderBy('nama', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('supplier.lappdf', compact('suppliers','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}


	
}

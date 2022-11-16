<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
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
	
		if ($level > 1 ) {
			$warehouses = Warehouse::where('member_id', $member)->orderBy('nama', 'ASC')->get();
		} else {
			$warehouses = Warehouse::orderBy('member_id', 'ASC')->get();
		}

		$member = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		return view('warehouse.tampil', compact('menus','warehouses','member','messages','messagecount','not','notcount')); 

	}

	public function wr_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$warehouse = warehouse::with('member')
							->where('status', $request->filter_gender)
							->where('member_id', $request->filter_country)
							->orderBy('nama', 'ASC')
							->get();
		 	} else {
				if ($level > 1 ) {
					$warehouse = Warehouse::with('member')->where('member_id','=',$member)->orderBy('nama', 'ASC')->get();
				} else {
					$warehouse = Warehouse::with('member')->orderBy('nama', 'ASC')->get();
				}
		 	}

			return datatables()->of($warehouse)
					->addColumn('action', 'warehouse.action')
					->rawColumns(['action'])
					->addIndexColumn()
					->make(true);
					
		}
		
		if ($level > 1 ) {
			$warehouse = Warehouse::with('member')->where('member_id','=',$member)->orderBy('nama', 'ASC')->get();
		} else {
			$warehouse = Warehouse::with('member')->orderBy('nama', 'ASC')->get();
		}
		return view('warehouse.tampil', compact('warehouse','members','accounts')); 
	
	}

	// handle insert ajax request
	public function wr_store(Request $request) {

		$empData = ['nama' => $request->nama, 
                    'status'=>$request->status,
		            'keterangan'=>$request->keterangan,
					'member_id'=>$request->member_id];
			
		Warehouse::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function wr_edit(Request $request) {		
		$id = $request->id;
		$emp = Warehouse::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function wr_update(Request $request) {
		
		$emp = Warehouse::find($request->emp_id);
		$empData = ['nama' => $request->nama, 
                    'status'=>$request->status,
		            'keterangan'=>$request->keterangan,
					'member_id'=>$request->member_id];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function wr_delete(Request $request) {
		$id = $request->id;
		$emp = Warehouse::find($id);
		if ($emp->status == "AKTIF" ) 
		{
			Swal.fire(
                'Maaf!',
                'Gudang ini ada saldo stoknya !',
                'Tidak bisa dihapus'
			);
		} else {
			Warehouse::destroy($id);
		}
	}


	//Export xls
	public function wr_export() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;
        $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->get();
		return view('warehouse.export',compact('warehouses'));
	}

	//Importxls
	public function wr_import(Request $request) {
    //    Excel::import(new SupplierImport, request()->file('filexlsimport'));
	//	return response()->json(['status' => 200]);
	}

	//Export pdf
	public function wr_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('warehouse.lappdf', compact('warehouses','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

}


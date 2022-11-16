<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boat;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class BoatController extends Controller
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
	
		$boats = Boat::orderBy('nama', 'ASC')->get();
		$member = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		return view('boat.tampil', compact('menus','boats','member','messages','messagecount','not','notcount')); 

	}

	public function bt_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$boat = Boat::with('member')
							->where('status', $request->filter_gender)
							->orderBy('nama', 'ASC')
							->get();
		 	} else {
				$boat = Boat::with('member')->orderBy('nama', 'ASC')->get();
		 	}

			return datatables()->of($boat)
					->addColumn('action', 'boat.action')
					->rawColumns(['action'])
					->addIndexColumn()
					->make(true);
					
		}
		
		$boat = Ware::with('member')->orderBy('nama', 'ASC')->get();
		return view('boat.tampil', compact('boat','members','accounts')); 
	
	}

	// handle insert ajax request
	public function bt_store(Request $request) {

		$empData = ['nama' => $request->nama, 
                    'status'=>$request->status,
		            'keterangan'=>$request->keterangan,
					'member_id'=>$request->member_id];
			
		Boat::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function bt_edit(Request $request) {		
		$id = $request->id;
		$emp = Boat::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function bt_update(Request $request) {
		
		$emp = Boat::find($request->emp_id);
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
	public function bt_delete(Request $request) {
		$id = $request->id;
		$emp = Boat::find($id);
		if (($emp->status == "AKTIF" ) || ($emp->status == "PENDING" ))
		{
			Swal.fire(
                'Maaf!',
                'Kapal ini Aktif !',
                'Tidak bisa dihapus'
			);
		} else {
			Boat::destroy($id);
		}
	}


	//Export xls
	public function bt_export() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;
        $boats = Boat::orderBy('nama', 'ASC')->get();
		return view('boat.export',compact('boats'));
	}

	//Importxls
	public function wr2_import(Request $request) {
    //    Excel::import(new SupplierImport, request()->file('filexlsimport'));
	//	return response()->json(['status' => 200]);
	}

	//Export pdf
	public function bt_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $boats = Boat::orderBy('nama', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('boat.lappdf', compact('boats','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

}


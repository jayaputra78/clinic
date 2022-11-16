<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashier;
use App\Models\Account;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class CashierController extends Controller
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
			$cashier = Cashier::where('member_id','=',$member)->get();
		} else {
			$cashier = Cashier::all();
		}

		$member = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();
        $accounts  = Account::where('kelompok','=',1)->orderBy('created_at', 'DESC')->get();

		return view('cashier.tampil', compact('menus','cashier','accounts','member','messages','messagecount','not','notcount')); 

	}

	public function ch_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();
        $accounts  = Account::where('kelompok','=',1)->orderBy('created_at', 'DESC')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$cashier = Cashier::with('member')->where('level', $request->filter_gender)
					->where('no_masuk', $request->filter_country)
					->orderBy('bank', 'ASC')
					->get();
		 	} else {
				if ($level > 1 ) {
					$cashier = Cashier::with('member')->where('member_id','=',$member)->orderBy('bank', 'ASC')->get();
				} else {
					$cashier = Cashier::with('member')->orderBy('bank', 'ASC')->get();
				}
		 	}

			return datatables()->of($cashier)
					->addColumn('action', 'cashier.action')
					->addColumn('status', function (Cashier $cas) {
						if ($cas->level == '5') {
							return '<span class="badge badge-success h1">Project</span>';
						} else if ($cas->level == '4') {
							return '<span class="badge badge-danger h1">Holding</span>';
						}
					})
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);
					
		}
		
		if ($level > 1 ) {
			$cashier = Cashier::with('member')->where('member_id','=',$member)->orderBy('bank', 'ASC')->get();
		} else {
			$cashier = Cashier::with('member')->orderBy('bank', 'ASC')->get();
		}
		return view('cashier.tampil', compact('cashier','members','accounts')); 
	
	}

	// handle insert ajax request
	public function ch_store(Request $request) {

		$empData = ['no_rek' => $request->no_rek, 
                    'bank'=>$request->bank,
                    'account_id'=>$request->account_id,
					'member_id'=>$request->member_id];
			
		Cashier::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function ch_edit(Request $request) {		
		$id = $request->id;
		$emp = Cashier::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function ch_update(Request $request) {
		$emp = Cashier::find($request->emp_id);
		$empData = ['no_rek' => $request->no_rek, 
                    'bank'=>$request->bank,
					'account_id'=>$request->account_id,
					'member_id'=>$request->member_id];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function ch_delete(Request $request) {
		$id = $request->id;
		$emp = Cashier::find($id);
		Cashier::destroy($id);
	}


	//Export xls
	public function ch_export() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;


        $cashiers = Cashier::orderBy('bank', 'ASC')->where('member_id','=',$member)->get();
		return view('cashier.export',compact('cashiers'));
	}

	//Importxls
	public function ch_import(Request $request) {
    //    Excel::import(new SupplierImport, request()->file('filexlsimport'));
	//	return response()->json(['status' => 200]);
	}

	//Export pdf
	public function ch_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $cashiers = Cashier::orderBy('bank', 'ASC')->where('member_id','=',$member)->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('cashier.lappdf', compact('cashiers','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

}


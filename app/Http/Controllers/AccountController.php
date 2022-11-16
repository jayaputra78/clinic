<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Chart;
use App\Models\Group;
use App\Models\Chartg;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
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
		
		$charts = Chart::orderBy('chart', 'ASC')->get();
		$groups = Chartg::orderBy('kelompok', 'ASC')->get();
		$accounts  = Account::with('chart')->orderBy('account', 'ASC')->get();
		$member = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();
		return view('account.tampil', compact('charts', 'groups','accounts', 'menus','member','messages','messagecount','not','notcount'));
	}

	public function acc_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$accounts = Account::with('chart')->where('chart_id', $request->filter_gender)
					->where('kelompok', $request->filter_country)
					->orderBy('account', 'ASC')
					->get();
		 	} else {
				$accounts = Account::with('chart')->orderBy('account', 'ASC')->get();
		 	}

			return datatables()->of($accounts)
					->addColumn('action', 'account.action')
					->addColumn('status', function (Account $cas) {
						if ($cas->kelompok == '1') {
							return '<span class="badge badge-success h1">Aktiva</span>';
						} else if ($cas->kelompok == '2') {
							return '<span class="badge badge-danger h1">Passiva</span>';
						} else if ($cas->kelompok == '3') {
							return '<span class="badge badge-info h1">Modal</span>';
						} else if ($cas->kelompok == '4') {
							return '<span class="badge badge-primary h1">Pendapatan</span>';
						} else if ($cas->kelompok == '5') {
							return '<span class="badge badge-warning h1">Biaya</span>';
						} else if ($cas->kelompok == '51') {
							return '<span class="badge badge-warning h1">Biaya</span>';
						} else if ($cas->kelompok == '6') {
							return '<span class="badge badge-warning h1">Biaya</span>';
						}
					})
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);
					
		} 

		$accounts = Account::with('chart')->orderBy('account', 'ASC')->get();
		return view('account.tampil', compact('members','accounts')); 
	
	}

	// handle insert ajax request
	public function acc_store(Request $request) {
		$empData = ['chart_id' => $request->chart_id, 
                    'account' => $request->account,
					'keterangan' => $request->keterangan,
					'kelompok' => $request->kelompok];
			
		Account::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function acc_edit(Request $request) {		
		$id = $request->id;
		$emp = Account::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function acc_update(Request $request) {
		$emp = Account::find($request->emp_id);
		$empData = ['chart_id' => $request->chart_id, 
                    'account'=>$request->account,
                    'keterangan'=>$request->keterangan,
					'kelompok'=>$request->kelompok];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function acc_delete(Request $request) {
		$id = $request->id;
		$emp = Account::find($id);
		Account::destroy($id);
	}

	//Export xls
	public function acc_export() {
		$accounts = Account::with('chart')->orderBy('account', 'ASC')->get();
		return view('account.export',compact('accounts'));
	}
	
	//Importxls
	public function acc_import(Request $request) {
		//    Excel::import(new SupplierImport, request()->file('filexlsimport'));
		//	return response()->json(['status' => 200]);
	}
	
	//Export pdf
	public function acc_pdf() {
		$member = auth()->user()->member_id;
		$level = auth()->user()->level;
	
		$accounts = Account::with('chart')->orderBy('account', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('account.lappdf', compact('accounts','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Member;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
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
	
		$member = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();

		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();

		return view('member.tampil', compact('menus','member','lokasi','kta','messages','messagecount','not','notcount')); 
	}

	public function mem_index2(Request $request) {
		$member = auth()->user()->member_id;
		$level = auth()->user()->level;		

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$members = Member::where('name', $request->filter_gender)
					->where('id','<>','999')->where('id','<>','998')->where('id','<>','997')
					->orderBy('kta', 'ASC')
					->get();
				if(!empty($request->filter_country)) {	
					$members = Member::where('name', $request->filter_gender)
					->where('address', $request->filter_country)
					->where('id','<>','999')->where('id','<>','998')->where('id','<>','997')
					->orderBy('kta', 'ASC')
					->get();				
				}
			} elseif(!empty($request->filter_country)) {	
					$members = Member::where('address', $request->filter_country)
					->where('id','<>','999')->where('id','<>','998')->where('id','<>','997')
					->orderBy('kta', 'ASC')
					->get();	
			} else {
				$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
			}
			return datatables()->of($members)
					->addColumn('action', 'member.action')
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);		
		}
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();
		return view('member.tampil', compact('members','lokasi','kta')); 
	}

	// handle insert ajax request
	public function mem_store(Request $request) {
		$empData = ['kta'=>$request->kta, 
					'name'=>$request->name, 
					'nib'=>$request->nib, 
					'npwp'=>$request->npwp, 
                    'phone'=>$request->phone,
                    'address'=>$request->address,
					'email'=>$request->email,
					'pengurus'=>$request->pengurus,
					'nilai'=>$request->nilai,
					'biaya'=>$request->biaya
				];

		Member::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function mem_edit(Request $request) {		
		$id = $request->id;
		$emp = Member::find($id);
		return response()->json($emp); 
	}

	// handle update ajax request
	public function mem_update(Request $request) {
		$emp = Member::find($request->emp_id);
		$empData = ['kta'=>$request->kta, 
					'name'=>$request->name, 
					'nib'=>$request->nib, 
					'npwp'=>$request->npwp, 
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'email'=>$request->email,
					'pengurus'=>$request->pengurus,
					'nilai'=>$request->nilai,
					'biaya'=>$request->biaya
				];
					

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function mem_delete(Request $request) {
		$id = $request->id;
		$emp = Member::find($id);
		Member::destroy($id);
	}


	//Export xls
	public function mem_export() {
		$members = Member::orderBy('kta', 'ASC')->get();
		return view('member.export',compact('members'));
	}

	//Importxls
	public function mem_import(Request $request) {
    //    Excel::import(new SupplierImport, request()->file('filexlsimport'));
	//	return response()->json(['status' => 200]);
	}

	//Export pdf
	public function mem_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('member.lappdf', compact('members','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

}

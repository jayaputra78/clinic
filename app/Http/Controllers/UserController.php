<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');	
	}

	// set index page view
	public function index() {

		$level = auth()->user()->level;
		$member = auth()->user()->member_id;
        $user = auth()->user()->id;
    	
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
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if ( $level > 1 ) {
			$users = User::with('member')->where('member_id',$member)->get();
		} else {
			$users = User::with('member')->where('member_id','<>',999)->get();
		}
		return view('user.tampil', compact('users','members', 'menus','messages','messagecount','not','notcount'));
	}
	
	// Setting to Datatable
	public function user_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$users = User::with('member')
					->where('level', $request->filter_gender)
					->orderBy('id', 'ASC')
					->get();
				if(!empty($request->filter_country)) { 
					$users = User::with('member')
							->where('level', $request->filter_gender)
							->where('member_id', $request->filter_country)
							->orderBy('id', 'ASC')
							->get();
				}
			} elseif(!empty($request->filter_country)) {
				$users = User::with('member')->where('member_id', $request->filter_country)
					->orderBy('id', 'ASC')
					->get();				
		 	} else {

				if ( $level > 1 ) {
					$users = User::with('member')->where('member_id',$member)->get();
				} else {
					$users = User::with('member')->where('member_id','<>',999)->get();
				}
		 	}

			return datatables()->of($users)
					->addColumn('action', 'user.action')
					->addColumn('status', function (User $row) {
						if ($row->level == '1') {
							return '<span class="badge badge-secondary h1">Administrator</span>';
						} else if ($row->level == '2') {
							return '<span class="badge badge-primary h1">Owner</span>';
						} else if ($row->level == '3') {
							return '<span class="badge badge-warning h1">Manager</span>';
						} else if ($row->level == '4') {
							return '<span class="badge badge-success h1">Keuangan</span>';
						} else if ($row->level == '5') {
							return '<span class="badge badge-danger h1">Operator</span>';		
						} else if ($row->level == '6') {
							return '<span class="badge badge-primary h1">Upah</span>';	
						} else if ($row->level == '7') {
							return '<span class="badge badge-warning h1">Peralatan</span>';			
						} else if ($row->level == '8') {
							return '<span class="badge badge-success h1">Admin Project</span>';												
						}
					})
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);
		}
		
		if ( $level > 1 ) {
			$users = User::with('member')->where('member_id',$member)->get();
		} else {
			$users = User::with('member')->where('member_id','<>',999)->get();
		}
		return view('user.tampil', compact('users','members')); 
	
	}

	// insert a new user ajax request
	public function user_store(Request $request) {
		$empData = ['name' => $request->name, 
                    'email'=>$request->email,
					'password'=>Hash::make($request->password),
                    'level'=>$request->level,
                    'member_id'=>$request->member_id];
		User::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit an employee ajax request
	public function user_edit(Request $request) {		
		$id = $request->id;
		$emp = User::find($id);
		return response()->json($emp);
	
	}

	// handle update an employee ajax request
	public function user_update(Request $request) {
		$fileName = '';
		$emp = User::find($request->emp_id);
		$empData = ['name' => $request->name, 
					'email'=>$request->email,
					'password'=>Hash::make($request->password),
					'level'=>$request->level,
					'member_id'=>$request->member_id];
		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle update an employee ajax request
	public function user_upassw(Request $request) {
		$fileName = '';
		$emp = User::find($request->emp_id);
		$empData = ['password'=>Hash::make($request->password)];
		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}
	
	public function user_update2(Request $request) {		
		$emp = User::find($request->emp_id);

		if ($request->hasFile('image1')) {
			$file = $request->file('image1');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file = Image::make($file->getRealPath());
			$file->resize(299,512);
			$file->save(public_path('storage/images/'.$fileName));
			if ($emp->image1) {
				Storage::delete('storage/images/'.$emp->image1);
			}
		} else {
		//	$fileName = $request->emp_image1;
			Storage::delete('public/images/' . $emp->image1);
		}

		$empData = ['name' => $request->nama,
					'alamat' => $request->alamat,
					'nohp' => $request->nohp,
					'image1' => $fileName];
		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete an employee ajax request
	public function user_delete(Request $request) {
		$id = $request->id;
		$emp = User::find($id);
		User::destroy($id);
	}


		//Export xls
		public function user_export() {
			$member = auth()->user()->member_id;
			$level = auth()->user()->level;
			if ( $level > 1 ) {
				$users = User::with('member')->where('member_id',$member)->get();
			} else {
				$users = User::with('member')->where('member_id','<>',999)->get();
			}	
			return view('user.export',compact('users'));
		}
	
		//Importxls
		public function user_import(Request $request) {
		//    Excel::import(new SupplierImport, request()->file('filexlsimport'));
		//	return response()->json(['status' => 200]);
		}
	
		//Export pdf
		public function user_pdf() {
	
			$member = auth()->user()->member_id;
			$level = auth()->user()->level;
			if ( $level > 1 ) {
				$users = User::with('member')->where('member_id',$member)->get();
			} else {
				$users = User::with('member')->where('member_id','<>',999)->get();
			}
			$judul = Member::where('id','=',$member)->get();
			$pdf = PDF::loadView('user.lappdf', compact('users','judul'))->setPaper('a4', 'potrait');
			return $pdf->stream();
		}

}

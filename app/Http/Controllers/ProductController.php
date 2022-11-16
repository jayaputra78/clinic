<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Member;
use App\Models\Message;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
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
	
		$group = Group::orderBy('created_at', 'DESC')->get();
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();
		
		$product_details = Product::with('group')->orderBy('title', 'ASC')->get();
		return view('product.tampil', compact('members','product_details','menus','group','messages','messagecount','not','notcount')); 
	}

	public function prod_index2(Request $request) {

		$member = auth()->user()->member_id;
		$level = auth()->user()->level;
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->get();

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
				$group = Product::with('group')
					->where('ppn', $request->filter_gender)
					->where('stock', $request->filter_country)
					->orderBy('title', 'ASC')
					->get();
			} else {
				$group = Product::with('group')->orderBy('title', 'ASC')->get();
			}
			return datatables()->of($group)
					->addColumn('action', 'product.action')
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);		
		}
		
		$product = Product::with('group')->orderBy('title', 'ASC')->get();
		return view('product.tampil', compact('product','members')); 
	}
	
	// handle insert ajax request
	public function prod_store(Request $request) {

		$member = auth()->user()->member_id;
		$empData = ['title'=>$request->title, 
                    'description'=>$request->description,
					'satuan'=>$request->satuan,
					'group_id'=>$request->group_id];

		$lastid = Product::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit  ajax request
	public function prod_edit(Request $request) {		
		$id = $request->id;
		$emp = Product::find($id);
		return response()->json($emp);
	}

	// handle update ajax request
	public function prod_update(Request $request) {
		$emp = Product::find($request->emp_id);
		$empData = ['title'=>$request->title, 
                    'description'=>$request->description,
					'satuan'=>$request->satuan,
					'group_id'=>$request->group_id];
		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete ajax request
	public function prod_delete(Request $request) {
		$id = $request->id;
		$emp = Product::find($id);
		if ($emp->stock > 0) {
			Swal.fire(
                'Maaf!',
                'Produk ini ada saldo stoknya !',
                'Tidak bisa dihapus'
			);
		} else {
			Product::destroy($id);
		};	
	}

	//Export xls
	public function prod_export() {
		$group = Product::with('group')->orderBy('title', 'ASC')->get();
		return view('product.export',compact('group'));
	}

	//Importxls
	public function prod_import(Request $request) {
    //    Excel::import(new SupplierImport, request()->file('filexlsimport'));
	//	return response()->json(['status' => 200]);
	}

	//Export pdf
	public function prod_pdf() {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $group = Product::with('group')->orderBy('title', 'ASC')->get();
		$judul = Member::where('id','=',$member)->get();
		$pdf = PDF::loadView('product.lappdf', compact('group','judul'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

}

?>


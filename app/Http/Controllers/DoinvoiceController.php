<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Payinvoice;
use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Cashier;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\Payinvoice_detail;
use App\Models\Doinvoice;
use App\Models\Doinvoice_detail;
use Illuminate\Support\Facades\DB;
use PDF;
use Image;
use App\Http\Controllers\PDFController;
use App\Models\Menu;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class DoinvoiceController extends Controller
{

    public function __construct()
	{
		$this->middleware('auth');	
	}

    public function index()
    {

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

        $payinvoice  = Payinvoice::with(['customer', 'detail','cashier'])->orderBy('created_at', 'DESC')->paginate(10);
        
		if ($level > 1 ) {
			$cashier = Cashier::where('member_id','=',$member)->get();
		} else {
			$cashier = Cashier::all();
		}

        if ( $level > 1 ) {
            $customers = Customer::where('member_id','=',$member)->get();
            $suppliers = Supplier::all();
            $cashiers = Cashier::orderBy('bank', 'ASC')->where('member_id','=',$member)->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->get();
            $results =   Invoice::with(['customer'])->select(DB::raw('customer_id, sum(saldo) as saldo'))->where('saldo','<>','0')->where('member_id','=',$member)->groupBy('customer_id')->get();   
            $result2s =  Doinvoice::with(['supplier'])->select(DB::raw('supplier_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('supplier_id')->get();     
        } else {
            $customers = Customer::all();
            $suppliers = Supplier::all();
            $cashiers = Cashier::orderBy('member_id', 'DESC')->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->get();
            $results =   Invoice::with(['customer'])->select(DB::raw('customer_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('customer_id')->get();  
            $result2s =   Doinvoice::with(['supplier'])->select(DB::raw('supplier_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('supplier_id')->get();            
        }
        $cashier2 = Cashier::where('member_id','=',$member)->get();

        return view('doinvoice.tampil', compact('suppliers','results','result2s','payinvoice', 'cashier2', 'cashier', 'menus', 'messages','messagecount','not','notcount'));
    }

	public function do_index2(Request $request) 
    {
		$member = auth()->user()->member_id;
		$level = auth()->user()->level;		

        if( $level > 4 ) {
            if ($level == 5) {
                $jenis = "MATERIAL";
                // $emps = Doinvoice::where('member_id','=',$member)->where('jenis','=','MATERIAL')->get();
            } elseif ($level == 6) {
                $jenis = "UPAH";
              //  $emps = Doinvoice::where('member_id','=',$member)->where('jenis','=','UPAH')->get();
            } elseif ($level == 7) {
                $jenis = "PERALATAN";
                //    $emps = Doinvoice::where('member_id','=',$member)->where('jenis','=','PERALATAN')->get();    
            } elseif ($level == 8) {
                    //$emps = Doinvoice::where('member_id','=',$member)->get();               
            }
        }

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
                if ( $level > 4 ) {
                    $pays =  Doinvoice::with('member','supplier')
                          ->where('member_id','=',$member)
                          ->where('jenis', $request->filter_gender)
                          ->orderBy('tanggal', 'DESC')
                          ->get();
                    if(!empty($request->filter_country)) {	
                        $pays =  Doinvoice::with('member','supplier')
                        ->where('member_id','=',$member)
                        ->where('jenis', $request->filter_gender)
                        ->where('status', $request->filter_country)
                        ->orderBy('tanggal', 'DESC')
                        ->get();				
                    }
 
                } else {
                    $pays =  Doinvoice::with('member','supplier')
                    ->where('jenis', $request->filter_gender)
                    ->orderBy('tanggal', 'DESC')
                    ->get();
                    if(!empty($request->filter_country)) {	
                        $pays =  Doinvoice::with('member','supplier')
                        ->where('jenis', $request->filter_gender)
                        ->where('status', $request->filter_country)
                        ->orderBy('tanggal', 'DESC')
                        ->get();				
                    }
                }
			} elseif(!empty($request->filter_country)) {	
                if ( ( $level > 4 ) && ( $level < 8 )) {
					$pays = Doinvoice::with('member','supplier')
                    ->where('member_id','=',$member)
                    ->where('jenis','=',$jenis)
                    ->where('status', $request->filter_country)
					->orderBy('tanggal', 'DESC')
					->get();	
                } else {
                    if ( $level = 8 ) {
                        $pays = Doinvoice::with('member','supplier')
                        ->where('member_id','=',$member)
                        ->where('status', $request->filter_country)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
                    } else { 
                        $pays = Doinvoice::with('member','supplier')
                        ->where('status', $request->filter_country)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
                    }

                }
			} else {                
                if (( $level > 4 ) && ( $level < 8 )) {
                    $pays = Doinvoice::with('member','supplier')
                    ->where('jenis','=',$jenis)
                    ->orderBy('tanggal', 'DESC')
                    ->where('member_id','=',$member)
                    ->get();
                } else {
                    if ( $level = 8 ) {
                        $pays = Doinvoice::with('member','supplier')
                        ->where('member_id','=',$member)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
                    } else {
                        $pays = Doinvoice::with('member','supplier')
                        ->orderBy('tanggal', 'DESC')
                        ->get();
                    }
                }
			}
			return datatables()->of($pays)
                    ->addColumn('item', function (Doinvoice $row) {
                        $item1 = Doinvoice_detail::where('doinvoice_id',$row->id)->get();
                        $item = $item1->count();
                        return $item;
                    })
                    ->addColumn('action', 'doinvoice.action') 
                    ->rawColumns(['action','status','item'])
					->addIndexColumn()
					->make(true);		
		}

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();

        return view('doinvoice.tampil', compact('pays','members','lokasi','kta')); 
	}

    public function do_simpan(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        $level = auth()->user()->level;
        $member = auth()->user()->member_id;

        $doinvoice = Doinvoice::create([
            'supplier_id' => $request->supplier_id,
            'note'=>$request->note,
            'warehouse_id' => $request->warehouse_id,
            'user_id' => $request->userid,
            'total' => 0,
            'account_id_bd' => '85',
            'account_id_bc' => '15',
            'jenis' => $request->jenis,
            'status' => $request->status,
            'member_id' => $member,
            'tanggal' => $request->tanggal,
            'payment' => $request->payment
        ]);

        //======== Create Number PO ============ 
        $id = $doinvoice->id;
        $doinvoice2 = Doinvoice::with('member','supplier')->find($id);
        $tg = date('m',strtotime($doinvoice2->tanggal));
        $th = date('Y',strtotime($doinvoice2->tanggal));
        $note = $doinvoice2->jenis . '/' . $doinvoice2->id . '/' . $tg . '/' . $th;
        $doinvoice2->update(['level' => $note,]);
        //=== Selesai Create ===

        return redirect(route('doinvoice_index2', ['id' => $doinvoice2->id, 'supplier_id' =>  $doinvoice2->supplier_id ]));
    }

    public function index2(Request $request) 
    {
        $id = $request->id;
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

        $accounts = Account::with('chart')->where('kelompok','=','5')->get();
        $account2s = Account::with('chart')->where('kelompok','=','4')->get();
        
        $doinvoice3 = Doinvoice::with(['supplier', 'detail', 'detail.product','warehouse'])->find($id);
        
        if ($level > 4 ) { 
            $productsm = Product_detail::where('member_id','=',$member)->where('jenis','=','MATERIAL')->orderBy('title', 'ASC')->get();
            $productsu = Product_detail::where('member_id','=',$member)->where('jenis','=','UPAH')->orderBy('title', 'ASC')->get();
            $productsp = Product_detail::where('member_id','=',$member)->where('jenis','=','PERALATAN')->orderBy('title', 'ASC')->get();   
            $productkb = Product_detail::where('member_id','=',$member)->where('jenis','=','UPAH')->where('description','=','KASBON')->orderBy('title', 'ASC')->take(1)->get(); 
        } else {
            $productsm = Product_detail::where('jenis','=','MATERIAL')->orderBy('title', 'ASC')->get();
            $productsu = Product_detail::where('jenis','=','UPAH')->orderBy('title', 'ASC')->get();
            $productsp = Product_detail::where('jenis','=','PERALATAN')->orderBy('title', 'ASC')->get();   
            $productkb = Product_detail::where('jenis','=','UPAH')->where('description','=','KASBON')->orderBy('title', 'ASC')->take(1)->get(); 
        }

        return view('doinvoice.tampil2', compact('productkb', 'productsm', 'productsu','productsp', 'doinvoice3', 'member', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function do_saves(Request $request)
    {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        $empData = [
            'doinvoice_id' => $request->doinvoice_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'qty' => $request->qty,
            'user_id' => $request->userid,
            'jenis' => $request->jenis,
            'member_id' => $member,
            'pekerja' => $request->jumlah,
            'hari' => $request->hari,
            'pekerjaan' => $request->pekerjaan,
            'persen' => $request->persen,
            'tanggal' => $request->tanggal,
            'price_acc' => $request->price,
            'supplier'=> $request->supplier_id,
        ];
        Doinvoice_detail::create($empData);

		return response()->json([
			'status' => 200,
		]);
    }

	public function do_index3(Request $request) 
    {

        $supplier_id = $request->supplier_id;
        $member = auth()->user()->member_id;
		$level = auth()->user()->level;		

		if(request()->ajax()) {
            if(!empty($request->filter_country)) {
                    $pays = Doinvoice_detail::with('product','doinvoice')
                            ->where('doinvoice_id', $request->filter_country)
                            ->orderBy('tanggal', 'DESC')->get();
            } else {
                $pays = Doinvoice_detail::with('product','doinvoice')
                          ->where('doinvoice_id', $request->sid)
                          ->orderBy('tanggal', 'DESC')->get();   
            }
			return datatables()->of($pays)
                    ->with('total', $pays->sum('price'))
					->addColumn('action', 'doinvoice.action2')
                    ->addColumn('status', function (Doinvoice_detail $row) {
                        if( auth()->user()->level == 8 ) {
                            $total = $row->qty*$row->price_acc;
                        } else {
                            $total = 0;
                        }
                        return $total;
					})
                    ->addColumn('harga', function (Doinvoice_detail $row) {
                        if( auth()->user()->level == 8 ) {
                            $harga = $row->price_acc;
                        } else {
                            $harga = $row->price;
                        }
                        return $harga;
					})
					->rawColumns(['action','status','harga'])
					->addIndexColumn()
					->make(true);		

            echo $pays;
		}

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();
        $result2s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$supplier_id.'')->where('saldo','<>','0')->get(); 

        return view('doinvoice.tampil2', compact('pays','members','lokasi','kta','result2s')); 
	}
    
    public function do_delete(Request $request)
    {
        $id = $request->id;
		$emp = Doinvoice_detail::find($id);
		Doinvoice_detail::destroy($id);
    }

    public function do_reload(Request $request) 
    {
        $result2s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$request->id.'')->where('saldo','<>','0')->get();        
        return response()->json([$result2s]);
    }

    public function do_reload2(Request $request) 
    {
      
        $result3s = Product_detail::with('product')->find($request->id);
      //  $result3s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->find($request->id);     
        return response()->json($result3s);
    }

    public function do_cetak(Request $request)
    {    
        $id = $request->id;
        $membername = auth()->user()->member->name;
        $username = auth()->user()->name;

        $doinvoice = Doinvoice::with(['supplier', 'detail', 'detail.product','user'])->find($id);
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($username.' - '.$membername. ' - ID : ' . $doinvoice->id . ' Cont :' . $doinvoice->note ));
        $qrcodepenerima = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($doinvoice->supplier->nama));     
        $qrcodepembuat = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($doinvoice->user->name));
        $qrcodeacc = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($doinvoice->member->pengurus));
                
        $bln = date('m', strtotime($doinvoice->created_at));
        $thn = date('Y', strtotime($doinvoice->created_at));

        if ($doinvoice->jenis == "UPAH") {
            $pdf = PDF::loadView('doinvoice.print2', compact('doinvoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        } else { 
            $pdf = PDF::loadView('doinvoice.print', compact('doinvoice','qrcode'))->setPaper('a4', 'potrait');
        }
       
        return $pdf->stream();
    }

    public function do_cekharga(Request $request) 
    {

        $id = $request->id;
        $doinvoice = Doinvoice::with(['supplier', 'detail'])->find($id);
        $doinvoice_detail = Doinvoice_detail::with(['product'])->where('doinvoice_id','=',$doinvoice->id)->get();
       
        $status = "CEK HARGA";
        $price = 0;
        $qty = 0;

        foreach ($doinvoice_detail as $row) {

           if ($doinvoice->payment =="KASBON") {
                $row->update(['price_acc'=>$row->price]);
           } else {
                if ($request->harga == "1") {
                        $row->update(['price_acc'=>$row->product->price_b1]);
                } elseif ($request->harga == "2") {
                        $row->update(['price_acc'=>$row->product->price_b2]);
                } else {
                        $row->update(['price_acc'=>$row->product->price_b3]);
                }
           } 

           $price = $price + $row->price_acc*$row->qty;
           $qty = $qty + $row->qty;
        }
        

        $doinvoice->update(['qty'=>$qty]);
        $doinvoice->update(['status'=>$status]);
        $doinvoice->update(['total'=>$price]);

        return response()->json(['status' => 200]);
    }

    public function do_acc(Request $request) 
    {

        $id = $request->id;
        $doinvoice = Doinvoice::with(['supplier', 'detail'])->find($id);
        $doinvoice_detail = Doinvoice_detail::with(['product'])->where('doinvoice_id','=',$doinvoice->id)->get();
       
        $status = "ACC";
        $price = 0;
        $qty = 0;

        foreach ($doinvoice_detail as $row) {

           if ($doinvoice->payment =="KASBON") {

           } else {
                if ($request->harga == "1") {
                        $row->update(['price'=>$row->product->price_b1]);
                } elseif ($request->harga == "2") {
                        $row->update(['price'=>$row->product->price_b2]);
                } else {
                        $row->update(['price'=>$row->product->price_b3]);
                }
           } 

           $price = $price + $row->price_acc*$row->qty;
           $qty = $qty + $row->qty;
        }
        

        $doinvoice->update(['qty'=>$qty]);
        $doinvoice->update(['status'=>$status]);
        $doinvoice->update(['total'=>$price]);
        $doinvoice->update(['saldo'=>$price]);

        return response()->json(['status' => 200]);
    }

    public function do_cancellacc(Request $request) 
    {

        $id = $request->id;
        $doinvoice = Doinvoice::with(['supplier', 'detail'])->find($id);
        $doinvoice_detail = Doinvoice_detail::with(['product'])->where('doinvoice_id','=',$doinvoice->id)->get();
       
        $status = "CEK HARGA";
        $price = 0;
        $qty = 0;

        foreach ($doinvoice_detail as $row) {

           if ($doinvoice->payment =="KASBON") {

           } else {
                if ($request->harga == "1") {
                        $row->update(['price'=>0]);
                } elseif ($request->harga == "2") {
                        $row->update(['price'=>0]);
                } else {
                        $row->update(['price'=>0]);
                }
           } 

           $price = $price + $row->price_acc*$row->qty;
           $qty = $qty + $row->qty;
        }
        

        $doinvoice->update(['qty'=>$qty]);
        $doinvoice->update(['status'=>$status]);
        $doinvoice->update(['total'=>$price]);
        $doinvoice->update(['saldo'=>0]);

        return response()->json(['status' => 200]);
    }

    public function do_update(Request $request) 
    {
            $fileName = '';
            $id = $request->emp_id;
            $emp = Doinvoice_detail::find($id);

            if ($request->hasFile('image1a')) {
                $file1 = $request->file('image1a');
                $fileName1 = time() . '.' . $file1->getClientOriginalExtension();
                $file1 = Image::make($file1->getRealPath());
                $file1->resize(1280,720);
                $file1->save(public_path('storage/images/'.$fileName1));
            } else {
                $fileName1 = $emp->image1;
            }

            if ($request->hasFile('image2a')) {
               $file2 = $request->file('image2a');
                $fileName2 = time() . '-2.' . $file2->getClientOriginalExtension();
                $file2 = Image::make($file2->getRealPath());
                $file2->resize(1280,720);
                $file2->save(public_path('storage/images/'.$fileName2));
            } else {
                $fileName2 = $emp->image2;
            }

            $empData = ['image1'=> $fileName1,
                        'image2'=> $fileName2];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }

    public function do_editgbr(Request $request) {		
        $id = $request->id;
        $emp = Doinvoice_detail::find($id);
        return response()->json($emp);
	}

    
    public function do_editegf(Request $request) {		
        $id = $request->id;
        $emp = Doinvoice::find($id);
        return response()->json($emp);
	}

    public function do_update2(Request $request) 
    {
            $id = $request->emp_id3;
            $emp = Doinvoice::find($id);

            if ($request->hasFile('image1a')) {
                $file1 = $request->file('image1a');
                $fileName1 = time() . '.' . $file1->getClientOriginalExtension();
                $file1 = Image::make($file1->getRealPath());
                $file1->resize(1280,720);
                $file1->save(public_path('storage/images/'.$fileName1));
            } else {
                $fileName1 = $emp->image1;
            }

            $empData = ['image1'=> $fileName1];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }
}





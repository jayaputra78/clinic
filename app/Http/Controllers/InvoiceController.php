<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Harbor;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Payinvoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Cashier;
use App\Models\Invoice;
use App\Models\Invoice_detail;
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

class InvoiceController extends Controller
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
            $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->where('status','=','AKTIF')->get();
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
        $harbors = Harbor::all();
        $members = Member::where('id','<>','999')->get();
        $users = User::where('member_id','=',$member)->where('level','=','5')->orderBy('name', 'ASC')->get();

        return view('invoice.tampil', compact('users','members','harbors','customers','warehouses','results','result2s','payinvoice', 'cashier2', 'cashier', 'menus', 'messages','messagecount','not','notcount'));
    }

	public function do_index2(Request $request) 
    {
		$member = auth()->user()->member_id;
		$level = auth()->user()->level;		

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
                $invoices =  Invoice::with('customer', 'detail','warehouse','user')
                            ->where('member_id','=',$member)
                            ->where('status', $request->filter_gender)
                            ->orderBy('tgldo', 'DESC')
                            ->get();
                            if(!empty($request->filter_country)) {	
                                $invoices =  Invoice::with('customer', 'detail','warehouse','user')
                                    ->where('member_id','=',$member)
                                    ->where('status', $request->filter_gender)
                                    ->where('jenis', $request->filter_country)
                                    ->orderBy('tgldo', 'DESC')
                                    ->get();				
                            }
 		 	} else {
                if ($level == 5 ) {
                    $invoices = Invoice::with('customer', 'detail','warehouse','user')
                                ->where('member_id','=',$member)
                                ->where('status','=',2)
                                ->orderBy('tgldo', 'DESC')
                                ->get();
                } elseif ($level == 3 ) {
                    $invoices = Invoice::with('customer', 'detail','warehouse','user')
                                ->where('member_id','=',$member)
                                ->where('status','<',3)
                                ->orderBy('tgldo', 'DESC')
                                ->get();                    
                } else { 
                    $invoices = Invoice::with('customer', 'detail','warehouse','user')
                                ->where('member_id','=',$member)
                                ->orderBy('tgldo', 'DESC')
                                ->get();
                }

            }
			return datatables()->of($invoices)
                    ->addColumn('action', 'invoice.action') 
                    ->addColumn('tanggal1', function($row)
                    {
                       $date = date("d-M-Y", strtotime($row->tgldo));
                       return $date;
                    })
                    ->addColumn('tanggal2', function($row)
                    {
                        if (auth()->user()->level == 4) {
                            $date = number_format($row->saldo);
                        } else {
                            if (!empty($row->jadwal)) {
                                $date = date("d-M H:m T", strtotime($row->jadwal));
                            } else {
                                $date = '';
                            }  
                        }
                        return $date;
                    })
                    ->addColumn('user', function($row)
                    {
                        if (!empty($row->user_id)) {
                            $user1 = $row->user->name;
                        } else {
                            $user1 = '';
                        }   
                        return $user1;
                    })
                    ->addColumn('status', function($row)
                    {
                       if ($row->status == 1 ) {
                            $status = "DO";
                       } else if ($row->status == 2 ) {
                            $status = "TAALLY";
                       } else if ($row->status == 3 ) {
                            $status = "TAGIH";
                       }
                       return $status;
                    })
                    ->rawColumns(['action','status','tanggal1','tanggal2','user'])
					->addIndexColumn()
					->make(true);		
		}

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();

        return view('invoice.tampil', compact('pays','members','lokasi','kta')); 
	}

    public function do_simpan(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id'
        ]);

        $level = auth()->user()->level;
        $member = auth()->user()->member_id;
        $uid = auth()->user()->id;

        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'note'=>$request->note,
            'warehouse_id' => $request->warehouse_id,
            'userid' => $request->userid,
            'member_id' => $request->member_id, 
            'account_id_jd' => '8',
            'account_id_jd_disc' => '86',
            'account_id_jc' => '28',
            'account_id_bd' => '32',
            'account_id_bc' => '85',
            'total' => 0,
            'saldo' => 0,
            'modal' => 0,
            'jenis' => $request->jenis,
            'berat' => 0,
            'client_id' => $request->customer2_id,
            'ware_id' => $request->warehouse2_id,
            'boat_id' =>  $request->boat_id,
            'harbor_id'=> $request->harbor_id,
            'ptally_id'=> $request->ptally_id,
            'tgldo'=> $request->tanggal,
            'status'=> 1
        ]);

        //======== Create Number INVOICE ============ 
        $id = $invoice->id;
        $invoice2 = Invoice::with('member','customer')->find($id);
        $tg = date('m',strtotime($invoice2->tanggal));
        $th = date('Y',strtotime($invoice2->tanggal));
        $note = 'DO/' . $invoice2->id . '/' . $tg . '/' . $th;
        $invoice2->update(['nodo' => $note]);
        //=== Selesai Create ===

        return redirect(route('invinvoice_index2', ['id' => $invoice2->id, 'customer_id' =>  $invoice2->customer_id ]));
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
        
        $doinvoice3 = Invoice::with(['customer', 'detail', 'detail.product','warehouse'])->find($id);
        
        $productsm = Product::orderBy('title', 'ASC')->get();
        $productsu = Product::orderBy('title', 'ASC')->get();
        $productsp = Product::orderBy('title', 'ASC')->get();   
        $users = User::where('member_id','=',$member)->where('level','=','5')->orderBy('name', 'ASC')->get();

        return view('invoice.tampil2', compact('users','productsm', 'productsu','productsp', 'doinvoice3', 'member', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function do_saves(Request $request)
    {

        $member = auth()->user()->member_id;
        $level = auth()->user()->level;

        Invoice_detail::create([
                'invoice_id' => $request->id,
                'product_id' => $request->product_id,
                'price' => 0,
                'qty'=> $request->qty,
                'tally' => $request->tally,
                'userid' => $request->userid,
                'member_id' => $request->member_id,
                'berat' => $request->berat,
                'jenis'=>$request->jenis,
                'status'=>$request->status
        ]);

        $tot = $request->berat * $request->qty;
		$emp = Invoice::find($request->id);
		$empData = ['modal'=> $emp->modal + $request->qty, 
                    'tally'=> $emp->tally + $request->tally, 
                    'berat'=> $emp->berat + $tot];
		$emp->update($empData);

		return response()->json([
			'status' => 200,
		]);
    }

	public function do_index3(Request $request) 
    {

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
                $invoices =  Invoice_detail::with('product')
                            ->where('invoice_id',$request->sid)
                            ->orderBy('created_at', 'DESC')
                            ->get();
 		 	} else {
				$invoices = Invoice_detail::with('product')
                             ->where('invoice_id',$request->sid)
                            ->orderBy('created_at', 'DESC')
                            ->get();
            }
			return datatables()->of($invoices)
                    ->addColumn('action', 'invoice.action2') 
                    ->addColumn('prod', function($row)
                    {
                       if ($row->status == "RUSAK")  {
                            if (!empty($row->image1)) {
                                $prod = $row->product->title . ' - '. $row->product->description . ' ('. $row->product->satuan . ') - (Rusak) ';
                            } else {
                                $prod = $row->product->title . ' - '. $row->product->description . ' ('. $row->product->satuan . ') - (Rusak) ';
                            }
                       } else if ($row->status == "HILANG")  {
                            $prod = $row->product->title . ' - '. $row->product->description . ' ('. $row->product->satuan . ') - (Hilang) ';
                       } else {
                           $prod = $row->product->title . ' - '. $row->product->description . ' ('. $row->product->satuan . ')';
                       }
                       return $prod;
                    })
                    ->rawColumns(['action','status','prod'])
					->addIndexColumn()
					->make(true);		
		}

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();
        $result2s = Invoice::select(DB::raw('id, customer_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('customer_id','=',''.$customer_id.'')->where('saldo','<>','0')->get(); 

        return view('invoice.tampil2', compact('invoices','members','lokasi','kta','result2s')); 
	}
    
    public function do_delete(Request $request)
    {
        $id = $request->id;
		$emp = Invoice_detail::find($id);
		Invoice_detail::destroy($id);
    }

    public function do_cetak(Request $request)
    {    
        $id = $request->id;
        $membername = auth()->user()->member->name;
        $username = auth()->user()->name;

        $invoice = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($username.' - '.$membername. ' - ID : ' . $invoice->id . ' Cont :' . $invoice->note ));
        $qrcodepenerima = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($invoice->customer->name));     
        $qrcodepembuat = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($invoice->user->name));
        $qrcodeacc = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('PIMPINAN'));
                
        $bln = date('m', strtotime($invoice->created_at));
        $thn = date('Y', strtotime($invoice->created_at));

        if ($invoice->status == "1") {
            $pdf = PDF::loadView('invoice.print1', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        } else if ($invoice->status == "2") { 
            $pdf = PDF::loadView('invoice.print1', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        } else if ($invoice->status == "3") { 
            $pdf = PDF::loadView('invoice.print2', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        }
       
        return $pdf->stream();
    }

    public function do_cetak2(Request $request)
    {    
        $id = $request->id;
        $membername = auth()->user()->member->name;
        $username = auth()->user()->name;

        $invoice = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($username.' - '.$membername. ' - ID : ' . $invoice->id . ' Cont :' . $invoice->note ));
        $qrcodepenerima = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($invoice->customer->name));     
        $qrcodepembuat = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($invoice->user->name));
        $qrcodeacc = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('PIMPINAN'));
                
        $bln = date('m', strtotime($invoice->created_at));
        $thn = date('Y', strtotime($invoice->created_at));

        if ($invoice->status == "1") {
            $pdf = PDF::loadView('invoice.print1', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        } else if ($invoice->status == "2") { 
            $pdf = PDF::loadView('invoice.print1', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        } else if ($invoice->status == "3") { 
            $pdf = PDF::loadView('invoice.print3', compact('invoice','qrcode','qrcodepenerima','qrcodepembuat','qrcodeacc','bln','thn'))->setPaper('a4', 'potrait');
        }
       
        return $pdf->stream();
    }

    public function do_update(Request $request) 
    {
            $fileName = '';
            $id = $request->emp_id;
            $emp = Invoice_detail::find($id);
            
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
        $emp = Invoice_detail::find($id);
        return response()->json($emp);
	}

    
    public function do_editegf(Request $request) {		
        $id = $request->id;
        $emp = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        return response()->json($emp);
	}

    public function do_update2(Request $request) 
    {
            $id = $request->emp_id4;
            $emp = Invoice::find($id);
            $status = 3;

            $empData = [
                'total'=> $request->total,
                'saldo'=> $request->total,  
                'status'=> $status  
            ];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }

    public function do_edittugas(Request $request) {		
        $id = $request->id;
        $emp = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        return response()->json($emp);
	}

    public function do_update3(Request $request) 
    {
            $id = $request->emp_id5;
            $emp = Invoice::find($id);
            $status = 2;

            $empData = [
                'user_id'=> $request->user_id,
                'jadwal'=> $request->jadwal,  
                'status'=> $status  
            ];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }

    public function do_uploadcont(Request $request) {		
        $id = $request->sid;
        $emp = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        return response()->json($emp);
	}

    public function do_updatecont(Request $request) 
    {
            $id = $request->emp_id1;
            $emp = Invoice::find($id);

            if ($request->hasFile('image3a')) {
                $file3 = $request->file('image3a');
                $fileName3 = time() . '.' . $file3->getClientOriginalExtension();
                $file3 = Image::make($file3->getRealPath());
                $file3->resize(1280,720);
                $file3->save(public_path('storage/images/'.$fileName3));
            } else {
                $fileName3 = $emp->image1;
            }

            if ($request->hasFile('image4a')) {
                $file4 = $request->file('image4a');
                $fileName4 = time() . '-2.' . $file4->getClientOriginalExtension();
                $file4 = Image::make($file4->getRealPath());
                $file4->resize(1280,720);
                $file4->save(public_path('storage/images/'.$fileName4));
            } else {
                $fileName4 = $emp->image2;
            }
            
            if ($request->hasFile('image5a')) {
                 $file5 = $request->file('image5a');
                 $fileName5 = time() . '-2.' . $file5->getClientOriginalExtension();
                 $file5 = Image::make($file5->getRealPath());
                 $file5->resize(1280,720);
                 $file5->save(public_path('storage/images/'.$fileName5));
             } else {
                 $fileName5 = $emp->image3;
             }

            $empData = ['image1'=> $fileName3,
                'image2'=> $fileName4,  
                'image3'=> $fileName5];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }

    public function do_uploadvideo(Request $request) {		
        $id = $request->sid;
        $emp = Invoice::with('customer', 'detail','warehouse','user')->find($id);
        return response()->json($emp);
	}

    public function do_updatevideo(Request $request) 
    {
            $id = $request->emp_id2;
            $emp = Invoice::find($id);

            if ($request->hasFile('video1')) {
                $file6 = $request->file('video1');
                $fileName6 = time() . '.' . $file6->getClientOriginalExtension();
                $path = 'storage/images/video';
                $file6->move($path, $fileName6);
            } else {
                $fileName6 = $emp->video1;
            }

            $empData = ['video1'=> $fileName6];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }


}





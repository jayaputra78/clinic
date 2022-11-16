<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Payinvoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Cashier;
use App\Models\Invoice;
use App\Models\Doinvoice;
use App\Models\Journal;
use App\Models\Payinvoice_detail;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Http\Controllers\PDFController;
use App\Models\Menu;
use App\Models\Member;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
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
            $cashiers = Cashier::orderBy('bank', 'ASC')->where('member_id','=',$member)->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->get();
            $results =   Invoice::with(['customer'])->select(DB::raw('customer_id, sum(saldo) as saldo'))->where('saldo','<>','0')->where('member_id','=',$member)->groupBy('customer_id')->get();   
            $result2s =  Doinvoice::with(['supplier'])->select(DB::raw('supplier_id, sum(saldo) as saldo'))->where('saldo','<>','0')->where('member_id','=',$member)->groupBy('supplier_id')->get();     
        } else {
            $customers = Customer::all();
            $cashiers = Cashier::orderBy('member_id', 'DESC')->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->get();
            $results =   Invoice::with(['customer'])->select(DB::raw('customer_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('customer_id')->get();  
            $result2s =   Doinvoice::with(['supplier'])->select(DB::raw('supplier_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('supplier_id')->get();            
        }
        $cashier2 = Cashier::where('member_id','=',$member)->get();

        return view('payinvoice.tampil', compact('results','result2s','payinvoice', 'cashier2', 'cashier', 'menus', 'messages','messagecount','not','notcount'));
    }

	public function pay_index2(Request $request) 
    {
		$member = auth()->user()->member_id;
		$level = auth()->user()->level;		

		if(request()->ajax()) {
			if(!empty($request->filter_gender)) {
                if ( $level < 5 ) {
                    $pays =  Payinvoice_detail::with('payinvoice','account','cashier')->where('jenis', $request->filter_gender)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
                    if(!empty($request->filter_country)) {	
                        $pays =  Payinvoice_detail::with('payinvoice','account','cashier')->where('jenis', $request->filter_gender)
                        ->where('cashier_id', $request->filter_country)
                        ->orderBy('tanggal', 'DESC')
                        ->get();				
                    }
                } else {
                    $pays =  Payinvoice_detail::with('payinvoice','account','cashier')->where('jenis', $request->filter_gender)
                    ->where('member_id','=',$member)
                    ->orderBy('tanggal', 'DESC')
                    ->get();
                    if(!empty($request->filter_country)) {	
                        $pays =  Payinvoice_detail::with('payinvoice','account','cashier')->where('jenis', $request->filter_gender)
                        ->where('cashier_id', $request->filter_country)
                        ->where('member_id','=',$member)
                        ->orderBy('tanggal', 'DESC')
                        ->get();				
                    }
                }
			} elseif(!empty($request->filter_country)) {	
                if ( $level < 5 ) {
					$pays = Payinvoice_detail::with('payinvoice','account','cashier')->where('cashier_id', $request->filter_country)
					->orderBy('tanggal', 'DESC')
					->get();	
                } else {
					$pays = Payinvoice_detail::with('payinvoice','account','cashier')->where('cashier_id', $request->filter_country)
                    ->where('member_id','=',$member)
					->orderBy('tanggal', 'DESC')
					->get();
                }
			} else {                
                if ( $level < 5 ) {
                    $pays = Payinvoice_detail::with('payinvoice','account','cashier')->orderBy('tanggal', 'DESC')->get();
                } else {
                    $pays = Payinvoice_detail::with('payinvoice','account','cashier')->where('member_id','=',$member)->orderBy('tanggal', 'DESC')->get();
                }
			}
			return datatables()->of($pays)
					->addColumn('action', 'payinvoice.action')
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);		
		}
		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();
	
        if ($level > 1 ) {
			$cashier = Cashier::where('member_id','=',$member)->get();
		} else {
			$cashier = Cashier::all();
		}

        return view('payinvoice.tampil', compact('pays','cashier', 'members','lokasi','kta')); 
	}

    public function pay_simpan(Request $request)
    {

        $level = auth()->user()->level;
        if ( $level > 1 ) {
            $member = auth()->user()->member_id;
        } else {
            $member = $request->member_id;
        }
        $payinvoice = Payinvoice::create([
            'customer_id' => $request->customer_id,
            'cashier_id' => $request->cashier_id,
            'image1' => $request->kas_id,
            'image2' => $request->cashier2_id,
            'userid' => $request->userid,
            'tanggal' => $request->tanggal,
            'total' => 0,
            'status' => 0,
            'supplier_id' => $request->supplier_id,
            'member_id' => $member,
        ]);

        $id = $payinvoice->id;
        $payinvoice2 = Payinvoice::with(['customer', 'detail', 'detail.account','cashier'])->find($id);
        $tg = date('m',strtotime($payinvoice2->tanggal));
        $th = date('Y',strtotime($payinvoice2->tanggal));
        $st = $payinvoice2->image1;
        $note = $payinvoice2->image1 . '/' . $payinvoice2->id . '/' . $tg . '/' . $th;

        $payinvoice2->update([
            'note' => $note,
        ]);

        return redirect(route('payinvoice_index2', ['id' => $payinvoice2->id, 'customer_id' =>  $payinvoice2->customer_id, 'supplier_id' =>  $payinvoice2->supplier_id ]));
    }

    public function index2(Request $request) 
    {
        $id = $request->id;
        $payinvoice3 = Payinvoice::with(['customer', 'detail', 'detail.account','cashier'])->find($id);

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

		if ($level > 1 ) {
			$cashier = Cashier::where('member_id','=',$member)->get();
		} else {
			$cashier = Cashier::all();
		}

        $customer_id = $request->customer_id;
        $supplier_id = $request->supplier_id;

        if ( $level > 1 ) {
            $cashiers = Cashier::orderBy('bank', 'ASC')->where('member_id','=',$member)->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->where('member_id','=',$member)->get();
            $customers = Customer::orderBy('name', 'ASC')->get();
            $results =   Invoice::where('customer_id','=',''.$customer_id.'')->where('saldo','<>','0')->where('member_id','=',$member)->get();
            $result2s =   Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$supplier_id.'')->where('saldo','<>','0')->get();    
        } else {
            $customers = Customer::all();
            $cashiers = Cashier::orderBy('member_id', 'DESC')->get();
            $warehouses = Warehouse::orderBy('nama', 'ASC')->get();
            $results =   Invoice::with(['customer'])->select(DB::raw('customer_id, sum(saldo) as saldo'))->where('saldo','<>','0')->groupBy('customer_id')->get();  
            $result2s =   Doinvoice::with(['supplier'])->select(DB::raw('supplier_id, CAST(sum(saldo)) as saldo, sum(saldo) as saldo2'))->where('saldo','<>','0')->groupBy('supplier_id')->get();            
        }
        
        return view('payinvoice.tampil2', compact('results', 'result2s', 'payinvoice3','account2s', 'accounts','cashier','member', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function pay_saves(Request $request)
    {

        $level = auth()->user()->level;
        if ( $level > 1 ) {
            $member = auth()->user()->member_id;
        } else {
            $member = $request->member_id;
        }

       $this->validate($request, [
            'account_id' => 'required|exists:accounts,id',
            'qty' => 'required|integer'
        ]); 

        $empData = [
            'payinvoice_id' => $request->id,
            'account_id' => $request->account_id,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'masuk' => $request->masuk,
            'keluar' => $request->keluar,
            'account_id2' => $request->account_id2,
            'userid' => $request->userid,
            'cashier_id' => $request->cashier_id,
            'member_id' => $member,
            'jenis' => $request->jenis,
            'supplier_id' => $request->supplier_id,
            'doinvoice_id' => $request->doinvoice_id,

        ];
        Payinvoice_detail::create($empData);

        $payinvoice = Payinvoice::with(['customer', 'detail', 'detail.account','cashier'])->find($request->id);
        $payinvoice->update([
           'total' => $payinvoice->total + $request->masuk - $request->keluar
        ]);

        $supplier_id = $request->supplier_id;
        $result2s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$supplier_id.'')->where('saldo','<>','0')->get(); 

        return response()->json([
           'status' => 200, '#doinvoice_id' => $result2s 
        ]);
    }

	public function pay_index3(Request $request) 
    {

        $supplier_id = $request->supplier_id;
        $member = auth()->user()->member_id;
		$level = auth()->user()->level;		

		if(request()->ajax()) {
            if(!empty($request->filter_country)) {
                    $pays = Payinvoice_detail::with('payinvoice','account','cashier')
                            ->where('payinvoice_id', $request->filter_country)
                            ->orderBy('tanggal', 'DESC')->get();
            } else {
                $pays = Payinvoice_detail::with('payinvoice','account','cashier')
                          ->where('payinvoice_id', $request->sid)
                          ->orderBy('tanggal', 'DESC')->get();   
            }
			return datatables()->of($pays)
                    ->with('total', $pays->sum('keluar'))
					->addColumn('action', 'payinvoice.action2')
					->rawColumns(['action','status'])
					->addIndexColumn()
					->make(true);		
		}

		$members = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->orderBy('kta', 'ASC')->get();
		$lokasi = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('address')->orderBy('address', 'ASC')->get();
		$kta = Member::where('id','<>','999')->where('id','<>','998')->where('id','<>','997')->groupBy('kta')->orderBy('kta', 'ASC')->get();
        $result2s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$supplier_id.'')->where('saldo','<>','0')->get(); 

        if ($level > 1 ) {
			$cashier = Cashier::where('member_id','=',$member)->get();
		} else {
			$cashier = Cashier::all();
		}

        return view('payinvoice.tampil2', compact('pays','cashier', 'members','lokasi','kta','result2s')); 
	}
    
    public function pay_delete(Request $request)
    {
        $id = $request->id;
		$emp = Payinvoice_detail::find($id);
		Payinvoice_detail::destroy($id);
    }

    public function pay_reload(Request $request) 
    {
        $result2s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->where('supplier_id','=',''.$request->id.'')->where('saldo','<>','0')->get();        
        return response()->json([$result2s]);
    }

    public function pay_reload2(Request $request) 
    {
        $result3s = Doinvoice::select(DB::raw('id, supplier_id, note, jenis, FORMAT(saldo,0) as saldo, saldo as saldo2'))->find($request->id);     
        return response()->json($result3s);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Doinvoice;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Cashier;
use App\Models\Account;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Doinvoice_detail;
use App\Models\Payinvoice_detail;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Http\Controllers\PDFController;
use App\Models\Menu;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    //Crete Laporan Pemakaian Bahan
    public function create()
    {
        $member_id = auth()->user()->member_id;
        $level = auth()->user()->level;
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

        if ( $level < 2 ) {
            $cashiers = Cashier::all();
            $member = Member::where('id','<>','999')->where('id','<>','998')->get();
        } else {
            $cashiers = Cashier::where('member_id','=',$member_id)->orderBy('id', 'DESC')->get();
            $member = Member::where('id','=',$member_id)->get();
        }

        return view('laporan.create', compact('menus','member','messages','messagecount','not','notcount'));
    }

     public function laporanjual($id,$member_id,$group)
    {

        $judul = Member::where('id','=',$member_id)->get();

        if ($id == "1") {

            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','MATERIAL')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','MATERIAL')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail1', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();               
            }

        } elseif ($id == "2") {
            
            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERALATAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERALATAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail1', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            }

        } elseif ($id == "3") {
            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERLENGKAPAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERLENGKAPAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail1', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();            
            }
        } elseif ($id == "4") {

            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','UPAH')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                $pdf = PDF::loadView('laporan.lapjualdetail', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','UPAH')->where('status','=','ACC')->orderBy('supplier', 'ASC')->get();               
                $pdf = PDF::loadView('laporan.lapjualdetail2', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
                return $pdf->stream();
            }
        } else {
            $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
            $pdf = PDF::loadView('laporan.lapjualdetail', compact('invoice_detail','judul'))->setPaper('a4', 'potrait');
            return $pdf->stream();
        
        }
    }

	public function lapjual_export($id,$member_id,$group)
    {
        $judul = Member::where('id','=',$member_id)->get();

        if ($id == "1") {

            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','MATERIAL')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                return view('laporan.exportlapjualdetail',compact('invoice_detail','judul'));
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','MATERIAL')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                return view('laporan.exportlapjualdetail1',compact('invoice_detail','judul'));                
            }

        } elseif ($id == "2") {
            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERALATAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                return view('laporan.exportlapjualdetail',compact('invoice_detail','judul'));
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERALATAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                return view('laporan.exportlapjualdetail1',compact('invoice_detail','judul'));                
            }

        } elseif ($id == "3") {

            $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','PERLENGKAPAN')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
            return view('laporan.exportlapjualdetail',compact('invoice_detail','judul'));

        } elseif ($id == "4") {
            if ($group == "1") {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','UPAH')->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
                return view('laporan.exportlapjualdetail',compact('invoice_detail','judul'));
            } else {
                $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('jenis','=','UPAH')->where('status','=','ACC')->orderBy('supplier', 'ASC')->get();
                return view('laporan.exportlapjualdetail2',compact('invoice_detail','judul'));
            }
        } else {
            $invoice_detail = Doinvoice_detail::with(['doinvoice','product'])->where('member_id','=',$member_id)->where('status','=','ACC')->orderBy('created_at', 'ASC')->get();
            return view('laporan.exportlapjualdetail',compact('invoice_detail','judul'));
        
        }
	}

    public function createhutang()
    {

        $member_id = auth()->user()->member_id;
        $level = auth()->user()->level;
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

        $suppliers = Supplier::orderBy('created_at', 'DESC')->get();
        return view('laporan.createhutang', compact('suppliers','menus', 'messages','messagecount','not','notcount'));
    }

    public function laporanhutang($id)
    {

        $tglawal1 = date('d-M-Y');       
        $tglakhir1 =date('Y-m-d H:i:s');    
        
        if ($id == "1") {
            $suppliers = Supplier::all();
            $pdf = PDF::loadView('laporan.laphutang', compact('suppliers','tglawal1'))->setPaper('a4', 'potrait');
            return $pdf->stream();
		} else {

        }
    }

    public function laphutang_export($id)
    {

        $tglawal1 = date('d-M-Y');       
        $tglakhir1 =date('Y-m-d H:i:s');    
        
        if ($id == "1") {
            $suppliers = Supplier::all();
            return view('laporan.exportlaphutang',compact('suppliers','tglawal1'));
		} else {

        }
    }

    public function createkasir()
    {
        $member_id = auth()->user()->member_id;
        $level = auth()->user()->level;
        $user = auth()->user()->id;
        $member = auth()->user()->member_id;   
    	
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

        if ( $level < 2 ) {
            $cashiers = Cashier::all();
        } else {
            $cashiers = Cashier::where('member_id','=',$member)->orderBy('id', 'DESC')->get();
        }
        return view('laporan.createkasir', compact('cashiers', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function laporancashier($tglawal,$tglakhir,$id,$kasir_id)
    {
        $tglawal1 = date('d-M-Y', strtotime($tglawal));        
        $tglakhir1 = date('d-M-Y', strtotime($tglakhir));        
        
        $tglakhir = date('Y-m-d', strtotime('+1 days', strtotime($tglakhir))); // penjumlahan tanggal sebanyak 7 hari
        

        if ($id == "1") {
            $member = auth()->user()->member_id;
            $level = auth()->user()->level;
            
            $masuk=Payinvoice_detail::where('cashier_id','=',$kasir_id)->where('created_at','<',$tglawal)->sum('masuk');  
            $keluar=Payinvoice_detail::where('cashier_id','=',$kasir_id)->where('created_at','<',$tglawal)->sum('keluar');
            $saldo=$masuk-$keluar;  
             
            $payinvoice_details = Payinvoice_detail::with(['account','payinvoice'])->whereBetween('created_at',[$tglawal,$tglakhir])->where('cashier_id','=',''.$kasir_id.'')->orderBy('tanggal', 'ASC')->get();
            
            if( $level > 1 ) {
                $cashier = Cashier::where('member','=',$member)->orderBy('no_rek', 'ASC')->find($kasir_id);
            } else {
                $cashier = Cashier::orderBy('no_rek', 'ASC')->find($kasir_id);
            }
            
            $judul = Member::where('id','=',$cashier->member_id)->get();

            $pdf = PDF::loadView('laporan.lapcashier', compact('payinvoice_details','cashier','saldo','tglawal1','tglakhir1','judul'))->setPaper('a4', 'potrait');
            return $pdf->stream();
            
        } elseif ($id == "2") {
                        
            $member = auth()->user()->member_id;
            $level = auth()->user()->level;
            
            $masuk=Payinvoice_detail::where('cashier_id','=',$kasir_id)->where('created_at','<',$tglawal)->where('account_id','=','37')->sum('masuk');  
            $keluar=Payinvoice_detail::where('cashier_id','=',$kasir_id)->where('created_at','<',$tglawal)->where('account_id','=','37')->sum('keluar');
            $saldo=$masuk-$keluar;  
             
            $payinvoice_details = Payinvoice_detail::with(['account','payinvoice'])->whereBetween('created_at',[$tglawal,$tglakhir])->where('cashier_id','=',''.$kasir_id.'')->where('account_id','=','37')->orderBy('tanggal', 'ASC')->get();
            
            if( $level > 1 ) {
                $cashier = Cashier::where('member_id','=',$member)->orderBy('no_rek', 'ASC')->find($kasir_id);
            } else {
                $cashier = Cashier::orderBy('no_rek', 'ASC')->find($kasir_id);
            }
            
            $judul = Member::where('id','=',$cashier->member_id)->get();

            $pdf = PDF::loadView('laporan.lapcashier1', compact('payinvoice_details','cashier','saldo','tglawal1','tglakhir1','judul'))->setPaper('a4', 'potrait');
            return $pdf->stream();
		} else {

        }
    }

    public function createcashflow()
    {
        $member = auth()->user()->member_id;   
        $judul = Member::where('id','=',$member);

        $member_id = auth()->user()->member_id;
        $level = auth()->user()->level;
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

        if ( $level < 2 ) {
            $cashiers = Cashier::all();
            $member = Member::where('id','<>','999')->where('id','<>','998')->get();
        } else {
            $cashiers = Cashier::where('member_id','=',$member)->orderBy('id', 'DESC')->get();
            $member = Member::where('id','=',$member)->get();
        }
        return view('laporan.createcashflow', compact('cashiers','member','judul', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function laporancashflow($id,$member_id)
    {

        $judul = Member::where('id','=',$member_id)->get();
        if ($id == "1") {
            $member = auth()->user()->member_id;
            $level = auth()->user()->level;
            
            $saldo=0;             
            $payinvoice_details = Payinvoice_detail::with(['account','payinvoice'])->where('member_id','=',''.$member_id.'')->get();
            if( $level > 1 ) {
                $cashier = Cashier::where('member_id','=',$member)->orderBy('no_rek', 'ASC')->get();
            } else {
                $cashier = Cashier::orderBy('no_rek', 'ASC')->get();
            }  
            $pdf = PDF::loadView('laporan.lapcashflow', compact('payinvoice_details','cashier','saldo','judul'))->setPaper('a4', 'landscape');
            return $pdf->stream();
		} else {

        }
    }


    public function createrugilaba()
    {

        $member_id = auth()->user()->member_id;
        $level = auth()->user()->level;
        $user = auth()->user()->id;
        $member = $member_id;
        $judul = Member::where('id','=',$member);
    	
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

        if ( $level < 2 ) {
            $cashiers = Cashier::all();
            $member = Member::where('id','<>','999')->where('id','<>','998')->get();
        } else {
            $cashiers = Cashier::where('member_id','=',$member)->orderBy('id', 'DESC')->get();
            $member = Member::where('id','=',$member)->get();
        }

        $accounts = Account::orderBy('id', 'DESC')->get();
        return view('laporan.createrugilaba', compact('accounts','member', 'judul', 'menus', 'messages','messagecount','not','notcount'));
    }

    public function laporanrugilaba($tglawal,$tglakhir,$id,$member_id)
    {
        $tglawal1 = date('d-M-Y', strtotime($tglawal));        
        $tglakhir1 = date('d-M-Y', strtotime($tglakhir));        
        $member = $member_id;
        
        $tglakhir = date('Y-m-d', strtotime('+1 days', strtotime($tglakhir))); // penjumlahan tanggal sebanyak 7 hari
        $level = auth()->user()->level;
        $judul = Member::where('id','=',$member_id)->get();

        if ($id == "1") {
            $account = Account::with(['chart'])->get();
            $jurnal_lmp = Journal::with(['account'])->select(DB::raw('account_id, sum(debet) as debet, sum(kredit) as kredit'))->where('member_id','=',$member)->where('tanggal','<', $tglawal)->groupBy('account_id')->get();    
            $jurnal_tmp = Journal::with(['account'])->select(DB::raw('account_id, sum(debet) as debet, sum(kredit) as kredit'))->where('member_id','=',$member)->whereBetween('tanggal',[$tglawal,$tglakhir])->groupBy('account_id')->get();
            
            foreach ($account as $row) {
                $awal = 0;
                $row->update(['awal'=>$awal]);
                $row->update(['bulan'=>$awal]);
                $row->update(['akhir1'=>$awal]);
            }

            foreach ($account as $row) {	
                $account1 = Account::find($row->id);		
                if ($account1) {
                    $awal = 0;
                    $account1->update(['awal'=>$awal]);
                    $account1->update(['bulan'=>$awal]); 
                }
            }      
            foreach ($jurnal_lmp as $row) {			
                $account1 = Account::find($row->account_id);
                if ($account1) {
                    $awal = $row->debet-$row->kredit;
                    $account1->update(['awal'=>$awal]);
                }
            }
            foreach ($jurnal_tmp as $row) {			
                $account1 = Account::find($row->account_id);              
                if ($account1) {
                    $bulan = $row->debet-$row->kredit;
                    $akhir = $account1->awal + $bulan;
                    $account1->update(['bulan'=>$bulan]);
                    $account1->update(['akhir1'=>$akhir]);
                }
            }
            $account_p = Account::with(['chart'])->where('kelompok','=','4')->orderBy('account', 'ASC')->get();
            $account_b = Account::with(['chart'])->where(function ($query) { $query->where('kelompok','=','5')->orWhere('kelompok','=','51'); })->orderBy('account', 'ASC')->get();
            $pdf = PDF::loadView('laporan.laprugilababulanan', compact('account_p','account_b','tglawal1','tglakhir1','level','judul'))->setPaper('a4', 'potrait');
            return $pdf->stream();
		} else {
            $account_p = Account::with(['chart'])->where('kelompok','=','4')->orderBy('account', 'ASC')->get();
            $account_b = Account::with(['chart'])->where('kelompok','=','5')->where('kelompok','=','51')->orderBy('account', 'ASC')->get();
            $pdf = PDF::loadView('laporan.laprugilaba', compact('account_p','account_b','tglawal1','tglakhir1','level','judul'))->setPaper('a4', 'potrait');
            return $pdf->stream();
        }
    }

}

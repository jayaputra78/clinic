<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

        return view('layout.main', compact('menus','messages','messagecount','not','notcount')); 

       // return view('layout.main');
	}
    
}

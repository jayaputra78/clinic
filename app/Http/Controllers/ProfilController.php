<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Message;
use App\Models\User;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProfilController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $users = User::where('id','=',$user);

        return view('profil.tampil', compact('users','menus','messages','messagecount','not','notcount')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\t  $t
     * @return \Illuminate\Http\Response
     */
    public function show(t $t)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\t  $t
     * @return \Illuminate\Http\Response
     */
    public function edit(t $t)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\t  $t
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $filename = '';
		$emp = User::find($request->emp_id2);
		$empData = ['name'=>$request->name, 
                    'catatan'=>$request->catatan,
					'alamat'=>$request->address,
					'nohp'=>$request->phone];

        $emp->update($empData);
        return response()->json(['status' => 200]);
    }

    public function update2(Request $request) 
    {
            $id = $request->emp_id;
            $emp = User::find($id);
            $fileName1 = '';
        
            if ($request->hasFile('image1a')) {
                $file1 = $request->file('image1a');
                $fileName1 = time() . '.' . $file1->getClientOriginalExtension();
                $file1 = Image::make($file1->getRealPath());
                $file1->resize(120,120);
                $file1->save(public_path('storage/images/'.$fileName1));
            } else {
                $fileName1 = $emp->image1;
            }

            $empData = ['image1'=> $fileName1];
            $emp->update($empData);

            return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\t  $t
     * @return \Illuminate\Http\Response
     */
    public function destroy(t $t)
    {
        //
    }
}

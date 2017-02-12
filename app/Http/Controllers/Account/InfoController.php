<?php

namespace App\Http\Controllers\Account;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InfoController extends Controller
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
     * 顯示帳戶資訊及基本資料編輯畫面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['info'] = Auth::user();

        $data['profile'] = $data['info']->profile ?? (object)[];
        
        return view('account.info', $data);
    }
}

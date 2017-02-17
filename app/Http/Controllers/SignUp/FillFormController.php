<?php

namespace App\Http\Controllers\SignUp;

use Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Activity;

class FillFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * 顯示填寫報名資料的表單畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity)
    {
        $data['activity'] = Activity::find($activity);

        $data['user_account'] = Auth::user();

        $data['user_profile'] = $data['user_account']->profile;
        
        return view('sign-up.fill-form', $data);
    }

    /**
     * 顯示已發佈活動的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($activity)
    {
        $data['activity'] = Activity::find($activity);

        return view('activity', $data);
    }
}

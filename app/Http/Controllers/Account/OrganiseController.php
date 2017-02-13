<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrganiseController extends Controller
{
    /**
     * 顯示舉辦活動的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        
        return view('account.organise-activities', $data);
    }

    public function edit()
    {
        $data = [];

        return view('account.organise-activity', $data);
    }
}

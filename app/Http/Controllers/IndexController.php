<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Organizer;

class IndexController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['random_activities'] = Activity::with('attachments')
            ->ofStatus(1)
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();
        
        $data['activities'] = Activity::with('attachments')->ofStatus(1)->take(3)->get();

        $data['organizers'] = Organizer::with('account', 'attachments')->take(3)->get();

        return view('index', $data);
    }
}

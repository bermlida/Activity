<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Organizer;

class OrganizerController extends Controller
{
    /**
     * 顯示主辦單位的列表畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizers = Organizer::with('attachments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organizers', ['organizers' => $organizers]);
    }

    /**
     * 顯示主辦單位的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($organizer)
    {
        $data['info'] = Organizer::find($organizer);

        $data['banner'] = $data['info']->attachments()->isBanner()->first();
        
        $data['activities'] = $data['info']->activities()
            ->with('attachments')
            ->where('end_time', '>=', Carbon::now())
            ->get();

        $data['histories'] = $data['info']->activities()
            ->with('attachments')
            ->where('end_time', '<', Carbon::now())
            ->get();

        return view('organizer', $data);
    }
}

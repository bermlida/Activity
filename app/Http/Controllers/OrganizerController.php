<?php

namespace App\Http\Controllers;

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
        $data['organizers'] = Organizer::all();

        return view('organizers', $data);
    }

    /**
     * 顯示主辦單位的資訊畫面。
     *
     * @return \Illuminate\Http\Response
     */
    public function info($organizer)
    {
        $data['organizer'] = Organizer::find($organizer);

        return view('organizer', $data);
    }
}

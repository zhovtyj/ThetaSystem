<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\Status;
use Auth;

class PagesController extends Controller
{

    public function getIndex(){

        //Check if Agent is login
        if(Auth::user() &&Auth::user()->role->name == 'Agent'){

            //ID of login Agent
            $user_id = Auth::user()->id;

            //ID of DONE status
            $status_done_id = Status::where('name', 'DONE')->select('id')->first();
            //ID of MD status
            $status_md_id = Status::where('name', 'MD')->select('id')->first();

            //Number of completed (MD/Done) , total number and percentage
            $counts = [];
            $counts['total'] = Entry::where('user_id', '=', $user_id)->count();
            $counts['completed'] = Entry::where('user_id', $user_id)->whereIn('status_id', [$status_done_id->id, $status_md_id->id])->count();
            if($counts['total'] == 0){
                $counts['percentage'] = 0;
            }else{
                $counts['percentage'] = round($counts['completed']/$counts['total']*100);
            }


            //First entry link, which is not with DONE status
            //We will need this link on every Agents page(because we show it in header)
            if($entry_link = Entry::where([['user_id', '=', $user_id], ['status_id', '!=', $status_done_id->id]])->first()){

                return view('pages.welcome')->withEntry_link($entry_link->link)->withCounts($counts);

            }else{

                $entry_link = "";
                return view('pages.welcome')->withEntry_link($entry_link)->withCounts($counts);
            }
        }

        return view('pages.welcome');



    }

}

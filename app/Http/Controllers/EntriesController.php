<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Entry;
use App\Status;


class EntriesController extends Controller
{
    public function getIndex($link)
    {
        $entry = Entry::where('link', $link)->first();
        $statuses = Status::all();

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

        return view('entries.show')
            ->withEntry($entry)
            ->withStatuses($statuses)
            ->withCounts($counts)
            ->withEntry_link($entry->link);//We need this link for header
    }

    public function update(Request $request, $link)
    {
        $entry = Entry::where('link', $link)->first();
        $entry->status_id = $request->status_id;
        $entry->modified_count = $entry->modified_count + 1;
        $entry->save();

        Session::flash('success', 'The status of '.$entry->name.' has been changed!');

        //ID of login Agent
        $user_id = Auth::user()->id;

        //ID of DONE status
        $status_id = Status::where('name', 'DONE')->select('id')->first();

        //First entry link, which goes after updated link and it is not with DONE status
        if($entry_link = Entry::where([['user_id', '=', $user_id], ['status_id', '!=', $status_id->id], ['id', '>', $entry->id]])->select('link')->first()){

            return redirect()->route('entries', $entry_link->link);
        }

        //First entry link and it is not with DONE status
        elseif($entry_link = Entry::where([['user_id', '=', $user_id], ['status_id', '!=', $status_id->id]])->select('link')->first()){

            return redirect()->route('entries', $entry_link->link);
        }

        Session::flash('success', 'The status of '.$entry->name.' has been changed! No entries left!');
        return redirect('/');

    }
}

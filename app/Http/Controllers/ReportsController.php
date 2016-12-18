<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;
use App\User;
use App\Status;

class ReportsController extends Controller
{
    public function getIndex(Request $request)
    {

        //Check request. If there are parameters for filter - we filter entries
        if ($request->has('filter_id') && $request->has('filter_name')){
            $filter_name = $request->get('filter_name');
            $filter_id = $request->get('filter_id');
            $entries = Entry::where($filter_name, $filter_id)->get();

            //Witch tab of filter will be active
            if($filter_name == 'status_id'){
                $active_user = ' ';
                $active_status = 'active';
            }else{
                $active_user  = 'active';
                $active_status = ' ';
            }


        }else{
            //If no filters - show all entries; the active tab of filter - is user tab; defaults value of selected option is 0
            $entries = Entry::all();
            $active_user = 'active';
            $active_status = ' ';
            $filter_id = 0;
        }

        //Need this variables for filter to show filter options
        $users = User::all();
        $statuses = Status::all();

        return view('reports.index')
            ->withEntries($entries)
            ->withUsers($users)
            ->withStatuses($statuses)
            ->withActive_user($active_user)
            ->withActive_status($active_status)
            ->withFilter_id($filter_id);
    }

    public function changeStatus(Request $request)
    {
        $entry = Entry::find($request->entry_id);
        $entry->status_id = $request->status_id;
        $entry->save();

    }

}

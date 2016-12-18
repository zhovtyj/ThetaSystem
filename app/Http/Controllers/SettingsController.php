<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Excel;
use App\User;
use App\Role;
use App\Status;
use App\Entry;

class SettingsController extends Controller
{
    public function getIndex()
    {
        $users = User::all();
        $roles = Role::all();

        //ID of DONE status
        $status_done_id = Status::where('name', 'DONE')->select('id')->first();
        //ID of MD status
        $status_md_id = Status::where('name', 'MD')->select('id')->first();
        foreach ($users as $key => $user){

            //Number of completed (MD/Done) , total number and percentage
            $users[$key]['total'] = Entry::where('user_id', '=', $user->id)->count();
            $users[$key]['completed'] = Entry::where('user_id', $user->id)->whereIn('status_id', [$status_done_id->id, $status_md_id->id])->count();
            if($users[$key]['total'] == 0){
                $users[$key]['percentage'] = 0;
            }else{
                $users[$key]['percentage'] = round($users[$key]['completed']/$users[$key]['total']*100);
            }

        }

        return view('settings.index')->withUsers($users)->withRoles($roles);
    }

    public function saveUser(Request $request)
    {
        $this->validate($request, array(
            'name'         => 'required|max:255|unique:users,name',
            'password'   => 'required|min:5|max:255',
            'enabled'          => 'required',
            'role_id'=> 'required|integer'
        ));

        $user = new User;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->enabled = $request->enabled;
        $user->role_id = $request->role_id;
        $user->save();

        Session::flash('success', 'User created successfully.');

        return redirect()->route('settings');
    }

    public function importCsv(Request $request)
    {
        if($request->hasfile('import_file')){
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) { })->get();
            if(!empty($data) && $data->count()){

                $users = User::all();
                $entries = Entry::all();
                //ID of BN status
                $status_bn_id = Status::where('name', 'BN')->select('id')->first();
                $success_imported = 0;
                foreach ($data as $key => $value) {

                    if(!$value->name){
                        $value['Result'] = 'Error: Name is required. ';
                    }
                    elseif(!$value->phone){
                        $value['Result'] = 'Error: Phone is required. ';
                    }

                    elseif (!($user = $users->where('name', '==', trim($value->username))->first())){
                        $value['Result'] = 'Error: No user found. ';
                    }
                    elseif(!$value->link){
                        $value['Result'] = 'Error: Link is required. ';
                    }
                    elseif($link = $entries->where('link', '==', trim($value->link))->first() ){

                        $value['Result'] = 'Error: Link is not unique. ';
                    }
                    else{
                        $value['Result'] = 'OK';
                        $success_imported++;

                        $insert[] = ['name' => $value->name,
                            'phone' => $value->phone,
                            'user_id' => $user->id,
                            'link' => trim($value->link),
                            'status_id' => $status_bn_id->id,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")];
                    }
                }
                if(!empty($insert)){
                    DB::table('entries')->insert($insert);

                    $message = $success_imported.' entries were imported successfully. '.($data->count() - $success_imported).' errors. Click the link <a href="/public/upload/Export CSV.csv">CSV Download</a>';
                    Session::flash('success', $message);

                    $location = public_path('upload/');

                    Excel::create('Export CSV', function($excel) use ($data){
                        $excel->sheet('Sheet 1', function($sheet) use ($data){
                            $sheet->fromArray($data);
                        });
                    })->save('csv', $location);

                    return redirect()->route('settings');


                }else{
                    Session::flash('warning', 'Nothing to import! CSV is empty or all entries have errors.');
                }
            }
        }
        return back();
    }
}

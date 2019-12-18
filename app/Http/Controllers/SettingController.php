<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        $record = Setting::get()->first();
        return view('settings.create' , compact('record'));
    }

    public function store(Request $request)
    {
        $rules = [
            'play_store_url'            => 'url|nullable' , 
            'app_store_url'             => 'url|nullable' ,
            'notification_setting_text' => 'nullable' ,
            'about_app'                 => 'nullable' ,
            'phone'                     => 'starts_with:01|nullable' ,
            'email'                     => 'email|nullable' ,
            'fb_link'                   => 'url|nullable' ,
            'tw_link'                   => 'url|nullable' ,
            'youtube_link'              => 'url|nullable' ,
            'insta_link'                => 'url|nullable' ,
            'whats_link'                => 'url|nullable' ,
            'google_link'               => 'url|nullable' 
        ];

        $this->validate($request , $rules);

        $record = Setting::get()->first();
        if($record)
        {
            $record->update($request->all());  //update
        }

        else 
        {
            Setting::create($request->all()); //create
        }

        return redirect(url(route('setting.create')))->with('success','Edited successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    public function index()
    {
        $records = User::all();
        return view('users.index' , compact('records'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'email',
            'password' => 'confirmed',
            'roles_list' => 'required|array'
        ];

        $this->validate($request , $rules);

        $request->merge(['password' => bcrypt($request->password)]); 
        $user = User::create($request->all());
        $user->roles()->attach($request->input('roles_list'));

        return redirect(url(route('user.index')))->with('success','User created successfully!');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);                //if fail return 404
        //dd($record);
        return view('users.edit' , compact('record'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'email',
            'password' => 'confirmed',
            'roles_list' => 'required|array'
        ];

        $this->validate($request , $rules);

        $record = User::findOrFail($id); 
        $request->merge(['password' => bcrypt($request->password)]); 
        $record->update($request->all());
        $record->roles()->sync($request->input('roles_list'));
        return back()->with('success','User updated successfully!');
    }

    public function destroy($id)
    {
        $record = User::findOrFail($id); 
        $record->delete();
        return redirect(url(route('user.index')))->with('error','User deleted successfully!');

    }
}

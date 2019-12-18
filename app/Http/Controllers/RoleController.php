<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    
    public function index()
    {
        $records = Role::all();
        return view('roles.index' , compact('records'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:roles',
            'display_name' => 'required',
            'permission_list' => 'required|array'
        ];

        $messages = [
            'name.required' => 'You should enter the name of the Role',
            'display_name.required' => 'You should enter the display name of the Role'
        ];

        $this->validate($request , $rules , $messages);

        $role = Role::create($request->all());
        $role->permissions()->attach($request->input('permission_list'));


        return redirect(url(route('role.index')))->with('success','Role created successfully!');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $record = Role::findOrFail($id);                    //if fail return 404
        return view('roles.edit' , compact('record'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:roles,name,'.$id ,
            'display_name' => 'required',
            'permission_list' => 'required|array'
        ];

        $messages = [
            'name.required' => 'You should enter the name of the Role',
            'display_name.required' => 'You should enter the display name of the Role'
        ];

        $this->validate($request , $rules , $messages);

        $record = Role::findOrFail($id); 
        $record->update($request->all());
        $record->permissions()->sync($request->input('permission_list'));
        return back()->with('success','Role updated successfully!');
    }

    public function destroy($id)
    {
        $record = Role::findOrFail($id); 
        $record->delete();
        return redirect(url(route('role.index')))->with('error','Role deleted successfully!');

    }
}

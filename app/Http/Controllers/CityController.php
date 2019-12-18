<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Validation\Rule;


class CityController extends Controller
{
    public function index()
    {
        $records = City::paginate(20);
        return view('city.index' , compact('records'));
    }

    public function create()
    {
        $items = Governorate::all(['id', 'name']);
        return view('city.create', compact('items'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:cities' , 
            'governorate_id' => 'required'
        ];

        $messages = [
            'name.required' => 'You should enter the name of the city' ,
            'governorate_id.required' => 'You should enter the governorate of the city'
        ];

        $this->validate($request , $rules , $messages);

        City::create($request->all());

        return redirect(url(route('city.index')))->with('success','City created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $record = City::findOrFail($id);                    //if fail return 404
        $items = Governorate::all(['id', 'name']);
        return view('city.edit')->with([
            'record' => $record ,  
            'items' => $items
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required',
                        Rule::unique('cities')->ignore($id), ], 
            'governorate_id' => 'required'
        ];

        $messages = [
            'name.required' => 'You should enter the name of the city' ,
            'governorate_id.required' => 'You should enter the governorate of the city'
        ];

        $this->validate($request , $rules , $messages);

        $model = City::findOrFail($id); 
        $model->update($request->all());

        return redirect(url(route('city.index')))->with('success','City updated successfully!');
    }

    public function destroy($id)
    {
        $record = City::findOrFail($id); 
        $record->delete();
        return redirect(url(route('city.index')))->with('error','City deleted successfully!');
    }
}

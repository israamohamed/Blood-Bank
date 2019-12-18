<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\BloodType;
use App\Models\City;
use App\Models\Governorate;

class ClientController extends Controller
{

    public function index()
    {

        $records = Client::paginate(20);
        $blood_types = BloodType::all();
        return view('clients.index')->with([
            'records' => $records ,
            'blood_types' => $blood_types
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $record = Client::findOrFail($id); 
        $record->delete();
        return redirect(url(route('client.index')))->with('error','Client deleted successfully!');
    }

    public function search(Request $request)
    {
        $city        = $request->input('search_by_city');
        $governorate = $request->input('search_by_governorate');
        $phone       = $request->input('search_by_phone');
        $name        = $request->input('search_by_name');
        $blood_type  = $request->input('search_by_blood_type');

        $records = Client::where(function($query) use($city,$phone,$governorate,$name,$blood_type){

                if($city)
                {
                    $city_id = City::where('name'  , 'like', '%'.$city.'%')->pluck('id');
                    $query->whereIn('city_id' , $city_id );   
                }

                if($phone)
                {
                    $query->where('phone' , 'like' ,  '%'.$phone.'%' );
                }

                if($governorate)
                {
                    $governorate_id = Governorate::where('name' , 'like' , '%'.$governorate.'%' )->pluck('id');
                    $city_id = City::whereIn('governorate_id'  , $governorate_id)->pluck('id');
                    $query->whereIn('city_id' , $city_id );
                }

                if($name)
                {
                    $query->where('name' , 'like' ,  '%'.$name.'%' );
                }

                if($blood_type)
                {
                    $query->where('blood_type_id' , $blood_type );
                }


        })->paginate(20);

        $blood_types = BloodType::all();
        return view('clients.index')->with([
            'records' => $records ,
            'blood_types' => $blood_types 
        ]);
       
    }
    public function activation($id)
    {
        $record = Client::findOrFail($id); 
        $record->is_active = ($record->is_active) ? 0 : 1 ;
        $record->save();

        $result = ($record->is_active) ? 'Activated' : 'Deactivated' ;
        return back()->with('success' , $result . ' successfully ! ');
    }
}

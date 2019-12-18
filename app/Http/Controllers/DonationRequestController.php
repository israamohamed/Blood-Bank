<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Models\BloodType;
use App\Models\City;
use App\Models\Governorate;

class DonationRequestController extends Controller
{
    public function index()
    {
        $records = DonationRequest::paginate(10);
        $blood_types = BloodType::all();
        return view('donations.index')->with([
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
        $record = DonationRequest::find($id);
        return view('donations.show' , compact('record'));
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
        $record = DonationRequest::find($id);
        $record->delete();
        return redirect(url(route('donation.index')))->with('error','Donation Request deleted successfully!');
    }

    public function search(Request $request)
    {
        $city        = $request->input('search_by_city');
        $governorate = $request->input('search_by_governorate');
        $hospital    = $request->input('search_by_hospital_name');
        $blood_type  = $request->input('search_by_blood_type');

        $records = DonationRequest::where(function($query) use($city,$governorate,$hospital,$blood_type){

                if($city)
                {
                    $city_id = City::where('name'  , 'like', '%'.$city.'%')->pluck('id');
                    $query->whereIn('city_id' , $city_id );   
                }

                if($governorate)
                {
                    $governorate_id = Governorate::where('name' , 'like' , '%'.$governorate.'%' )->pluck('id');
                    $city_id = City::whereIn('governorate_id'  , $governorate_id)->pluck('id');
                    $query->whereIn('city_id' , $city_id );
                }

                if($hospital)
                {
                    $query->where('hospital_name' , 'like' ,  '%'.$hospital.'%' );
                }

                if($blood_type)
                {
                    $query->where('blood_type_id' , $blood_type );
                }


        })->paginate(10);

        $blood_types = BloodType::all();
        return view('donations.index')->with([
            'records' => $records ,
            'blood_types' => $blood_types
        ]);
    }
}



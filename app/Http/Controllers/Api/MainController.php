<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Governorate;
use App\Models\City;
use App\Models\Category;
use App\Models\Contact;
use App\Models\BloodType;
use App\Models\Setting;
use App\Models\DonationRequest;
use App\Models\Token;

class MainController extends Controller
{
    public function posts(Request $request) 
    {
        $posts = Post::with('category')->where(function($query) use($request){
            if($request->has('category_id'))
            {
                $query->where('category_id' , $request->category_id);
            }

        })->paginate(10);
        return responceJson(1 , 'success' , $posts);
    }

    public function post(Request $request) 
    {
        $post = Post::where('id' , $request->id)->with('category')->get();
        return responceJson(1 , 'success' , $post);
    }

    public function governorates()
    {
        $governorates = Governorate::all();
        return responceJson(1, 'success' , $governorates);
    }

    public function cities(Request $request) 
    {
        $cities = City::where(function($query) use ($request) {
            if($request->has('governorate_id'))
            {
                $query->where('governorate_id' , $request->governorate_id);
            }
      
        })->get();
        return responceJson(1, 'success' , $cities);
    }

    public function categories()
    {
        $categories = Category::all();
        return responceJson(1, 'success' , $categories);
    }

    public function bloodTypes()
    {
        $bloodTypes = BloodType::all();
        return responceJson(1, 'success' , $bloodTypes);
    }

    public function contacts(Request $request) 
    {
        $validator = validator()->make($request->all() , [
            'name'              => 'required' , 
            'email'             => 'required|email',
            'phone'             => 'required',
            'subject'           => 'required',
            'message'           => 'required' 
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $contact = Contact::create($request->all());
        return responceJson(1 , 'تم الارسال' , $contact);
    }

    public function settings() 
    {
        $settings = Setting::get()->first();
        return responceJson(1, 'success' , $settings);
    }

    public function listFavourites(Request $request) 
    {
        $client = $request->user();
        $client_posts = $client->posts()->get();
        return responceJson(1 , 'success' , $client_posts);
    }

    public function listNotifications(Request $request) 
    {
        $client = $request->user();
        $client_notifications = $client->notifications()->get();
        return responceJson(1 , 'success' , $client_notifications);
    }

    public function toggleFavourite(Request $request) 
    {
        $client = $request->user();
        $client->posts()->toggle($request->post_id);
        
        $is_fav= $client->posts()->where('post_id' , $request->post_id)->first();
    
        if($is_fav)
        {
            return responceJson(1 , 'yes' , $client);
        }
        
        else 
        {
            return responceJson(0 , 'no' , $client);
        }      

    }

    public function donationRequests()
    {
        $donation_requests = DonationRequest::paginate(4);
        return responceJson(1 , 'success' , $donation_requests);
    }

    public function donationRequest(Request $request)
    {
        $donation_request = DonationRequest::where('id' , $request->donation_request_id)->get();
        return responceJson(1 , 'success' , $donation_request);
    }

    public function donationRequestCreate(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'patient_name'    => 'required'                      , 
            'patient_age'     => 'required|numeric'              ,
            'patient_phone'   => 'required|digits:11'            ,
            'blood_type_id'   => 'required|exists:blood_types,id',
            'bags_num'        => 'required|numeric'              ,
            'hospital_name'   => 'required'                      ,
            'hospital_address'=> 'required'                      ,
            'latitude'        => 'required'                      ,
            'longitude'       => 'required'                      ,
            'city_id'         => 'required|exists:cities,id'     ,
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        
        /*$donation_request = DonationRequest::create($request->all());
        $donation_request->client_id = $request->user()->id;
        $donation_request->save();*/
        $donation_request = $request->user()->donationRequests()->create($request->all());

        $clientsIds = $donation_request->city->governorate
                     ->clients()->whereHas('bloodTypes' , function($q) use($request){
                        $q->where('blood_types.id' , $request->blood_type_id);
                     })->pluck('clients.id')->toArray();

        if(count($clientsIds) > 0)
        {
            $notification = $donation_request->notification()->create([
                'title'   => 'احتاج إلى متبرع',
                'content' => $request->user()->name .  ' يحتاج إلى متبرع للفصيلة ' . $donation_request->bloodType->name
            ]);

            $notification->clients()->attach($clientsIds);
            $tokens = Token::whereIn('client_id' , $clientsIds)->where('token' , '!=' , null)->pluck('token')->toArray();
            //dd($tokens);
            if(count($tokens) > 0)
            {
                $title   = $notification->title;
                $content = $notification->content;
                $data    = [
                    'donation_request_id' => $donation_request->id
                ];

                $send = notifyByFirebase($title , $content , $tokens , $data , true);

                //return responceJson(1 , 'message' , $send);
            }
        }
        
        //dd($send);
        //return responceJson(1 , 'message' , $notification);
        return responceJson(1 , 'message' , $donation_request);
    }
}


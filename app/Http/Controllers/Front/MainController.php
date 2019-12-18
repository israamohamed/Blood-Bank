<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Client;
use App\Models\DonationRequest;
use App\Models\Contact;
use App\Models\Token;


class MainController extends Controller
{
    public function home()
    {
        $title = "بنك الدم";
        $posts = Post::take(9)->get();
        $donations = DonationRequest::take(5)->get();
        return view('front.index')->with([
            'posts' => $posts  ,
            'donations' => $donations , 
            'title'  => $title
        ]);
    }

    public function about()
    {
        $title = "من نحن";
        return view('front.about' , compact('title'));
    }

    public function contact()
    {
        $title = "تواصل معنا";
        return view('front.contact' , compact('title'));
    }

    public function contact_submit(Request $request)
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
            return back()->with('error' , 'يوجد مشكلة بالبيانات');
        }

        $contact = Contact::create($request->all());

        return back()->with('success' , 'تم الإرسال ');
    }

    public function toggleFavourite(Request $request)
    {
        $client = $request->user();
        $toggle = $client->posts()->toggle($request->post_id);
        return responceJson(1 , 'success' , $toggle);
    }

    public function donations()
    {
        $title = "طلبات التبرع";
        $donations = DonationRequest::paginate(4);
        return view('front.donations')->with([
            'donations' => $donations , 
            'title' => $title
        ]);
    }

    public function donation_show($id)
    {
        
        $donation = DonationRequest::find($id);
        $title = $donation->patient_name;
        return view('front.donation_show')->with([
            'donation' => $donation , 
            'title' => $title
        ]);
    }

    public function donation_search(Request $request)
    {
        $blood_type = $request->input('blood_type') ;
        $city       = $request->input('city');

        $result = DonationRequest::where(function($query) use($blood_type , $city)
                {
                    if($blood_type)
                    {
                        $query->where('blood_type_id' , $blood_type );   
                    }
                    if($city)
                    {
                        $query->where('city_id' , $city );
                    }
                })->with('bloodType' , 'city')->paginate(2);

        return responceJson(1 , 'success' , $result);
    }

    public function donation_create()
    {
        $title = "إضافة طلب تبرع ";
        return view('front.donation_create'  , compact('title'));
    }

    public function donation_create_submit(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'patient_name'    => 'required'                      , 
            'patient_age'     => 'required|numeric'              ,
            'patient_phone'   => 'required|digits:11'            ,
            'blood_type_id'   => 'required|exists:blood_types,id',
            'bags_num'        => 'required|numeric'              ,
            'hospital_name'   => 'required'                      ,
            'hospital_address'=> 'required'                      ,
            'city_id'         => 'required|exists:cities,id'     ,
        ]);

        if($validator->fails())
        {
            return back()->with('error' , 'يوجد مشكلة بالبيانات');
        }

        
     
        $request->merge(['latitude' => 30.0227651 , 'longitude' => 31.224829]); 
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
     
        return back()->with('success' , 'تم الارسال ');
    }

    public function posts()
    {
        $title = "المقالات";
        $posts = Post::paginate(4);
        return view('front.posts')->with([
            'posts' => $posts , 
            'title' => $title
        ]);
    }

    public function favourite_posts()
    {
        $title = "المفضلة ";
        $posts = request()->user()->posts()->paginate(4);
        return view('front.posts')->with([
            'posts' => $posts , 
            'title' => $title
        ]);
    }

    public function post_show($id)
    {
        $post = Post::find($id);
        $title = $post->title;
        $related_posts = Post::where('category_id' , $post->category->id)->take(6)->get();
        return view('front.post_show')->with([
            'post' => $post , 
            'related_posts' => $related_posts , 
            'title' => $title
        ]);
    }

    
}

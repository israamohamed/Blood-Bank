<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Token;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'name'              => 'required' , 
            'phone'             => 'required',
            'dob'               => 'required',
            'blood_type_id'     => 'required' , 
            'last_donation_date'=> 'required' ,
            'city_id'           => 'required' , 
            'email'             => 'required|email|unique:clients',
            'password'          => 'required|confirmed'
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]); 
        $client = Client::create($request->all());
        $client->api_token = str_random(60);
        $client->save();
        return responceJson(1 , 'تم الاضافة بنجاح' , [
            'api_token' => $client->api_token , 
            'client'    => $client
        ]);

    }


    public function login(Request $request) 
    {
        $validator = validator()->make($request->all() , [
            'phone'    => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }
        
        $client = Client::where('phone' , $request->phone)->first();
        if($client)
        {
            if(Hash::check( $request->password , $client->password))
            {
                return responceJson(1 , 'تم تسجيل الدخول' , [
                    'api_token' => $client->api_token , 
                    'client'    => $client
                ]);
            }

            else 
            {
                return responceJson(0 , '1بيانات الدخول غير صحيحة' , $validator->errors());
            }
        }

        else
        {
            return responceJson(0 , '2بيانات الدخول غير صحيحة' , $validator->errors());
        }
    }

    public function resetPassword(Request $request) 
    {

        $validator = validator()->make($request->all() , [
            'phone'    => 'required'
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }
        
        $client = Client::where('phone' , $request->phone)->first();
        if($client)
        {
            //Generate pin code
            $client->pin_code = rand(5000,99999999);
            $client->save();

            //Send email to that user
            Mail::to($client->email)
            ->bcc("israamohamed41@gmail.com")
            ->send(new resetPassword($client->pin_code));

            if (Mail::failures()) 
            {
                return responceJson(0 , 'حدث خطأ أثناء الإرسال' , Mail::failures());
            }
            else 
            {
                return responceJson(1 , 'أفحص البريد الخاص بك' ,$client);
            }
        }

    }

    public function newPassword(Request $request) 
    {
        $validator = validator()->make($request->all() , [
            'pin_code'    => 'required',
            'password'    => 'required|confirmed',
            'phone'       => 'required'
        ]);

        //validation
        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        //search for the client with the specific phone
        $client = Client::where('phone' , $request->phone)->first();

        if($client)
        {
            //compare between pin code from request and pin code from db
            if($request->pin_code == $client->pin_code)
            { 
                $client->password = bcrypt($request->password);
                $client->pin_code = null;
                $client->save();
                return responceJson(1 , "تم تغيير كلمة المرور", $client);
            }

            else
            {
                return responceJson(0 , "الكود التأكيدي غير صحيح");
            } 
        }

        else 
        {
            return responceJson(0 , "الرقم غير صحيح");
        }

    }

    public function profile(Request $request) 
    {
        if($request->isMethod('GET'))
        {
            $client = $request->user();
            return responceJson(0 , "success" , $client);
        }

        else if($request->isMethod('PUT'))
        {
            $validator = validator()->make($request->all() , [
                'email'             => 'email|unique:clients,email,'.$request->user()->id,
                'password'          => 'confirmed'
            ]);
    
            if($validator->fails())
            {
                return responceJson(0 , $validator->errors()->first() , $validator->errors());
            }

            $client = $request->user();
            if($request->has('password')) 
            {
                $request->merge(['password' => bcrypt($request->password)]); 
            }
            $client->update($request->all());
            return responceJson(0 , 'تم التعديل' , $client);
        }

    }

    public function notificationSettings(Request $request) 
    {
        $client = $request->user();

        if($request->isMethod('GET'))
        {          
            //get blood types and governorates of that user
            $bloodTypes   = $client->bloodTypes()->pluck('blood_types.id')->toArray();
            $governorates = $client->governorates()->pluck('governorates.id')->toArray();

            return responceJson(1 , 'success' , [
                'bloodTypes'  =>  $bloodTypes ,
                'governorates' => $governorates
            ]);
        }

        else if($request->isMethod('PUT'))
        {
            $client->bloodTypes()->sync($request->bloodTypes);
            $client->governorates()->sync($request->goverorates);

            return responceJson(1 , 'تم التعديل' , $client);
        }           
    }

    public function unreadNotificationCount(Request $request)
    {
        //api_token , is-read = 0
        $notifications = $request->user()->notifications()->where('is_read', 0)->get();
        return responceJson(1 , 'عدد الاشعارات الغير مقروءة' , count($notifications));
        
    } 

    public function registerToken(Request $request) 
    {
        $validator = validator()->make($request->all() , [
            'token' => 'required' ,
            'type'  => 'required|in:android,ios'
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        Token::where('token' , $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responceJson(1 , 'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request) 
    {
        $validator = validator()->make($request->all() , [
            'token' => 'required' ,
        ]);

        if($validator->fails())
        {
            return responceJson(0 , $validator->errors()->first() , $validator->errors());
        }

        Token::where('token' , $request->token)->delete();
        return responceJson(1 , 'تم الحذف بنجاح');
    }
}

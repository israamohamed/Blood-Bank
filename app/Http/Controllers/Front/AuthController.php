<?php

namespace App\Http\Controllers\Front;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;

class AuthController extends Controller
{
    public function login()
    {
        $title = "تسجيل الدخول "; 
        return view('front.login' , compact('title'));
    }

    public function login_submit(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'phone'    => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return back()->with('error' , ' يوجد بيانات مفقودة ');
        }
     
        //$credentials = $request->only('phone', 'password');

        if (Auth::guard('client-web')->attempt(['phone' => $request->phone, 'password' => $request->password, 'is_active' => 1])) {
            // Authentication passed...
            return redirect()->intended('front/home');
        }
        else 
        {
            return back()->with('error' , ' بيانات الدخول غير صحيحة ');
        }
    }

    public function register()
    {
        $title = "إنشاء حساب جديد";
        return view('front.register' , compact('title'));
    }

    public function register_submit(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'name'              => 'required' , 
            'phone'             => 'required|unique:clients' ,
            'dob'               => 'required' ,
            'blood_type_id'     => 'required' , 
            'last_donation_date'=> 'required' ,
            'city_id'           => 'required' , 
            'email'             => 'required|email|unique:clients',
            'password'          => 'required|confirmed'
        ]);

        if($validator->fails())
        {
            return back()->with('error' , 'يوجد بيانات مفقودة أو خطأ');
        }

        $request->merge(['password' => bcrypt($request->password)]); 
        $client = Client::create($request->all());
    
        return back()->with('success' , 'تم الاضافة بنجاح');
    }

    public function logout()
    {
        Auth::guard('client-web')->logout();
        return redirect('front/login');
    }

    public function profile(Request $request)
    {
        $title = "معلوماتي ";
        if($request->isMethod('GET'))
        {
            $client = $request->user();
            return view('front.profile')->with([
                'client' => $client , 
                'title'  => $title
            ]);
        }

        else if($request->isMethod('PUT'))
        {
            $nullFields = [];
            foreach($request->all() as $field => $value)
            {
                if( !( $field == '_method' || $field == '_token') )
                {
                    if($value == null)
                    {
                        array_push($nullFields , $field);
                    }
                  
                }        
            }
            
            $validator = validator()->make($request->all() , [
                'email'             => 'email|unique:clients,email,'.$request->user()->id,
                'password'          => 'confirmed|nullable', 
                'phone'             => 'unique:clients,phone,'.$request->user()->id,
            ]);
    
            if($validator->fails())
            {
                return back()->with( 'error' , 'يوجد خطأ');
            }

            $client = $request->user();

            /*$request = $request->except($nullFields);
            return $request;*/
            if($request->input('password')) 
            {
                $request->merge(['password' => bcrypt($request->password)]); 
            }
            $client->update($request->except($nullFields));
            return back()->with('success' , 'تم التعديل ');
        }
        
    }

    public function notification_settings(Request $request)
    {
        $title = "ضبط الاشعارات ";
        $client = $request->user();

        if($request->isMethod('GET'))
        {          
            //get blood types and governorates of that user
            $client_bloodTypes   = $client->bloodTypes()->pluck('blood_types.id')->toArray();
            $client_governorates = $client->governorates()->pluck('governorates.id')->toArray();

            return view('front.notifications_settings')->with([
                'client_bloodTypes'  =>  $client_bloodTypes ,
                'client_governorates' => $client_governorates , 
                'title'               => $title
            ]);
          
        }

        else if($request->isMethod('PUT'))
        {
            $client->bloodTypes()->sync($request->bloodTypes);        //bloodTypes
            $client->governorates()->sync($request->governorates);   //governorates

            return back()->with('success' , 'تم التعديل');
        }           
    }

    public function forget_password()
    {
        $title = "نسيت كلمة المرور " ;
        return view('front.forget_password' , compact('title'));
    }

    public function forget_password_submit(Request $request)
    {
        $validator = validator()->make($request->all() , [
            'phone'    => 'required'
        ]);

        if($validator->fails())
        {
            return back()->with('error' , ' يجب إدخال رقم الجوال ');
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
                return back()->with('error' , 'حدث خطأ أثناء الإرسال');
            }
            else 
            {
                /*return redirect('front/change_password')->with([
                    'phone'   => $request->phone , 
                    'success' => 'أفحص البريد الخاص بك لمعرفة كود التحقق '                
                ]);*/
                return view('front.change_password')->with([
                    'phone'   => $request->phone , 
                    'success' => 'أفحص البريد الخاص بك لمعرفة كود التحقق ' , 
                    'title'  => 'تغيير كلمة المرور'
                ]);
                /*return view('front.change_password')->with('success' , 'أفحص البريد الخاص بك لمعرفة كود التحقق ' ,
                [
                    'phone'   => $request->phone , 
                    'title'  => 'تغيير كلمة المرور'
                ]);*/
            }
        }
        else 
        {
            return back()->with('error' , 'الرقم غير صحيح');
        }
    }

    public function change_password()
    {
        //return $request;
        $title = "تغيير كلمة المرور ";
        return view('front.change_password')->with([
            'title' => $title 
            //'phone' => $request->phone
        ]);
    }

    public function change_password_submit(Request $request)
    {
       
        $validator = validator()->make($request->all() , [
            'pin_code'    => 'required',
            'password'    => 'required|confirmed',
            'phone'       => 'required'
        ]);

        //validation
        if($validator->fails())
        {
            return back()->with('error' , 'يوجد خطأ بالبيانات' );
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
                return redirect('front/login')->with('success' , 'تم تغيير كلمة المرور');
            }

            else
            {
                return redirect('front/forget_password')->with('error' , 'الكود التأكيدي غير صحيح');
            } 
        }

        else 
        {
            return back()->with('error' , 'الرقم غير صحيح');
        }
    }

    public function notifications()
    {
        $title = 'اشعاراتي';
        $client = request()->user();
        return view('front.notifications')->with([
            'title' => $title  ,
            'notifications' => $client->notifications 
        ]);
    }
}

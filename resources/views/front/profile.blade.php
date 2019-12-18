@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
            <!--Breadcrumb-->
            <nav class="my-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">معلوماتي</li>
                </ol>
            </nav><!--End Breadcrumb-->
        </div><!--End container-->
        <section class="profile text-center">
            <div class="container">
                @include('parties.flash-message')
                <div class="py-4 mb-4">
                    {!!Form::open([
                        'class'  => 'w-75 m-auto' ,
                        'method' => 'PUT' , 
                        'action' => 'Front\AuthController@profile' 
                    ])!!}
                        {!!Form::text('name' , $client->name , ['class' => 'form-control my-3' , 'placeholder' => 'الاسم' ])!!}
                        
                        {!!Form::email('email' , $client->email , ['class' => 'form-control my-3' , 'placeholder' => 'البريد الاليكترونى' ])!!}
                        
                        {!!Form::text('dob' ,$client->dob ,  ['class' => 'form-control my-3' ,'placeholder' => 'تاريخ الميلاد' , 'onfocus' => '(this.type="date")' ,  'onblur' => '(this.type="text")'])!!}
                        
                        @inject('bloodTypes' , 'App\Models\BloodType')
                        {!!Form::select('blood_type_id' , $bloodTypes->pluck('name' , 'id')->toArray() , $client->blood_type_id , [
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'فصيلة الدم '
                        ])!!}

                        {!!Form::text('last_donation_date' , $client->last_donation_date , ['class' => 'form-control my-3' ,'placeholder' => 'اخر تاريخ تبرع' , 'onfocus' => '(this.type="date")' ,  'onblur' => '(this.type="text")'])!!}
                        
                        @inject('governorates' , 'App\Models\Governorate')
                        {!!Form::select('governorate_id' , $governorates->pluck('name' , 'id')->toArray() , $client->city->governorate_id , [
                            'id' => 'governorates' ,
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'المحافظة'
                        ])!!}

                      
                        {!!Form::select('city_id' , $client->city->governorate->cities->pluck('name' , 'id')->toArray() , $client->city_id , [
                            'id' => 'cities' ,
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'المدينة'
                        ])!!}
                
                        {!!Form::text('phone' , $client->phone , ['class' => 'form-control my-3' , 'placeholder' => 'رقم الجوال'])!!}
                        
                        {!!Form::password('password' , ['class' => 'form-control my-3' , 'placeholder' => 'كلمة المرور'])!!}

                        {!!Form::password('password_confirmation' , ['class' => 'form-control my-3' , 'placeholder' => 'تأكيد كلمة المرور'])!!}
                   
                        {!!Form::submit('تعديل' , ['class' => 'btn btn-success py-2 w-50'])!!}
                        
                    {!!Form::close()!!}
                </div>
            </div>
        </section>
        @push('scripts')
            <script>
                    $("#governorates").change(function()
                    {
                        var governorate_id = $('#governorates').val();
                        if(governorate_id)
                        {
                            $.ajax(
                            {
                                url     : '{{url('api/v1/cities?governorate_id=')}}' + governorate_id , 
                                method  : 'get' ,
                                success :function(data)
                                {
                                    if(data.status == 1)
                                    {
                                        $("#cities").empty();
                                        $("#cities").append("<option value = ''>المدينة</option>");
                                        $.each(data.data , function(index , city)
                                        {
                                            $("#cities").append("<option value =' " + city.id + "' >" + city.name + "</option>");
                                        });
                                        
                                       
                                    }
                                }
                            });
                        }
                        else 
                        {
                            $("#cities").empty();
                            $("#cities").append("<option value = ''>المدينة</option>");
                            
                        }
                });
    
               
            </script>
        @endpush
@endsection
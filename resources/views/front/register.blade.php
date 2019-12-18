@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
            <!--Breadcrumb-->
            <nav class="my-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">انشاء حساب جديد</li>
                </ol>
            </nav><!--End Breadcrumb-->
        </div><!--End container-->
        <section class="signup text-center">
            <div class="container">
                @include('parties.flash-message')
                <div class="py-4 mb-4">
                    <form action="{{url(route('client_register'))}}" class="w-75 m-auto" method = "post">
                        @csrf
                        <input type="text" name="name" class="form-control my-3" placeholder="الاسم">
                        <input type="mail" name="email" class="form-control my-3" placeholder="البريد الاليكترونى">
                        <input onfocus="(this.type='date')" onblur="(this.type='text')"  type="text" name="dob" class="form-control my-3" placeholder="تاريخ الميلاد">
                        @inject('bloodTypes' , 'App\Models\BloodType')
                        {!!Form::select('blood_type_id' , $bloodTypes->pluck('name' , 'id')->toArray() , null , [
                            'class' => 'form-control my-3' , 
                            'placeholder' => 'فصيلة الدم '
                        ])!!}
                        
                        @inject('governorates' , 'App\Models\Governorate')
                        {!!Form::select('governorate_id' , $governorates->pluck('name' , 'id')->toArray() , null , [
                            'id' => 'governorates' ,
                            'class' => 'form-control my-3' , 
                            'placeholder' => 'المحافظة'
                        ])!!}

                      
                        {!!Form::select('city_id' , [] , null , [
                            'id' => 'cities' ,
                            'class' => 'form-control my-3' , 
                            'placeholder' => 'المدينة'
                        ])!!}
                
                        <input type="text" name="phone" class="form-control my-3" placeholder="رقم الهاتف">
                        <input  onfocus="(this.type='date')" onblur="(this.type='text')"  type="text" name="last_donation_date" class="form-control my-3" placeholder="اخر تاريخ تبرع">
                        <input type="password" name="password" class="form-control my-3" placeholder="كلمة المرور">
                        <input type="password" name="password_confirmation" class="form-control my-3" placeholder="تأكيد كلمة المرور">
                        <button type="submit" class="btn btn-success py-2 w-50">ارسال</button>
                    </form>
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
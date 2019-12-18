@section('title', $title)
@extends('front.master')
@section('content')
@inject('donation' , 'App\Models\DonationRequest')
    <div class="container">
            <!--Breadcrumb-->
            <nav class="my-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">طلب تبرع جديد</li>
                </ol>
            </nav><!--End Breadcrumb-->
        </div><!--End container-->
        <section class="new_donation text-center">
            <div class="container">
                @include('parties.flash-message')
                <div class="py-4 mb-4">
                    {!!Form::model($donation , [
                        'action' => 'Front\MainController@donation_create_submit' , 
                        'class'  => 'w-75 m-auto'
                    ])!!}

                        {!!Form::text('patient_name' , null , ['class' => 'form-control my-3' , 'placeholder' => 'الاسم'])!!}

                        {!!Form::number('patient_age' , null , ['class' => 'form-control my-3' , 'placeholder' => 'العمر'])!!}

                        @inject('bloodTypes' , 'App\Models\BloodType')
                        {!!Form::select('blood_type_id' , $bloodTypes->pluck('name' , 'id')->toArray() , null , [
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'فصيلة الدم '
                        ])!!}

                        {!!Form::number('bags_num' , null , ['class' => 'form-control my-3' , 'placeholder' => 'عدد الأكياس المطلوبة'])!!}
                        
                        {!!Form::text('hospital_name' , null , ['class' => 'form-control my-3' , 'placeholder' => 'اسم المستشفى'])!!}

                        {!!Form::text('hospital_address' , null , ['class' => 'form-control my-3' , 'placeholder' => 'عنوان المستشفى'])!!}

                        @inject('governorates' , 'App\Models\Governorate')
                        {!!Form::select('governorate_id' , $governorates->pluck('name' , 'id')->toArray() , null , [
                            'id' => 'governorates' ,
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'المحافظة'
                        ])!!}

                      
                        {!!Form::select('city_id' , [] , null , [
                            'id' => 'cities' ,
                            'class' => 'form-control my-3 py-0' , 
                            'placeholder' => 'المدينة'
                        ])!!}

                        {!!Form::text('patient_phone' , null , ['class' => 'form-control my-3' , 'placeholder' => 'رقم الهاتف '])!!}

                        {!!Form::textarea('notes' , null , ['class' => 'form-control my-3' , 'placeholder' => 'ملاحظات'])!!}

                        {!!Form::submit('إضافة' , ['class' => 'btn btn-success py-2 w-50'])!!}
                    
                    {!!form::close()!!}
                    
                </div>
                <!--<div id="somecomponent" style="width: 500px; height: 400px;"></div>-->
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

                //$('#somecomponent').locationpicker();
    
                
            
            </script>
        @endpush
@endsection
@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
            <!--Breadcrumb-->
            <nav class="my-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">اعدادات الاشعارات</li>
                </ol>
            </nav><!--End Breadcrumb-->
        </div><!--End container-->
        <section class="profile text-center">
            <div class="container">
                @include('parties.flash-message')

                <div>
                    <p>{{$settings->notification_setting_text}}</p>
                </div>

                <div class="py-4 mb-4">
                    {!!Form::open([
                        'class'  => 'w-75 m-auto' ,
                        'method' => 'PUT' , 
                        'action' => 'Front\AuthController@notification_settings' 
                    ])!!}
                        {!!Form::label('' , 'فصائل الدم ' , ['class' => 'bg-dark text-light py-2 px-4'])!!}
                        
                        @inject('bloodTypes' , 'App\Models\BloodType')
                        <div class = "row my-2">
                            @foreach($bloodTypes->all() as $bloodType)
                                <div class="form-check col-sm-3">
                                    {!!Form::checkbox('bloodTypes[]' , $bloodType->id , ( in_array($bloodType->id , $client_bloodTypes) ? true : false) , ['style' => 'font-size: 1.4em;'])!!}
                                    {!!Form::label('' , $bloodType->name , ['class' => 'form-check-label' , 'style'=> 'font-size: 1.4em;'])!!}
                                </div>
                            @endforeach
                            
                        </div>
                        <br><br>

                        {!!Form::label('' , ' المحافظات' , ['class' => 'bg-dark text-light py-2 px-4'])!!}
                        
                        @inject('governorates' , 'App\Models\Governorate')
                        <div class = "row my-2">
                            @foreach($governorates->all() as $governorate)
                                <div class="form-check col-sm-3">
                                {!!Form::checkbox('governorates[]', $governorate->id , ( in_array($governorate->id , $client_governorates) ? true : false) )!!}
                                {!!Form::label('' , $governorate->name , ['class' => 'form-check-label' , 'style'=> 'font-size: 1.4em;'])!!}
                                </div>
                            @endforeach
                        </div>
                        <br><br>

                      
                        {!!Form::submit(' حفظ ' , ['class' => 'btn btn-success py-2 w-50'])!!}
                        
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
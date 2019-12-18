@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item active" aria-current="page">تغيير كلمة المرور</li>
            </ol>
        </nav><!--End Breadcrumb-->
        <section class="signup-form my-4 py-4">
            @include('parties.flash-message')
            <div class="my-5 text-center"><img src="imgs/logo.png" alt="logo"></div>

            <div class="p-4 mb-4">
                {!!Form::open([
                    'action' => 'Front\AuthController@forget_password_submit' ,
                    'class' => 'w-75 m-auto my-5 text-center'
                ])!!}
                    
                    {!!Form::text('phone' , null , ['class' => 'form-control my-3 py-3' , 'placeholder' => 'رقم الجوال'])!!}
                    <br>
                    {!!Form::submit('إرسال'  , ['class' => 'btn btn-success py-2 w-50 ' ])!!}
                {!!Form::close()!!}
            </div>

        </section>
    </div>
    <!--Footer-->
    @endsection
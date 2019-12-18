@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item active" aria-current="page">كود تغيير كلمة المرور</li>
            </ol>
        </nav><!--End Breadcrumb-->
        <section class="my-4 py-4">
            @include('parties.flash-message')
            <div class="my-5 text-center"><img src="imgs/logo.png" alt="logo"></div>

            <div class="p-4 mb-4">
                {!!Form::open([
                    'action' => 'Front\AuthController@change_password_submit' ,
                    'class' => 'w-75 m-auto my-5 text-center'
                ])!!}
                    {!!Form::hidden('phone' , $phone)!!}
                    {!!Form::text('pin_code' , null ,              ['class' => 'form-control my-3 py-3' , 'placeholder' => 'كود التحقق'])!!}
                    {!!Form::password('password' ,              ['class' => 'form-control my-3 py-3' , 'placeholder' => 'كلمة المرور الجديدة'])!!}
                    {!!Form::password('password_confirmation' , ['class' => 'form-control my-3 py-3' , 'placeholder' => 'تأكيد كلمة المرور الجديدة'])!!}
                    <br>
                    {!!Form::submit('تغيير كلمة المرور '  , ['class' => 'btn btn-success py-2 w-50 ' ])!!}
                {!!Form::close()!!}
            </div>

        </section>
    </div>
    <!--Footer-->
    @endsection
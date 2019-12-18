@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول</li>
            </ol>
        </nav><!--End Breadcrumb-->
        <section class="signup-form my-4 py-4">
            @include('parties.flash-message')
            <div class="my-5 text-center"><img src="imgs/logo.png" alt="logo"></div>
            <form action="{{url(route('client_login'))}}" method = "post" class="w-75 mx-auto my-5">
                @csrf
                <input type="text" name="phone" class="form-control my-3 py-3" id="usName" placeholder="الجوال">
                <input type="password" name="password" class="form-control my-3 py-3" id="usPassword" placeholder="كلمة المرور">
                <div class="form-check float-right my-4">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                    <label class="form-check-label mr-3" for="defaultCheck2">
                       تذكرنى
                    </label>
                </div>
                <div class="float-left my-4"><a href="{{url('front/forget_password')}}"><i class="fas fa-exclamation-triangle px-2"></i><span>هل نسيت كلمة المرور</span></a></div>
                <div class="clr"></div>
                <div class="form-row my-4">
                    <div class="col">
                        <button type="submit" class="form-control py-3 bg-success text-white">دخول</button>
                    </div>
                    <div class="col">
                        <a href="{{url('front/register')}}" class="form-control text-center py-3 bg">انشاء حساب جديد</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <!--Footer-->
    @endsection
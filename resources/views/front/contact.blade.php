@section('title', $title)
@extends('front.master')
@section('content')

    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-4" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item active" aria-current="page">اتصل بنا</li>
            </ol>
        </nav><!--End Breadcrumb-->
    </div><!--End container-->
    <section class="contact py-5">
        <div class="container">
            @include('parties.flash-message')
            <div class="row">
                <div class="col-md-6 my-1">
                    <div class="contact-details">
                        <h5 class="py-3 text-center">اتصل بنا</h5>
                        <div class="text-center py-3"><img src="imgs/logo.png" alt="img-logo"></div>
                        <div class="contact-mail p-3">
                            <p class="py-1">الجوال <span> : {{$settings->phone}}</span></p>
                            <p class="py-1">فاكس <span> : 4123412</span></p>
                            <p class="py-1">البريد الاليكترونى <span> : {{$settings->email}}</span></p>
                        </div>
                        <div class="contact-social text-center">
                            <h6 class="py-2"> تواصل معنا</h6>
                            <ul class="list-unstyled d-flex justify-content-center py-md-3">
                                <li class="ml-2"><a target = "_Blank" class="google" href="{{$settings->google_link}}"><i class="fab fa-google-plus-square"></i></a></li>
                                <li class="mx-2"><a target = "_Blank" class="whatsapp" href="{{$settings->whats_link}}"><i class="fab fa-whatsapp-square"></i></a></li>
                                <li class="mx-2"><a target = "_Blank" class="insta" href="{{$settings->insta_link}}"><i class="fab fa-instagram"></i></a></li>
                                <li class="mx-2"><a target = "_Blank" class="youtube" href="{{$settings->youtube_link}}"><i class="fab fa-youtube-square"></i></a></li>
                                <li class="mx-2"><a target = "_Blank" class="twitter" href="{{$settings->tw_link}}"><i class="fab fa-twitter-square"></i></li>
                                <li class="mr-2"><a target = "_Blank" class=" facebook" href="{{$settings->fb_link}}"><i class="fab fa-facebook-square"></i></a></li>                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 my-1">
                    <div class="contact-form text-center">
                        <h5 class="py-3">تواصل معنا</h5>
                        <form action="{{url('front/contact')}}" method = "post">
                            @csrf
                            <input type="text" name="name" class="form-control my-3" placeholder="الاسم">
                            <input type="mail" name="email" class="form-control my-3" placeholder="البريد الاليكترونى">
                            <input type="text" name="phone" class="form-control my-3" placeholder="الجوال">
                            <input type="text" name="subject" class="form-control my-3" placeholder="عنوان الرسالة">
                            <textarea name="message" class="form-control my-4" rows="5" placeholder="نص الرسالة"></textarea>
                            <button type="submit" class="btn py-3 bg w-100 ">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
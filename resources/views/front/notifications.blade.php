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
        <section class="text-right">
            <div class="container">
                @if(count($notifications) > 0)
                    @foreach($notifications as $notification)
                        <div class = "p-2 my-5" style = "background: #bbc7d3;"> 
                            <h4>{{$notification->title}}</h4>
                            <p>{{$notification->content}}</p>
                            <a class = "btn bg px-5" target = "_Blank" href = "{{url(route('donation_details' , $notification->donation_request_id ))}}">تفاصيل حالة تبرع</a>
                        </div>
                    @endforeach
                @else 
                        <p>لا يوجد إشعارات</p>
                @endif
            </div>
        </section>
        
@endsection
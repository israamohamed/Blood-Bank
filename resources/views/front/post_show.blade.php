@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item"><a href="#">المقالات</a></li>
                <li class="breadcrumb-item active" aria-current="page">الوقاية من الأمراض</li>
            </ol>
        </nav><!--End Breadcrumb-->
    </div><!--End container-->
    <section class="artice-detailes pb-5">
        <div class="container">
            <div class="article-img m-auto">
                <img src="/BloodBank/public/storage/posts_images/{{$post->image}}" class="card-img-top" alt="article-img">
            </div>
            <div class="article-content my-4">
                <div class="article-header d-flex justify-content-between" style = "position: relative;padding:2%">
                    <h6>{{$post->title}}</h6>
                    <div class="heart-icon  {{$post->is_favourite ? 'second-heart' : 'first-heart' }} "><i id = "{{$post->id}}" onclick = "toggleFvourite(this);" 
                        class="far fa-heart {{$post->is_favourite ? 'second-heart' : 'first-heart' }} "></i></div>
                </div>
                <div class="article-details p-4">
                    <p class="my-md-4"> {{$post->body}} </p>
                </div>
            </div>
        </div>
    </section>
    <!--Articles section-->
    <section class="articles mb-5">
            <div class="title">
                <div class="container">
                    <h5><span class="py-1">مقالات ذات صلة</span> </h5>
                </div>
            </div>
            <div class="article-slide mt-3">
                <div class="container">
                    <div class="arrow text-left">
                        <button type="button" class="prev-arrow px-2 py-1"><i class="fas fa-chevron-right"></i></button>
                        <button type="button" class="next-arrow px-2 py-1"><i class="fas fa-chevron-left"></i></button>
                    </div>
                    <div class="slick2">
                        @foreach($related_posts as $related_post)
                            <div class="slick-cont">
                                <div class="card">
                                    <img src="/BloodBank/public/storage/posts_images/{{$related_post->image}}" class="card-img-top" alt="slick-img">
                                     <div class="heart-icon  {{$related_post->is_favourite ? 'second-heart' : 'first-heart' }} ">
                                        <i id = "{{$related_post->id}}" onclick = "toggleFvourite(this);" class="far fa-heart {{$related_post->is_favourite ? 'second-heart' : 'first-heart' }} "></i>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$related_post->title}}</h5>
                                        <p>{{$related_post->body}}</p>
                                        <div class="text-center"><a href="{{url(route('post_details' , $related_post->id))}}" class="btn bg px-5">التفاصيل</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                      
                    </div>
                </div>
            </div>
            <!--End container-->
        </section>
        <!--End Articles-->
        
@push('scripts')
<script>
    function toggleFvourite(heart)
    {
        var currentClass = $(heart).parent().attr('class');
        var post_id = heart.id;
        $.ajax({
            url : '{{url(route('toggle-favourite'))}}' , 
            method : 'post' ,
            data : {_token: "{{csrf_token()}}" , post_id: post_id } , 
            success: function(data)
            {
                if(currentClass.includes('first'))
                {
                    $(heart).removeClass('first-heart').addClass('second-heart');
                    $(heart).parent().removeClass('first-heart').addClass('second-heart');
                }
                else 
                {
                    $(heart).removeClass('second-heart').addClass('first-heart');
                    $(heart).parent().removeClass('second-heart').addClass('first-heart');
                }
            }

        });

    }   
</script>
@endpush
   @endsection
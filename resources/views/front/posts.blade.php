@section('title', $title)
@extends('front.master')
@section('content')
    <div class="container">
        <!--Breadcrumb-->
        <nav class="my-5" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسيه</a></li>
                <li class="breadcrumb-item"><a href="#">المقالات</a></li>
            </ol>
        </nav><!--End Breadcrumb-->
    </div><!--End container-->
    <section class="posts pb-5">
        <div class="container">
            @foreach($posts as $post)
                <div class = "my-5" style = "background: #547fab;">
                    <div class="float-left post-image bg-primary">
                        <img src="/BloodBank/public/storage/posts_images/{{$post->image}}" alt="article-img" style = "width: 100%">
                    </div>
                    <div class=" w-50">
                        <div class="mb-2 article-header d-flex justify-content-between" style = "position: relative;padding:2%">
                            <h6>{{$post->title}}</h6>
                            <div class="heart-icon  {{$post->is_favourite ? 'second-heart' : 'first-heart' }} "><i id = "{{$post->id}}" onclick = "toggleFvourite(this);" 
                                class="far fa-heart {{$post->is_favourite ? 'second-heart' : 'first-heart' }} "></i></div>
                        </div>
                        
                        <small class = "p-4 text-light"> الفئة  : {{$post->category->name}} </small>
                        
                        <div class="p-4">
                            <p class="my-md-4" style = "color: white;"> {{$post->body}} </p>
                        </div>

                        <div class = "p-4"><a href="{{url(route('post_details' , $post->id))}}" class="btn bg px-5">التفاصيل</a></div>
                    </div>
                    <div class = "clearfix"></div>
                </div>
                <hr>
            @endforeach
            <div style = "justify-content:center;display:flex;" class = "render_donations" >{!! $posts->render() !!}</div>
        </div>
    </section>
    





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
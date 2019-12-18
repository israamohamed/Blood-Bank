@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Posts</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List of posts</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          @include('parties.validation_errors')
          <a href = {{url(route('post.create'))}} class = "btn btn-primary"><i class = "fa fa-plus"></i>  New Post</a><br><br>
            @if(count($posts) > 0)
                <div style = "text-align:right">
                @foreach($posts as $post)
                    @if($post->image)
                        <div class = "p-4 rounded shadow-lg post">
                            <div class="float-left" style = "width: 20%;">
                                <img src = "/BloodBank/public/storage/posts_images/{{$post->image}}" style = "width: 100%;border-radius:20px;">
                            </div>
                            <div class = "float-right" style = "width: 20%;">
                                <h3><a href = "{{asset('admin/post')}}/{{$post->id}}" class="text-light bg-light px-3 py-1">{{$post->title}}</a></h3>
                                <small style = "font-size : 1.2em;">Created at : {{$post->created_at}} by :  {{$post->user->name}}</small>
                                <br>
                                <small style = "font-size : 1.2em;">Category   : {{$post->category->name}}</small> 
                            </div>
                            <div class="clearfix"></div>
                            <br><br>
                            <a href = "post/{{$post->id}}/edit" class = "btn btn-success float-left">Edit</a>
                            <div>
                                <button onclick = "deleteData(this)" class = "btn btn-danger float-right">Delete</button>
                                {!!Form::open([
                                    'action' => ['PostController@destroy' , $post->id ] , 
                                    'method' => 'delete' 
                                    
                                ]) !!}
                                
                                
                                {!!Form::close()!!}
                            </div>
                            <div class = "clearfix"></div>
                        </div>
                    @else
                        <div class = "p-4 post">
                            <h3><a href = "{{asset('admin/post')}}/{{$post->id}}" class="text-light bg-light px-3 py-1">{{$post->title}}</a></h3>
                            <small style = "font-size : 1.2em;">Created at : {{$post->created_at}} by :  {{$post->user->name}}</small>
                            <br>
                            <small style = "font-size : 1.2em;">Category   : {{$post->category->name}}</small> 
                            <br><br>
                            <a href = "post/{{$post->id}}/edit" class = "btn btn-success float-left">Edit</a>
                            <div>
                                <button onclick = "deleteData(this)" class = "btn btn-danger float-right">Delete</button>
                                {!!Form::open([
                                    'action' => ['PostController@destroy' , $post->id ] , 
                                    'method' => 'delete' 
                                    
                                ]) !!}
                                
                                
                                {!!Form::close()!!}
                            </div>
                            <div class = "clearfix"></div>
                        </div>
                    @endif
                    
                    <br><br>
                @endforeach
            </div>
            {{ $posts->links() }}
          
           @else
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                    <p>No Posts to show</p>
                </div>

            @endif
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

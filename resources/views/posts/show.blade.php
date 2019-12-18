@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
            <h1 style = "text-align:center;">{{$post->title}}</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          @include('parties.validation_errors')
                    <div style = "text-align:right;">
                        @if($post->image)                    
                            <div style = "width: 50%;margin:auto;">
                                <img src = "/BloodBank/public/storage/posts_images/{{$post->image}}" style = "width: 100%;border-radius:20px;">
                            </div>
                            <br>
                        @endif
                            <p>{{$post->body}}</p>
                            <small style = "font-size : 1.2em;">Created at : {{$post->created_at}} by :  {{$post->user->name}}</small>
                            <br>
                            <small style = "font-size : 1.2em;">Category   : {{$post->category->name}}</small> 
                        </div>
                    
                    <br><br><br>
                      
                    <a href = "{{url(route('post.index'))}}" class = "btn btn-primary">Back</a>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

@extends('layouts.app')
@inject('model' , 'App\Models\Post')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Post</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          @include('parties.validation_errors')
          {!!Form::model($model , [
            'action'   => ['PostController@update' , $post->id] ,
             'enctype' => 'multipart/form-data',
             'method'  => 'put'
          ])!!}
            <div class = "form-group">
                    <select  class="browser-default custom-select" name = "category_id">
                        
                        <option value = "" disabled selected>Category</option>
                        @foreach($categories as $category)
                            @if($post->category_id == $category->id )
                                <option value = {{$category->id}} selected>{{$category->name}}</option>
                            @else 
                                <option value = {{$category->id}}>{{$category->name}}</option>
                            @endif
                        @endforeach
                    </select>
            </div>
            
            <div class = "form-group">
                {!!Form::text('title' , $post->title ,  ['placeholder' => 'Title' , 'class' => 'form-control border-primary'])!!}
            </div>
            
            <div class = "form-group">
                {!!Form::textarea('body' , $post->body , ['placeholder' => 'Body ..' , 'class' => 'form-control border-primary'])!!}
            </div>

            <div class = "form-group">
                {!!Form::file('image')!!}
            </div>

            <p>If you don't upload an image , the old image will be uploaded with the post
              [in the case of the post was posted with an image ] so if you want to remove the image from the post check this box</p>
              <div class = "form-group">
                {!! Form::label('remove', 'Remove old image') !!}
                {!! Form::checkbox('remove', 'remove') !!}
              </div>

            <div class = "form-group">
                {!!Form::submit('Edit' , ['class' => 'btn btn-primary'])!!}
            </div>
        {!!Form::close()!!}
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

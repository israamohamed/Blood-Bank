@extends('layouts.app')
@inject('model' , 'App\Models\Post')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create New Post</h1>
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
            'action' => 'PostController@store' , 'enctype' => 'multipart/form-data'
          ])!!}
            <div class = "form-group">
                    <select  class="browser-default custom-select" name = "category_id">
                        <option value = "" disabled selected>Category</option>
                        @foreach($categories as $categorie)
                          <option value = {{$categorie->id}} >{{$categorie->name}}</option>
                        @endforeach
                    </select>
            </div>
            
            <div class = "form-group">
                {!!Form::text('title' , null ,  ['placeholder' => 'Title' , 'class' => 'form-control border-primary'])!!}
            </div>
            
            <div class = "form-group">
                {!!Form::textarea('body' , null , ['placeholder' => 'Body ..' , 'class' => 'form-control border-primary'])!!}
            </div>

            <div class = "form-group">
                {!!Form::file('image')!!}
            </div>

            <div class = "form-group">
                {!!Form::submit('Create' , ['class' => 'btn btn-primary'])!!}
            </div>
        {!!Form::close()!!}
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

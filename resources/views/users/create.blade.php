@extends('layouts.app')
@inject('model' , 'App\User')
@inject('roles' , 'App\Models\Role')

<?php $roles = $roles->pluck('display_name' , 'id')->toArray(); ?> 


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create user</h1>
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
              'action' => 'UserController@store'
          ])!!}

            <div class = "form-group">
                    {!!Form::label('name', 'Name') !!}
                    {!!Form::text('name', null , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
                {!!Form::label('email', 'E-mail') !!}
                {!!Form::email('email', null , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
                {!!Form::label('password', 'Password') !!}
                {!!Form::password('password' , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
                {!!Form::label('password_confirmation', 'Password Confirmation') !!}
                {!!Form::password('password_confirmation' , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
                {!!Form::label('roles_list', 'List of permissions') !!}
                {!!Form::select('roles_list[]' , $roles , null , [
                  'multiple'=>'multiple' ,
                  'class' => 'form-control' ,
                  'id' => 'roles-list'
                ])!!}
                
                
              </div>
            
            <br><br>

            <div class = "form-group">
                {!!Form::submit('Add' , ['class' => 'btn btn-primary'])!!}
            </div>

          {!!Form::close()!!}
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

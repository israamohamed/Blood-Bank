@extends('layouts.app')
@inject('model' , 'App\Models\Role')
@inject('permissions' , 'App\Models\Permission')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit role</h1>
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
              'action' => ['RoleController@update' , $record->id] , 
              'method' => 'put'
          ])!!}


            <div class = "form-group">
                {!!Form::label('name', 'Name') !!}
                {!!Form::text('name', $record->name , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
            {!!Form::label('display_name', 'Display name') !!}
            {!!Form::text('display_name', $record->display_name , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
            {!!Form::label('description', 'Description') !!}
            {!!Form::textarea('description', $record->description , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
            {!!Form::label('form-check', 'List of permissions') !!}
            <input type="checkbox" id="select-all-permissions">Check All
            <br><br>
            <div class = "row">
              @foreach($permissions->all() as $permission)
                <div class="form-check col-sm-3">
                  <input type="checkbox" class="form-check-input perm" value = {{$permission->id}} name = "permission_list[]"
                  @if( $record->hasPermission($permission->name) )
                    checked
                  @endif
                  
                  >
                  <label class="form-check-label">{{$permission->display_name}}</label>
                </div>
              @endforeach
            </div>
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

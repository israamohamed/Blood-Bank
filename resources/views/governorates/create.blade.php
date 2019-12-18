@extends('layouts.app')
@inject('model' , 'App\Models\Governorate')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create governorate</h1>
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
              'action' => 'GovernorateController@store'
          ])!!}


            <div class = "form-group">
                    {!!Form::label('name', 'Name') !!}
                    {!!Form::text('name', null , ['class' => 'form-control'])!!}
            </div>

            <div class = "form-group">
                {!!Form::submit('Submit' , ['class' , 'btn btn-primary'])!!}
            </div>

          {!!Form::close()!!}
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

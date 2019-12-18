@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
            <h1 class = "text-center">{{$record->subject}}</h1>
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
                   
          <h2>Name  - {{$record->name}}</h3>
          <h3>Email - {{$record->email}}</h3>
          <h3>Phone - {{$record->phone}}</h3>
          <br><br>
          <p class = "text-center bg-primary px-5 py-2 lead">Content <br><br>{{$record->message}}</p>
                   
      <!-- /.card-footer-->
      </div>
    <!-- /.card -->
    </div>
  </section>

@endsection

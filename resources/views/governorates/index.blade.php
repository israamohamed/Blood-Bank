@extends('layouts.app')

@inject('client'  , 'App\Models\Client')
@inject('donation' , 'App\Models\DonationRequest')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Governorates</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

        

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List of governorates</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          <a href = {{url(route('governorate.create'))}} class = "btn btn-primary"><i class = "fa fa-plus"></i>  New Governorate</a><br><br>
          @if(count($records) > 0)
            <div class = "table-responsive">
                <table class = "table table-borded">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class = "text-center">Edit</th>
                            <th class = "text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td class = "text-center">
                                    <a href = "{{url(route('governorate.edit' , $record->id))}}" class = "btn btn-success btn-sm"><i class = "fa fa-edit"></i></a>
                                </td>
                                <td class = "text-center">
                                    <button onclick = "deleteData(this)" class = "btn btn-danger btn-xs"><i class = "fa fa-trash"></i></button>
                                    {!!Form::open([
                                        'action' => ['GovernorateController@destroy' , $record->id ] , 
                                        'method' => 'delete'
                                    ]) !!}
                                    
                                    
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           @else
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>

            @endif
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

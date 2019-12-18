@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

        

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List of users</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          <a href = {{url(route('user.create'))}} class = "btn btn-primary"><i class = "fa fa-plus"></i>  New user</a><br><br>
          @if(count($records) > 0)
            <div class = "table-responsive">
                <table class = "table table-borded">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>List of Roles</th>
                            <th class = "text-center">Edit</th>
                            <th class = "text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{$record->email}}</td>
                                <td>
                                    @foreach($record->roles as $role)
                                        <span style = "background:#506080;color:white;" class = "p-2">{{$role->display_name}}</span>
                                    @endforeach
                                </td>
                                <td class = "text-center">
                                    <a href = "{{url(route('user.edit' , $record->id))}}" class = "btn btn-success btn-sm"><i class = "fa fa-edit"></i></a>
                                </td>
                                <td class = "text-center">
                                        <button onclick = "deleteData(this)" class = "btn btn-danger btn-xs"><i class = "fa fa-trash"></i></button>
                                    {!!Form::open([
                                        'action' => ['UserController@destroy' , $record->id ] , 
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
                    <p>No Data to Show </p>
                </div>

            @endif
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

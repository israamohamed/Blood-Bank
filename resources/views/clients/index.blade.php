@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Clients</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List of clients</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          @include('parties.validation_errors')
         
          <!-- *******************************  -->

            {!!Form::open([
                'action' => 'ClientController@search',
                'method' => 'get'
            ])!!}

                <div class = "row">
                    {!!Form::text('search_by_city'       , old('search_by_city') , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By City'])!!} 
                    {!!Form::text('search_by_governorate', null , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By Governorate'])!!}
                    {!!Form::text('search_by_phone'      , null , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By Phone'])!!}
                    {!!Form::text('search_by_name'       , null , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By Name'])!!}
                    <select  class="browser-default custom-select col-sm-2 mx-1" name = "search_by_blood_type">
                        <option value = "" disabled selected>Search By Blood Type</option>
                        @foreach($blood_types as $blood_type)
                            <option value = {{$blood_type->id}} >{{$blood_type->name}}</option>
                        @endforeach
                    </select>
                    {!!Form::submit('Search' , ['class' => 'btn btn-dark col-sm-1 mx-2'])!!}
                </div>
                

            {!!Form::close()!!}

         <!-- *******************************  -->
            <br><br>
          @if(count($records) > 0)
                <p style = "font-size:1.2em;color:#d70f1b">Number of results : {{count($records)}}</p>
          
            <div class = "table-responsive">
                <table class = "table table-borded">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class = "text-center">Name</th>
                            <th class = "text-center">Phone</th>
                            <th class = "text-center">Blood Type</th>
                            <th class = "text-center">Last Donation Data</th>
                            <th class = "text-center">City</th>
                            <th class = "text-center">Current State</th>
                            <th class = "text-center">Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td class = "text-center">{{$record->name}}</td>
                                <td class = "text-center">{{$record->phone}}</td>
                                <td class = "text-center">{{$record->bloodType->name}}</td>
                                <td class = "text-center">{{$record->last_donation_date}}</td>
                                <td class = "text-center">{{$record->city->name}}</td>
                                <td class = "text-center">
                                    {!!Form::open([
                                            'action' => ['ClientController@activation' , $record->id ]
                                        ]) !!}
                                        @if($record->is_active)
                                            <button class = "btn btn-warning" type = "submit">Active</a>
                                        @else 
                                            <button class = "btn btn-danger" type = "submit">Deactive</a>
                                        @endif
                                    {!!Form::close()!!}
                                </td>

                                <td class = "text-center">
                                    <button onclick = "deleteData(this)" class = "btn btn-danger btn-xs"><i class = "fa fa-trash"></i></button>
                                    {!!Form::open([
                                        'action' => ['ClientController@destroy' , $record->id ] , 
                                        'method' => 'delete'
                                    ]) !!}
                                    
                                    
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $records->links() }}
            </div>
           @else
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                    <p>No Data to show</p>
                </div>

            @endif
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

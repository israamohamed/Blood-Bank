@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Donation requests</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

        

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List of donation requests</h3>

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
                  'action' => 'DonationRequestController@search',
                  'method' => 'get'
              ])!!}
  
                  <div class = "row">
                      {!!Form::text('search_by_city'       , null , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By City'])!!} 
                      {!!Form::text('search_by_governorate', null , ['class' => 'col-sm-2 mx-1' , 'placeholder' => 'Search By Governorate'])!!}
                      {!!Form::text('search_by_hospital_name'      , null , ['class' => 'col-sm-3 mx-1' , 'placeholder' => 'Search By Hospital Name'])!!}
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
                            <th class = "text-center">Patient Name</th>
                            <th class = "text-center">Patient Phone</th>
                            <th class = "text-center">Blood Type</th>
                            <th class = "text-center">City</th>
                            <th class = "text-center">Hospital Name</th>
                            <th class = "text-center">Show Details</th>
                            <th class = "text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td class = "text-center">{{$record->patient_name}}</td>
                                <td class = "text-center">{{$record->patient_phone}}</td>
                                <td class = "text-center">{{$record->bloodType->name}}</td>
                                <td class = "text-center">{{$record->city->name}}</td>
                                <td class = "text-center">{{$record->hospital_name}}</td>
                                <td class = "text-center"><a class = "donation-data btn btn-primary" href="{{url(route('donation.show' , $record->id))}}">Details</a></td>
                                <td class = "text-center del-button">
                                        <button onclick = "deleteData(this)" class = "del-button btn btn-danger btn-xs"><i class = "fa fa-trash"></i></button>
                                        {!!Form::open([
                                            'action' => ['DonationRequestController@destroy' , $record->id ] , 
                                            'method' => 'delete'
                                        ]) !!}
                                        
                                        
                                        {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style = "justify-content:center;display:flex;" class = "render_donations" >{!! $records->render() !!}</div>
            </div>
           @else
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                    <h3>No data to show </h3>
                </div>

            @endif
      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
    


    
  </section>

@endsection

@extends('layouts.app')


@section('content')
<section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Contacts</h1>
            </div>
           
          </div>
        </div><!-- /.container-fluid -->
    </section>

  <!-- Main content -->
  <section class="content">

    @if(count($records) > 0)
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                    <div class="card-header">   
                        <h3>Contacts</h3>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>Subject</th>
                                    <th>Time</th>
                                    <th class = "text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <div class="card-body p-0">
                                        @foreach($records as $record)
                                            <tr>        
                                                <td class="mailbox-name">{{$record->name}}</td>
                                                <td class="mailbox-subject">
                                                    <b><a href = "{{url(route('contact.show' , $record->id))}}">{{$record->subject}}</a></b>
                                                </td>
                                                <td class="mailbox-date">{{$record->created_at}}</td>
                                                <td class = "text-center">
                                                        <button onclick = "deleteData(this)" class = "btn btn-danger btn-xs"><i class = "fa fa-trash"></i></button>
                                                        {!!Form::open([
                                                            'action' => ['ContactController@destroy' , $record->id ] , 
                                                            'method' => 'delete'
                                                        ]) !!}
                                                        
                                                        
                                                        {!!Form::close()!!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </div>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        {{ $records->links() }}
    @else 
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
            <h3>No data to show</h3>
        </div>
    @endif

  </section>

@endsection

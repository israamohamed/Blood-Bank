@extends('layouts.app')


@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Donation request</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

        

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Details of the donation request</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
          
        <div>
            <h1 class = "text-center">{{$record->patient_name}}</h1>  

            <br>

            <ul  class="list-group text-right donation-request-details">
                <li class="list-group-item">الاسم : {{$record->patient_name}}</li>
                <li class="list-group-item">العمر : {{$record->patient_age}}</li>
                <li class="list-group-item"> {{$record->bloodType->name}} : فصيلة الدم</li>
                <li class="list-group-item">عدد الاكياس المطلوبة : {{$record->bags_num}}</li>
                <li class="list-group-item">المستشفى : {{$record->hospital_name}}</li>
                <li class="list-group-item">عنوان المستشفى : {{$record->hospital_address}}</li>
                <li class="list-group-item">رقم الجوال : {{$record->patient_phone}}</li>
                <li class="list-group-item">التفاصيل  : {{$record->notes}}</li>
            </ul>
        </div>

        <br><br><br>
        <a href = "{{url(route('donation.index'))}}" class = "btn btn-primary">Back</a>

      </div>
     
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection

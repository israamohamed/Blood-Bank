@extends('layouts.app')
@inject('model' , 'App\Models\Setting');

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
            <h1 style = "text-align:center;">Settings</h1>
        </div>
       
      </div>
    </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
          <h3 class="card-title">Update information about the app</h3>
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
            'action' => ['SettingController@store'] , 
            'method' => 'post'  ,
            'class'  => 'w-50 m-auto bg-secondary p-5 borded'
        ])!!}

            
            <div class = "form-group">
              {!!Form::label('play_store_url' , 'Play Store Url')!!}
              {!!Form::text('play_store_url'  , ($record) ? $record->play_store_url : null  , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('app_store_url' , 'App Store Url')!!}
                {!!Form::text('app_store_url' , ($record) ? $record->app_store_url : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('notification_setting_text' , 'Notification Setting Text')!!}
                {!!Form::textarea('notification_setting_text' , ($record) ? $record->notification_setting_text : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('about_app' , 'About App')!!}
                {!!Form::textarea('about_app' , ($record) ? $record->about_app	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('phone' , 'Phone')!!}
                {!!Form::text('phone' , ($record) ? $record->phone	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('email' , 'Email')!!}
                {!!Form::text('email' , ($record) ? $record->email	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('fb_link' , 'Facebook link')!!}
                {!!Form::text('fb_link' , ($record) ? $record->fb_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('tw_link' , 'Twitter link')!!}
                {!!Form::text('tw_link' , ($record) ? $record->tw_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('youtube_link' , 'Youtube link')!!}
                {!!Form::text('youtube_link' , ($record) ? $record->youtube_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('insta_link' , 'Instagram link')!!}
                {!!Form::text('insta_link' , ($record) ? $record->insta_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('whats_link' , 'Whatsapp link')!!}
                {!!Form::text('whats_link' , ($record) ? $record->whats_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::label('google_link' , 'Google link')!!}
                {!!Form::text('google_link' , ($record) ? $record->google_link	 : null , ['class' => 'form-control'])!!}
            </div><br>

            <div class = "form-group">
                {!!Form::submit('Update' , ['class' => 'btn btn-danger'])!!}
            </div><br>

            


          {!!Form::close()!!}
                    
      </div>      
                    
      <!-- /.card-footer-->
    </div>

    <!-- /.card -->

  </section>

@endsection

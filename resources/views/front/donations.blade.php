@section('title', $title)
@extends('front.master')
@section('content')
<!--Donation-->
<section class="donation">
    <h2 class="text-center"><span class="py-1">طلبات التبرع</span> </h2>
    <hr />
    <div class = "text-center"><a class = "btn btn-primary px-4 py-3 my-2" style = "font-size:1.2em;" href = "{{url(route('donation_create'))}}">إضافة حالة تبرع</a></div>
    <div class="donation-request py-5">
        <div class="container">
            <div class="selection w-75 d-flex mx-auto my-4">
                @inject('bloodtypes', 'App\Models\BloodType' )
                {!! Form::select('blood_types' , $bloodtypes->pluck('name' , 'id')->toArray() , null , [
                    'class' => 'custom-select' , 
                    'placeholder' => 'اختر فصيلة الدم'
                ] )!!}

                @inject('cities', 'App\Models\City' )
                {!! Form::select('cities' , $cities->pluck('name' , 'id')->toArray() , null , [
                    'class' => 'custom-select mx-md-3 mx-sm-1' , 
                    'placeholder' => 'اختر المدينة'
                ] )!!}
              
                <div class = "search_in_donations"><i class="fas fa-search"></i></div>
            </div>
            <!--End selection-->
            <div class = "donations_all">
                @foreach($donations as $donation)
                    <div class="req-item my-3">
                        <div class="row donation_req">
                            <div class="col-md-9 col-sm-12 clearfix">
                                <div class="blood-type m-1 float-right">
                                    <h3>{{$donation->bloodType->name}}</h3>
                                </div>
                                <div class="mx-3 float-right pt-md-2">
                                    <p>
                                        اسم الحالة : {{$donation->patient_name}}
                                    </p>
                                    <p>
                                        مستشفى : {{$donation->hospital_name}}
                                    </p>
                                    <p>
                                        المدينة : {{$donation->city->name}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 text-center p-sm-3 pt-md-5">
                                <a href="{{url(route('donation_details' , $donation->id ))}}" class="btn btn-light px-5 py-3">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div style = "justify-content:center;display:flex;" class = "render_donations" >{!! $donations->render() !!}</div>
            </div>
            
            
        </div>
        <!--End container-->
    </div>
    <!--End Donation-request-->
</section>
<!--End Donation-->
@push('scripts')
    <script>

        function append_data(array)
        {
            var url = "{{ url(route('donation_details', ':id')) }}";
            $.each(array , function(index , donation)
                                {                                            
                                            url = url.replace(':id', donation.id);
                                            /*$(".donations_all").append(
                                               "<div class='req-item my-3' style = 'display:none;'>" + 
                                                    "<div class='row donation_req'>" + 
                                                        "<div class='col-md-9 col-sm-12 clearfix'>" + 
                                                            "<div class='blood-type m-1 float-right'>" + 
                                                                "<h3>" + donation.blood_type.name + "</h3>" + 
                                                            "</div>" +
                                                            "<div class='mx-3 float-right pt-md-2'>" +
                                                                "<p>" +
                                                                    "اسم الحالة : " + donation.patient_name  + 
                                                                "</p>" +
                                                                "<p>" +
                                                                    "مستشفى : " + donation.hospital_name +
                                                                "</p>" +
                                                                "<p>" + 
                                                                    "المدينة : " + donation.city.name+
                                                                "</p>" +
                                                            "</div>" + 
                                                        "</div>" + 
                                                        "<div class='col-md-3 col-sm-12 text-center p-sm-3 pt-md-5'>" + 
                                                            "<a href='{{url(route('donation_details' , $donation->id   ))}}' class='btn btn-light px-5 py-3'>التفاصيل</a>" +
                                                        "</div>" + 
                                                    "</div>" + 
                                                "</div>"
                                                ).slideDown("fast");*/
                                                $("<div class='req-item my-3' style = 'display:none;'>" + 
                                                    "<div class='row donation_req'>" + 
                                                        "<div class='col-md-9 col-sm-12 clearfix'>" + 
                                                            "<div class='blood-type m-1 float-right'>" + 
                                                                "<h3>" + donation.blood_type.name + "</h3>" + 
                                                            "</div>" +
                                                            "<div class='mx-3 float-right pt-md-2'>" +
                                                                "<p>" +
                                                                    "اسم الحالة : " + donation.patient_name  + 
                                                                "</p>" +
                                                                "<p>" +
                                                                    "مستشفى : " + donation.hospital_name +
                                                                "</p>" +
                                                                "<p>" + 
                                                                    "المدينة : " + donation.city.name+
                                                                "</p>" +
                                                            "</div>" + 
                                                        "</div>" + 
                                                        "<div class='col-md-3 col-sm-12 text-center p-sm-3 pt-md-5'>" + 
                                                            "<a target = '_Blank' href=' " + url + "' class='btn btn-light px-5 py-3'>التفاصيل</a>" +
                                                        "</div>" + 
                                                    "</div>" + 
                                                "</div>").appendTo($(".donations_all")).slideDown("slow");
                                        });   
        }

        function load_data(button,data_url)
        {
            //alert(data_url);
            var blood_type = $("select[name = blood_types]").val();
            var city = $("select[name = cities]").val();
            $.ajax({
                type : 'get' ,
                url  : data_url ,
                data : {
                    blood_type : blood_type ,
                    city : city
                } ,
                success: function(data)
                {
                    //$(".donations_all").children().hide();
                    console.log("load : " + data);
                    append_data(data.data.data);
                    if(data.data.next_page_url)
                    {    
                        $(".donations_all").append("<div class='text-center'><button class = 'btn-primary' onclick = 'load_data(this,\""+data.data.next_page_url+"\")'>المزيد </button></div>");
                    }
               
                    
                }
            });
            button.remove();
        }

        $(".search_in_donations").click(function()
        {
            var blood_type = $("select[name = blood_types]").val();
            var city = $("select[name = cities]").val();
            $.ajax({
                type : 'get' ,
                url  : '{{url(route("donation_search"))}}' ,
                data : {
                    blood_type : blood_type ,
                    city : city
                } ,
                success: function(data)
                {
                    $(".donations_all").children().hide();
                    console.log(data);
                    append_data(data.data.data);
                    if(data.data.next_page_url)
                    {    
                        $(".donations_all").append("<div class='text-center'><button class = 'btn-primary' onclick = 'load_data(this,\""+data.data.next_page_url+"\")'>المزيد</button></div>");
                    }
               
                    
                }
            });

        });
    </script>
@endpush
@endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--bootstrap file css-->
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/slick-theme.css')}}">
    <!--google-font-->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&display=swap" rel="stylesheet">
    <!--main file css-->
    <link rel="stylesheet" href="{{asset('front/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <title> @yield('title') </title>
</head>

<body>
    <!--Loading Page-->
    <div class="loading-page">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!--header section-->
    <section class="header">
        <!--top-bar-->
        <div class="top-bar py-2">
            <div class="container">
                <!--row of top-bar-->
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="index.html" class="ar px-1">عربى</a>
                        <a href="" class="en px-1">EN</a>
                    </div>
                    <div>
                        <ul class="list-unstyled">
                        <li class="d-inline-block mx-2"><a target = "_Blank"class="facebook" href="{{$settings->fb_link}}"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="insta" href="{{$settings->insta_link}}"><i
                                        class="fab fa-instagram"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="twitter" href="{{$settings->tw_link}}"><i
                                        class="fab fa-twitter"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="whatsapp" href="{{$settings->whats_link}}"><i
                                        class="fab fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                    @if(Auth::guard('client-web')->check()) 
                    <div> 
                            <a class="text-white" href="{{url('front/notifications')}}"> <i class="fas fa-bell text-white"></i> اشعاراتي</a>
                    </div>
                    
                    <div class="connect">
                        <div class="dropdown">
                            <a class="dropdown-toggle" style = "color: black;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span> مرحبا بك </span> &nbsp; &nbsp; {{auth('client-web')->user()->name}}
                            </a>
                            <div class="dropdown-menu text-right" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{url('front/home')}}">  <i class="fas fa-home ml-2"></i>الرئيسيه</a>
                              <a class="dropdown-item" href="{{url('front/profile')}}"> <i class="fas fa-user-alt ml-2"></i>معلوماتى</a>
                              <a class="dropdown-item" href="{{url('front/notification_settings')}}"> <i class="fas fa-bell ml-2"></i>اعدادات الاشعارات</a>
                              <a class="dropdown-item" href="{{url('front/favourite_posts')}}"> <i class="far fa-heart ml-2"></i>المفضلة</a>
                              <a class="dropdown-item" href="{{url('front/contact')}}"> <i class="far fa-comments ml-2"></i>ابلاغ</a>
                              <a class="dropdown-item" href="{{url('front/contact')}}"> <i class="fas fa-phone ml-2"></i>تواصل معنا</a>
                              <a class="dropdown-item" href="{{url(route('client-logout'))}}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt ml-2"></i>خروج
                              </a>

                            <form id="logout-form" action="{{ route('client-logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                              
                           
                            </div>
                          </div>
                    </div>

                    @else 
                        <div>
                            <a href="{{url('front/register')}}">انشاء حساب جديد</a>
                            <a class="px-3" href="{{url('front/login')}}">دخول</a>
                        </div>
                    @endif
                </div>
                <!--End row-->
            </div>
            <!--End container-->
        </div>
        <!--End top-bar-->
        <!--navbar-->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="imgs/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if(Auth::guard('client-web')->check())
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item {{$title == 'بنك الدم' ? 'active' : ''}}">
                            <a class="nav-link" href="{{url('front/home')}}">الرئيسيه <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item {{$title == 'من نحن' ? 'active' : ''}}">
                            <a class="nav-link" href="{{url('front/about')}}">عن بنك الدم</a>
                        </li>
                        <li class="nav-item {{$title == 'المقالات' ? 'active' : ''}}">
                            <a class="nav-link" href="{{url('front/posts')}}">المقالات</a>
                        </li>
                        <li class="nav-item {{$title == 'طلبات التبرع' ? 'active' : ''}}">
                            <a class="nav-link" href="{{url('front/donations')}}">طلبات التبرع</a>
                        </li>
                        <li class="nav-item {{$title == 'من نحن' ? 'active' : ''}}">
                            <a class="nav-link" href="{{url('front/about')}}">من نحن</a>
                        </li>
                        <li class="nav-item {{$title == 'تواصل معنا' ? 'active' : ''}} cont">
                            <a class="nav-link" href="{{url('front/contact')}}">اتصل بنا</a>
                        </li>

                        @if(!Auth::guard('client-web')->check()) 
                            <li class="mr-lg-auto py-md-2"><a class="signin" href="{{url('front/register')}}">انشاء حساب جديد</a></li>
                            <li class="pr-3"><a class="btn bg px-3" href="{{url('front/login')}}">دخول</a></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
            <!--End container-->
        </nav>
        <!--End Nav-->


        @yield('content')

         <!--Footer-->
    <footer>
        <div class="main-footer py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="imgs/logo.png" alt="">
                        <h5 class="my-3">بنك الدم</h5>
                        <p class="pl-4"> هذا النص هو مثال لنص ممكن أن يستبدل فى نفس المساحه, لقد تم توليد
                            هذا النص من مولد النص العرب حيث يمكنك ان تولد هذا النص أو
                            العديد من النصوص الأخرى وإضافة الى زيادة عدد الحروف التى يولدها التطبيق يطلع على صورة حقيقة
                            لتطبيق
                            الموقع
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="px-md-5 mt-md-3">الرئيسية</h6>
                        <ul class="list-unstyled">
                            <li class="py-2"><a href="{{url('front/about')}}">عن بنك الدم</a></li>
                            <li class="py-2"><a href="article-details.html">المقالات</a></li>
                            <li class="py-2"><a href="{{url('front/donations')}}">عن التبرع</a></li>
                            <li class="py-2"><a href="{{url('front/about')}}">من نحن</a></li>
                            <li class="py-2"><a href="{{url('front/contact')}}">اتصل بنا</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 available">
                        <h6 class="mb-5 mt-md-3 px-md-5">متوفر على</h6>
                        <div class="my-3"><img src="imgs/google1.png" alt=""></div>
                        <div class="my-3"><img src="imgs/ios1.png" alt=""></div>
                    </div>
                </div>
            </div>
            <!--End container-->
        </div>
        <!--End main-footer-->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <ul class="list-unstyled pt-sm-3 py-md-3">
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="facebook" href="{{$settings->fb_link}}"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="insta" href="{{$settings->insta_link}}"><i
                                        class="fab fa-instagram"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="twitter" href="{{$settings->tw_link}}"><i
                                        class="fab fa-twitter"></i></a></li>
                            <li class="d-inline-block mx-2"><a target = "_Blank"class="whatsapp" href="{{$settings->whats_link}}"><i
                                        class="fab fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-7">
                        <p class="mx-5 py-md-3">جميع الحقوق محفوظه لـ <span>بنك الدم</span> &copy; 2019</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--End Footer-->
    <!--scrollUp-->
    <div class="scrollUp">
		<i class="fas fa-chevron-up"></i>
	</div>
    <!--jquery/bootstrap/main file js-->
    <script src="{{asset('front/js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="{{asset('front/js/locationpicker.jquery.js')}}"></script>
    <script src="{{asset('front/js/slick.min.js')}}"></script>
    <script src="{{asset('front/js/popper.min.js')}}"></script>
    <script src="{{asset('front/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/js/main.js')}}"></script>
    @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE | @yield('title')</title>

    {{--<!-- Bootstrap 3.3.7 -->--}}
    <link rel="stylesheet" href="{{ asset('dashboard_files/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_files/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_files/css/skin-blue.min.css') }}">

    @if (app()->getLocale() == 'ar')
        {{-- https://fontawesome.com/v4/icons/ --}}
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/font-awesome-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/AdminLTE-rtl.min.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/bootstrap-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/rtl.css') }}">

        <style>
            body,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'Cairo', sans-serif !important;
            }
            .ck-editor{
                direction: rtl !important;
            }
        </style>
    @else
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard_files/css/AdminLTE.min.css') }}">
        <style>
            .ck-editor{
                direction: ltr !important;
            }
        </style>
    @endif

    <style>
        /* .mr-2 {
            margin-right: 5px;
        } */

        /* .loader {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #367FA9;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 1s linear infinite;
            /* Safari *
            animation: spin 1s linear infinite;
        } */

        /* Safari */
        /* @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        } */

        /* @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        } */
        @media print{
            .printButton{
                display: none;
            }
        }
    </style>

    {{--<!-- jQuery 3 -->--}}
    <script src="{{ asset('dashboard_files/js/jquery.min.js') }}"></script>

    {{-- CK Editor --}}
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.css" />

    {{-- For Data Table --}}
    {{-- <link href="https://cdn.datatables.net/v/bs/jszip-3.10.1/dt-2.3.4/b-3.2.5/b-html5-3.2.5/b-print-3.2.5/datatables.min.css" rel="stylesheet" integrity="sha384-k3ht0xpLiVuZDY7gkYLt1FMYDn3d1bt89+/ANFyjQsiCeJ2pQDRIC/vh062Rfixs" crossorigin="anonymous"> --}}

    {{--noty--}}
    {{-- <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/noty/noty.css') }}">
    <script src="{{ asset('dashboard_files/plugins/noty/noty.min.js') }}"></script> --}}

    {{--morris--}}
    {{-- <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/morris/morris.css') }}"> --}}

    {{--<!-- iCheck -->--}}
    {{-- <link rel="stylesheet" href="{{ asset('dashboard_files/plugins/icheck/all.css') }}"> --}}

    {{--html in ie--}}
    {{-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> --}}

    <!-- For Import Tailwind -->
    @if (file_exists(public_path('hot')) && app()->environment('local'))
        {{-- Vite dev server --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @elseif (file_exists(public_path('build/manifest.json')))
        {{-- Vite production build --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    {{-- Tailwind CDN fallback (always loaded just in case) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E3A8A',
                        secondary: '#F97316',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')

</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        <header class="main-header">

            {{--<!-- Logo -->--}}
            <a href="{{ route('dashboard.index') }}" class="logo">
                {{--<!-- mini logo for sidebar mini 50x50 pixels -->--}}
                <span class="logo-mini"><b>A</b>LT</span>
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>

            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    @if (auth()->user()->image)
                                                        <img class="w-12 h-12 rounded-full"
                                                            src="{{ asset('dashboard/imgs/users/' . auth()->user()->image->file) }}" class="img-circle" alt="user image">
                                                    @else
                                                        <img class="w-12 h-12 rounded-full"
                                                            src="{{ asset('dashboard_files/img/default.jpg') }}" class="img-circle" alt="user image">
                                                    @endif
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small>
                                                        <i class="fa fa-clock-o"></i> 5 mins
                                                    </small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">See All Messages</a>
                                </li>
                            </ul>
                        </li>

                        {{--<!-- Notifications: style can be found in dropdown.less -->--}}
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    {{--<!-- inner menu: contains the actual data -->--}}
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Change Language in website --}}
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @php
                                    $currentLocale = app()->getLocale();
                                    $flag = $currentLocale === 'ar' ? 'ar_flag.png' : 'us_flag.png';
                                    $langName = $currentLocale === 'ar' ? 'العربية' : 'English';
                                @endphp
                                <img src="{{URL::asset('dashboard_files/img/flags/'. $flag)}}" class="w-9 h-auto" alt="img">
                                {{-- <strong class="mr-2 ml-2 my-auto">{{ $langName }}</strong> --}}
                            </a>
                            <ul class="dropdown-menu !size-auto">
                                <li>
                                    <ul class="menu">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li>
                                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                    <div class="flex justify-start items-center">
                                                        <span class="mx-6">
                                                            @php
                                                                $flag = $localeCode === 'ar' ? 'ar_flag.png' : 'us_flag.png';
                                                            @endphp
                                                            <img src="{{URL::asset('dashboard_files/img/flags/' . $flag)}}" alt="img" class="w-12 h-auto">
                                                        </span>
                                                        <strong>{{ $properties['native'] }}</strong>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        {{--<!-- User Account: style can be found in dropdown.less -->--}}
                        <li class="dropdown user user-menu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if (auth()->user()->image)
                                    <img src="{{ asset('dashboard/imgs/users/' . auth()->user()->image->file) }}" class="user-image" alt="user image">
                                @else
                                    <img src="{{ asset('dashboard_files/img/default.jpg') }}" class="user-image" alt="user image">
                                @endif
                                {{-- <span class="hidden-xs">{{ Auth::user()->name }}</span> --}}
                            </a>
                            <ul class="dropdown-menu">

                                {{--<!-- User image -->--}}
                                <li class="user-header">
                                    <div class="flex items-center my-4">
                                        <div class="w-2/5 mx-4">
                                            @if (auth()->user()->image)
                                                <img src="{{ asset('dashboard/imgs/users/' . auth()->user()->image->file) }}" class="img-circle w-full h-auto" alt="user image">
                                            @else
                                                <img src="{{ asset('dashboard_files/img/default.jpg') }}" class="img-circle w-full h-auto" alt="user image">
                                            @endif
                                        </div>
                                        <div class="w-3/5">
                                            <h4 class="text-white !my-3">{{ Auth::user()->name }}</h4>
                                            {{-- <span class="text-orange">Member since 2days</span> --}}
                                            {{-- <span class="text-orange">{{ __('site.user_role') }}<br/>{{ Auth::user()->roles()->first()->display_name }}</span> --}}
                                            <span class="text-orange">"{{ Auth::user()->roles()->first()->display_name }}"</span>
                                        </div>
                                    </div>
                                    <a href="{{ url('/profile') }}" class="bg-orange-800 rounded-lg !text-[#ffffff] hover:!text-[#666666] ">
                                        {{ __('site.user_profile') }}
                                    </a>
                                </li>

                                {{--<!-- Menu Footer-->--}}
                                <li class="user-footer">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat !rounded-lg"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('site.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>

                        </li>

                    </ul>
                </div>
            </nav>

        </header>

        @include('layouts.dashboard._aside')

        @include('sweetalert::alert')

        @yield('content')

        {{-- @include('partials._session') --}}

        <footer class="main-footer text-center">
            <strong>Copyright &copy; 2025 <a href="https://adminlte.io">Almsaeed Studio</a>. </strong> All rights
            reserved.
        </footer>

    </div><!-- end of wrapper -->

    {{--<!-- Bootstrap 3.3.7 -->--}}
    <script src="{{ asset('dashboard_files/js/bootstrap.min.js') }}"></script>

    {{--icheck--}}
    {{-- <script src="{{ asset('dashboard_files/plugins/icheck/icheck.min.js') }}"></script> --}}

    {{--<!-- FastClick -->--}}
    {{-- <script src="{{ asset('dashboard_files/js/fastclick.js') }}"></script> --}}

    {{--<!-- AdminLTE App -->--}}
    <script src="{{ asset('dashboard_files/js/adminlte.min.js') }}"></script>

    {{--ckeditor standard--}}
    {{-- <script src="{{ asset('dashboard_files/plugins/ckeditor/ckeditor.js') }}"></script> --}}

    {{--jquery number--}}
    {{-- https://github.com/customd/jquery-number --}}
    {{-- <script src="{{ asset('dashboard_files/js/jquery.number.min.js') }}"></script> --}}

    {{--print this--}}
    {{-- <script src="{{ asset('dashboard_files/js/printThis.js') }}"></script> --}}

    {{--morris --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('dashboard_files/plugins/morris/morris.min.js') }}"></script> --}}

    {{-- CK Editor --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
    <script src="{{ asset('dashboard_files/js/custom/ck_editor.js') }}"></script>

    {{--custom js--}}
    <script src="{{ asset('dashboard_files/js/custom/image_preview.js') }}"></script>
    {{-- For Delete All --}}
    <script src="{{ asset('dashboard_files/js/custom/delete_all.js') }}"></script>
    {{-- For Orders --}}
    <script src="{{ asset('dashboard_files/js/custom/order.js') }}"></script>

    {{-- For Data Table --}}
    {{-- <script src="https://cdn.datatables.net/v/bs/jszip-3.10.1/dt-2.3.4/b-3.2.5/b-html5-3.2.5/b-print-3.2.5/datatables.min.js" integrity="sha384-IEtxkDm+KXERTtDz8EHbs07Sv0r31HyNom4p+ttbsrVtleKUaliHVljXBEmSswhZ" crossorigin="anonymous"></script> --}}

    <script>
        // $(document).ready(function () {

        //     $('.sidebar-menu').tree();

        //     //icheck
        //     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        //         checkboxClass: 'icheckbox_minimal-blue',
        //         radioClass: 'iradio_minimal-blue'
        //     });

        //     //delete
        //     $('.delete').click(function (e) {

        //         var that = $(this)

        //         e.preventDefault();

        //         var n = new Noty({
        //             text: "@lang('site.confirm_delete')",
        //             type: "warning",
        //             killer: true,
        //             buttons: [
        //                 Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
        //                     that.closest('form').submit();
        //                 }),

        //                 Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
        //                     n.close();
        //                 })
        //             ]
        //         });

        //         n.show();

        //     });//end of delete

            // image preview
            // $(".image").change(function () {
            //
            //     if (this.files && this.files[0]) {
            //         var reader = new FileReader();
            //
            //         reader.onload = function (e) {
            //             $('.image-preview').attr('src', e.target.result);
            //         }
            //
            //         reader.readAsDataURL(this.files[0]);
            //     }
            //
            // });

            // CKEDITOR.config.language = "{{ app()->getLocale() }}";

        // });//end of ready

    </script>

    @stack('scripts')

</body>

</html>

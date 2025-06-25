<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>SIS Tax Collection</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{asset('libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="{{asset('libs/flatpickr/flatpickr.css')}}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('css/pages/cards-advance.css')}}" />
    <script src="{{asset('js/helpers.js')}}"></script>

    {{-- <script src="{{asset('js/template-customizer.js')}}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('js/config.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('css/demo.css')}}" />
    <link rel="stylesheet" href="{{asset('libs/select2/select2.css')}}" />

    <link rel="stylesheet" href="{{asset('css/update-style.css?v=').time()}}" />
    {{-- @vite('resources/css/app.css', 'resources/js/app.js') --}}
    @livewireStyles
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        @include('layouts.side-menu')
         <div class="layout-page">

            <livewire:layout.header />


            <div class="content-wrapper">

                {{ $slot }}

            </div>
        </div>
      </div>
    </div>
        @livewireScripts

        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        <script src="{{asset('libs/jquery/jquery.js')}}"></script>
        <script src="{{asset('libs/popper/popper.js')}}"></script>
        {{-- <script src="{{asset('libs/datatables-bs5/datatables-bootstrap5.js')}}"></script> --}}

        <script src="{{asset('js/bootstrap.js')}}"></script>
        {{-- <script src="{{asset('libs/node-waves/node-waves.js')}}"></script> --}}
        <script src="{{asset('libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        {{-- <script src="{{asset('libs/hammer/hammer.js')}}"></script> --}}
        <script src="{{asset('libs/i18n/i18n.js')}}"></script>
        {{-- <script src="{{asset('libs/typeahead-js/typeahead.js')}}"></script> --}}
        <script src="{{asset('js/menu.js')}}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{asset('libs/moment/moment.js')}}"></script>
        <script src="{{asset('libs/apex-charts/apexcharts.js')}}"></script>
        <script src="{{asset('libs/flatpickr/flatpickr.js')}}"></script>
        <!-- Form Validation -->
        {{-- <script src="{{asset('libs/@form-validation/umd/bundle/popular.min.js')}}"></script> --}}
        {{-- <script src="{{asset('libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
        <script src="{{asset('libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
        <!-- Page JS --> --}}
        <script src="{{asset('js/app-academy-dashboard.js')}}"></script>
        <script src="{{asset('libs/select2/select2.js')}}"></script>

        <script src="{{asset('js/forms-selects.js')}}"></script>
        <script src="{{asset('js/forms-tagify.js')}}"></script>
        <script src="{{asset('js/forms-typeahead.js')}}"></script>

        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        <!-- Main JS -->
        <script src="{{asset('js/main.js')}}"></script>
        {{-- <script src="{{asset('js/jquery.div.print.js')}}"></script>
        <script src="{{asset('js/print.js?v=').time()}}"></script> --}}

  </body>
</html>

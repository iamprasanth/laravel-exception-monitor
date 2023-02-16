<!doctype html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <meta name="description" content="{{__('spt.html_meta_description')}}">
      <meta name="author" content="{{__('spt.html_meta_author')}}">
      <link rel="icon" href="images/favicon.ico">
      <title>{{__('spt.html_title')}}</title>
      <link href="{{ asset('/css/spt-css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/css/spt-css/dataTables.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/css/spt-css/font-awesome.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/css/spt-css/fonts.googleapis.css') }}" rel="stylesheet">
      <link href="{{ asset('/css/spt-css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/css/spt-css/custom.css') }}" rel="stylesheet">
  </head>
  <body>
      @yield('content')
      <footer class="footer container-fluid pl-30 pr-30 text-center">
          <div class="row">
              <div class="col-sm-12">
                  <p>{{__('spt.copyright_text')}}</p>
              </div>
          </div>
      </footer>
      <script src="{{ asset('/js/spt-js/jquery-3.5.0.min.js') }}"></script>
      <script src="{{ asset('/js/spt-js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('/js/spt-js/chart.js') }}"></script>
      <script src="{{ asset('/js/spt-js/dataTables.min.js') }}"></script>
      <script src="{{ asset('/js/spt-js/bootstrap-datepicker.min.js') }}"></script>
     @php $logUrl = config('sptexception.log_dashboard_url'); @endphp
      <script>
      window.baseUrl = '<?php echo url('/') ?>' ;
      window.sptLogUrl = <?php echo json_encode($logUrl) ?> ;
      </script>
      @yield('script')
  </body>
</html>

<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<![if !IE]><html lang="es"><![endif]>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | Corporación J. Soria</title>
  <!-- Vendor CSS -->
  {!!Html::style('vendors/bower_components/animate.css/animate.min.css')!!}
  {!!Html::style('vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css')!!}
  {!!Html::style('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')!!}
  {!!Html::style('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')!!}
  {!!Html::style('vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css')!!}
  {!!Html::style('vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css')!!}
  {!!Html::style('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')!!}
  {!!Html::style('vendors/farbtastic/farbtastic.css')!!}
  {!!Html::style('vendors/bower_components/chosen/chosen.min.css')!!}
  {!!Html::style('vendors/summernote/dist/summernote.css')!!}
  <!-- CSS -->
  {!!Html::style('css/app.min.1.css')!!}
  {!!Html::style('css/app.min.2.css')!!}
  {!!Html::style('css/own.styles.css')!!}
  <!-- Estilos adicionales -->
  @yield('styles')
</head>
<body>
  <header id="header" class="clearfix" data-current-skin="orange">
    <ul class="header-inner">
      <li id="menu-trigger" data-trigger="#sidebar">
        <div class="line-wrap">
          <div class="line top"></div>
          <div class="line center"></div>
          <div class="line bottom"></div>
        </div>
      </li>
      <li class="logo hidden-xs">
        <a href="{!!URL::to('/escritorio')!!}">Corporación Educativa J. Soria</a>
      </li>
      <li class="pull-right">
        <ul class="top-menu">
          <li id="top-search">
            <a href=""><i class="tm-icon zmdi zmdi-search"></i></a>
          </li>
          <li id="toggle-width">
            <div class="toggle-switch">
              <input id="tw-switch" type="checkbox" hidden="hidden">
              <label for="tw-switch" class="ts-helper"></label>
            </div>
          </li>
          <li>
            <!-- Cerrar sesión -->
            <a href="{!!URL::to('/logout')!!}"><i class="tm-icon zmdi zmdi-power"></i></a>
          </li>
        </ul>
      </li>
    </ul>
    <div id="top-search-wrap">
      <div class="tsw-inner">
        <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
        <form action="{{ url('/usuario/buscar') }}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="text" name="texto">
          <button type="submit" class="hidden">Buscar</button>
        </form>
      </div>
    </div>
  </header>
  <section id="main" data-layout="layout-1">
    <aside id="sidebar" class="sidebar c-overflow bgm-blue-soria">
      <div class="profile-menu">
        <a href="">
          <div class="profile-info text-uppercase">
            {!!Auth::user()->nombres!!} {!!Auth::user()->apellidos!!}
            <i class="zmdi zmdi-caret-down"></i>
          </div>
        </a>
        <ul class="main-menu bgm-blue-soria">
          <li>
            <!-- Ver el Perfil -->
            <a href="{{ url('/perfil') }}"><i class="zmdi zmdi-account"></i> Ver Perfil</a>
          </li>
          <li>
            <!-- Cerrar sesión -->
            <a href="{!!URL::to('/logout')!!}"><i class="zmdi zmdi-power"></i> Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <ul class="main-menu">
        @if(Auth::user()->tipo == "Administrador")
          @include('layouts.menus.admin')
        @endif
        @if(Auth::user()->tipo == "Cajera")
          @include('layouts.menus.cajera')
        @endif
        @if(Auth::user()->tipo == "Secretaria")
          @include('layouts.menus.secretaria')
        @endif
        @if(Auth::user()->tipo == "Tesorera")
          @include('layouts.menus.tesorera')
        @endif
      </ul>
    </aside>
    <section id="content">
      <div class="container">
        <div class="row">
          <div class="col-sm-10">
            @include('messages.alert')
            @include('messages.success')
          </div>
        </div>
        <!-- Contenido -->
        @yield('content')
      </div>
    </section>
  </section>
  <!-- Page Loader -->
  <div class="page-loader hidden-print">
    <div class="preloader pl-xl">
      <svg class="pl-circular" viewBox="25 25 50 50">
        <circle class="plc-path" cx="50" cy="50" r="20"/>
      </svg>

      <p>Cargando...</p>
    </div>
  </div>
  <!-- Modals -->
  @yield('modals')
  <!-- AJAX Overlay -->
  <div id="ajax-loader">
    <img src="{{ asset('img/ajax-loader.gif') }}" alt="">
  </div>
  <!-- Javascript Libraries -->
  {!!Html::script('vendors/bower_components/jquery/dist/jquery.min.js')!!}
  {!!Html::script('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')!!}
  {!!Html::script('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')!!}
  {!!Html::script('vendors/bower_components/Waves/dist/waves.min.js')!!}
  {!!Html::script('vendors/bootstrap-growl/bootstrap-growl.min.js')!!}
  {!!Html::script('vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js')!!}
  {!!Html::script('vendors/bower_components/moment/min/moment.min.js')!!}
  {!!Html::script('vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js')!!}
  {!!Html::script('vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js')!!}
  {!!Html::script('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')!!}
  {!!Html::script('vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js')!!}
  {!!Html::script('vendors/summernote/dist/summernote-updated.min.js')!!}
  <script src="{{ asset('vendors/bower_components/moment/locale/es.js') }}"></script>
  <!-- Placeholder for IE9 -->
  <!--[if IE 9 ]>
      {!!Html::script('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js')!!}
  <![endif]-->
  {!!Html::script('vendors/bower_components/chosen/chosen.jquery.min.js')!!}
  {!!Html::script('vendors/fileinput/fileinput.min.js')!!}
  {!!Html::script('vendors/input-mask/input-mask.min.js')!!}
  {!!Html::script('vendors/farbtastic/farbtastic.min.js')!!}
  {!!Html::script('js/functions.js')!!}
  {!!Html::script('js/global.js')!!}
  <script>
    $(document).ready(function() {
      @foreach($modulos as $modulo)
        $('#{{ $modulo->tag_id }}').removeClass('hidden');
      @endforeach
      $('.sub-menu').each(function() {
        var $item = $(this)
        var l = $item.find('ul > li > a:not(.hidden)').length
        if (l == 0) $item.remove()
      })
    });
  </script>
  <!-- Scripts adicionales -->
  @yield('scripts')
</body>
</html>
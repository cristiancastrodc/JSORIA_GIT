<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<![if !IE]><html lang="es"><![endif]>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saldo Inicial | Corporación J. Soria</title>
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
          <li id="toggle-width">
            <div class="toggle-switch">
              <input id="tw-switch" type="checkbox" hidden="hidden">
              <label for="tw-switch" class="ts-helper"></label>
            </div>
          </li>
          <li>
            <!-- Cerrar sesión -->
            <a href="{!!URL::to('/logout')!!}"><i class="tm-icon zmdi zmdi-close"></i></a>
          </li>
        </ul>
      </li>
    </ul>
  </header>
  <section id="main" data-layout="layout-1">
    <aside id="sidebar" class="sidebar c-overflow bgm-blue-soria">
      <div class="profile-menu">
        <a href="">
          <div class="profile-info">
            {!!Auth::user()->nombres!!} {!!Auth::user()->apellidos!!}
            <i class="zmdi zmdi-caret-down"></i>
          </div>
        </a>
        <ul class="main-menu">
          <li>
            <!-- Ver el Perfil -->
            <a href="{{ url('/perfil') }}"><i class="zmdi zmdi-account"></i> Ver Perfil</a>
          </li>
          <li>
            <!-- Cerrar sesión -->
            <a href="{!!URL::to('/logout')!!}"><i class="zmdi zmdi-close"></i> Cerrar Sesión</a>
          </li>
        </ul>
      </div>
    </aside>
    <section id="content">
      <div class="container">
        <!-- Contenido -->
        <div class="row">
        	<div class="col-sm-10">
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Para poder empezar a realizar sus procesos, registre el saldo inicial con el que cuenta.
            </div>
        	</div>
        </div>
        <div class="row">
          <div class="col-md-10">
            <div class="card hoverable">
              <div class="card-header main-color ch-alt">
                <h2>Registrar Saldo Inicial</h2>
              </div>
              <div class="card-body card-padding">
                <form action="{{ url('tesorera/saldo_inicial/crear') }}" class="form-horizontal" method="POST">
                  <input type="hidden" value="{{ csrf_token() }}" name="_token">
                  <div class="form-group">
                    <label for="saldo_inicial" class="col-sm-3 control-label">Saldo inicial</label>
                    <div class="col-sm-9">
                      <div class="fg-line">
                        <input type="text" class="form-control" id="saldo_inicial" name="saldo_inicial">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-9">
                      <button class="btn accent-color btn-block waves-effect" type="submit">Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
  <!-- Page Loader -->
  <div class="page-loader">
    <div class="preloader pl-xl">
      <svg class="pl-circular" viewBox="25 25 50 50">
        <circle class="plc-path" cx="50" cy="50" r="20"/>
      </svg>

      <p>Cargando...</p>
    </div>
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
  <!-- Scripts adicionales -->
  @yield('scripts')
</body>
</html>
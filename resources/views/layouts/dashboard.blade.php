<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
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
            <a href=""><i class="zmdi zmdi-account"></i> Ver Perfil</a>
          </li>
          <li>
            <!-- Cerrar sesión -->
            <a href="{!!URL::to('/logout')!!}"><i class="zmdi zmdi-close"></i> Cerrar Sesión</a>
          </li>
        </ul>
      </div>
      <ul class="main-menu">
        @if(Auth::user()->tipo == "Administrador")
          <!-- Administrador -->
          <li><a href="{!!URL::to('/admin/actividades')!!}">
            <i class="zmdi zmdi-assignment"></i> Actividades</a>
          </li>
          <li><a href="{!!URL::to('/admin/matriculas')!!}">
            <i class="zmdi zmdi-collection-text"></i> Matriculas</a>
          </li>
          <li><a href="{!!URL::to('/admin/pensiones')!!}">
            <i class="zmdi zmdi-calendar"></i> Pensiones</a>
          </li>
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-money-box"></i> Cobros</a>
            <ul>
                <li><a href="{!!URL::to('/admin/cobros/ordinarios')!!}">Ordinarios</a></li>
                <li><a href="{!!URL::to('/admin/cobros/extraordinarios')!!}">Extraordinarios</a></li>
                <li><a href="{!!URL::to('/admin/cobros/otros')!!}">Otros</a></li>
            </ul>
          </li>
          <li><a href="{!!URL::to('/admin/usuarios')!!}">
            <i class="zmdi zmdi-accounts"></i> Usuarios</a>
          </li>
          <li><a href="{!!URL::to('/admin/autorizacion')!!}">
            <i class="zmdi zmdi-trending-down"></i> Autorizar Descuentos</a>
          </li>
          <li><a href="{!!URL::to('/admin/ingresos')!!}">
            <i class="zmdi zmdi-money"></i> Retiro</a>
          </li>
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-chart"></i> Reportes</a>
            <ul>
                <li><a href="{!!URL::to('/admin/reportes/ListaIngresos')!!}">Lista de Ingresos</a></li>
                <li><a href="{!!URL::to('/admin/reportes/IngresosCategoria')!!}">Ingresos agrupados por Categorias</a></li>
                <li><a href="{!!URL::to('/admin/reportes/IngresosTotales')!!}">Ingresos Totales</a></li>
                <li><a href="{!!URL::to('/admin/reportes/ListaEgresos')!!}">Lista de Egresos</a></li>
                <li><a href="{!!URL::to('/admin/reportes/EgresosRubro')!!}">Egresos agrupados por Rubros</a></li>                
                <li><a href="{!!URL::to('/admin/reportes/EgresosTotales')!!}">Egresos Totales</a></li>
                <li><a href="{!!URL::to('/admin/reportes/AlumnosDeudores')!!}">Alumnos Deudores</a></li>
                <li><a href="{!!URL::to('/admin/reportes/CuentaAlumno')!!}">Cuenta de Alumno</a></li>                
            </ul>
          </li>          
        @endif
        @if(Auth::user()->tipo == "Cajera")
          <!-- Cajera -->
          <li><a href="{!!URL::to('/escritorio')!!}">
            <i class="zmdi zmdi-money-box"></i> Cobrar</a>
          </li>
          <li><a href="{!!URL::to('/cajera/cobros')!!}">
            <i class="zmdi zmdi-money"></i> Otros Cobros</a>
          </li>
          <li><a href="{!!URL::to('/cajera/retiros')!!}">
            <i class="zmdi zmdi-assignment-return"></i> Retiro</a>
          </li>
          <li><a href="{!!URL::to('/cajera/reporte/procesar')!!}" target="_blank">
            <i class="zmdi zmdi-chart"></i> Reporte</a>
          </li>
        @endif
        @if(Auth::user()->tipo == "Secretaria")
          <!-- Secretaria -->
          <li class="sub-menu">
            <a href=""><i class="zmdi zmdi-pin-account"></i> Alumnos</a>
            <ul>
              <li><a href="{!!URL::to('/secretaria/alumnos/create')!!}">Nuevo</a></li>
              <li><a href="{!!URL::to('/secretaria/alumno/matricular')!!}">Crear Cuenta</a></li>
              <li><a href="{!!URL::to('/secretaria/alumno/deudas/agregar')!!}">Añadir Deuda</a></li>
              <li><a href="{!!URL::to('/secretaria/alumno/deudas/listar')!!}">Modificar Deudas</a></li>
              <li><a href="{!!URL::to('/secretaria/alumno/deudas/cancelar')!!}">Cancelar Deuda de Actividad</a></li>
              <li><a href="{!!URL::to('/secretaria/alumno/deudas/amortizacion')!!}">Autorizar Amortización</a></li>
            </ul>
          </li>
          <li><a href="{!!URL::to('/secretaria/ciclo/cerrar')!!}">
            <i class="zmdi zmdi-close-circle-o"></i> Cerrar Ciclo</a>
          </li>
          <li><a href="{!!URL::to('/secretaria/reportes')!!}">
            <i class="zmdi zmdi-chart"></i> Reporte</a>
          </li>
        @endif
        @if(Auth::user()->tipo == "Tesorera")
          <!-- Tesorera -->
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-money-off"></i> Egresos</a>
            <ul>
              <li><a href="{!!URL::to('/tesorera/egresos/create')!!}">Registrar</a></li>
              <li><a href="{!!URL::to('/tesorera/egresos')!!}">Modificar</a></li>
            </ul>
          </li>
          <li><a href="{!!URL::to('/tesorera/rubros')!!}">
            <i class="zmdi zmdi-tag"></i> Rubros</a>
          </li>
          <li><a href="{!!URL::to('/tesorera/ingresos')!!}">
            <i class="zmdi zmdi-money"></i> Retirar Ingresos</a>
          </li>
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-chart"></i> Reportes</a>
            <ul>              
                <li><a href="{!!URL::to('/tesorera/reportes/ListaIngresos')!!}">Lista de Ingresos</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/IngresosCategoria')!!}">Ingresos agrupados por Categorias</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/IngresosTotales')!!}">Ingresos Totales</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/ListaEgresos')!!}">Lista de Egresos</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/EgresosRubro')!!}">Egresos agrupados por Rubros</a></li>                
                <li><a href="{!!URL::to('/tesorera/reportes/EgresosTotales')!!}">Egresos Totales</a></li>                         
            </ul>
          </li>          

        @endif
      </ul>
    </aside>
    <section id="content">
      <div class="container">
        @include('messages.alert')
        <!-- Contenido -->
        @if (Auth::user()->tipo == "Cajera")
          @if(Request::is('escritorio'))
            @include('cajera.dashboard.index')
          @endif
        @endif
        @yield('content')
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

  @yield('modals')
  @if (Auth::user()->tipo == "Cajera")
    @if(Request::is('escritorio'))
      @include('cajera.dashboard.modal')
    @endif
  @endif

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

  @if (Auth::user()->tipo == "Cajera")
    @if(Request::is('escritorio'))
      @include('cajera.dashboard.scripts')
    @endif
  @endif
  @yield('scripts');
</body>
</html>
<!-- Administrador -->
<li><a href="{!!URL::to('/admin/actividades')!!}" class="hidden" id="link_actividades">
  <i class="zmdi zmdi-assignment"></i> Actividades</a>
</li>
<li><a href="{{ url('/admin/matricula/crear') }}" class="hidden" id="link_crear_matricula">
  <i class="zmdi zmdi-assignment"></i> Crear Matrícula</a>
</li>
<!-- li><a href="{!!URL::to('/admin/matriculas')!!}">
  <i class="zmdi zmdi-collection-text"></i> Matriculas</a>
</li>
<li><a href="{!!URL::to('/admin/pensiones')!!}">
  <i class="zmdi zmdi-calendar"></i> Pensiones</a>
</li-->
<li class="sub-menu">
  <a href="#"><i class="zmdi zmdi-money-box"></i> Cobros</a>
  <ul>
      <li><a href="{!!URL::to('/admin/cobros/ordinarios')!!}" class="hidden" id="link_cobros_ordinarios">Ordinarios</a></li>
      <li><a href="{!!URL::to('/admin/cobros/extraordinarios')!!}" class="hidden" id="link_cobros_extraordinarios">Extraordinarios</a></li>
      <li><a href="{!!URL::to('/admin/cobros/otros')!!}" class="hidden" id="link_otros_cobros">Otros</a></li>
  </ul>
</li>
<li><a href="{{ url('/admin/comprobante/crear') }}" class="hidden" id="link_crear_comprobante">
  <i class="zmdi zmdi-assignment"></i> Definir Comprobantes</a>
</li>
<li><a href="{!!URL::to('/admin/usuarios')!!}" class="hidden" id="link_usuarios">
  <i class="zmdi zmdi-accounts"></i> Usuarios</a>
</li>
<li><a href="{!!URL::to('/admin/autorizacion')!!}" class="hidden" id="link_autorizacion">
  <i class="zmdi zmdi-trending-down"></i> Autorizar Descuentos</a>
</li>
<li><a href="{!!URL::to('/admin/ingresos')!!}" class="hidden" id="link_ingresos">
  <i class="zmdi zmdi-money"></i> Retiro</a>
</li>
<li><a href="{{ url('admin/configuracion') }}" class="hidden" id="link_configuracion">
  <i class="zmdi zmdi-money"></i> Definir Descuentos</a>
</li>
<li><a href="{{ url('admin/usuario/modulos') }}" id="link_usuario_modulos">
  <i class="zmdi zmdi-money"></i> Módulos de Usuario</a>
</li>
<li class="sub-menu">
  <a href="#"><i class="zmdi zmdi-chart"></i> Reportes</a>
  <ul>
      <li><a href="{!!URL::to('/admin/reporte/balance_ingresos_egresos')!!}">Balance de Ingresos/Egresos</a></li>
      <li><a href="{!!URL::to('/admin/reportes/ListaIngresos')!!}">Lista de Ingresos</a></li>
      <li><a href="{!!URL::to('/admin/reportes/IngresosCategoria')!!}">Ingresos agrupados por Categorias</a></li>
      <li><a href="{!!URL::to('/admin/reportes/IngresosTotales')!!}">Ingresos Totales</a></li>

      <li><a href="{!!URL::to('/admin/reportes/ListaEgresos')!!}">Lista de Egresos</a></li>
      <li><a href="{!!URL::to('/admin/reportes/EgresosRubro')!!}">Egresos agrupados por Rubros</a></li>
      <li><a href="{!!URL::to('/admin/reportes/EgresosTotales')!!}">Egresos Totales</a></li>

      <li><a href="{!!URL::to('/admin/reportes/AlumnosDeudores')!!}">Alumnos Deudores</a></li>
      <li><a href="{!!URL::to('/admin/reportes/CuentaAlumno')!!}">Cuenta de Alumno</a></li>
      <li><a href="{{ url('/admin/reportes/ingresos_cajera') }}">Ingresos por Cajera</a></li>
      <li><a href="{{ url('/admin/reportes/cuenta_alumno') }}">Cuenta de Alumno</a></li>
      <li><a href="{{ url('/admin/reportes/deudas_alumno') }}">Deudas de Alumno</a></li>
  </ul>
</li>
<!-- li><a href="{!!URL::to('/admin/configuracion')!!}">
  <i class="zmdi zmdi-settings"></i> Configuración</a>
</li-->

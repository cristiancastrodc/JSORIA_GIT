<!-- Secretaria -->
<li class="sub-menu">
  <a href=""><i class="zmdi zmdi-pin-account"></i> Alumnos</a>
  <ul>
    <li><a href="{!!URL::to('/secretaria/alumnos/create')!!}">Nuevo</a></li>
    <li><a href="{{ url('/secretaria/alumno/matricular') }}">Crear Matrícula</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/agregar')!!}">Añadir Deuda</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/listar')!!}">Modificar Deudas</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/cancelar')!!}">Cancelar Deuda de Actividad</a></li>
    <!--li><a href="{!!URL::to('/secretaria/alumno/deudas/amortizacion')!!}">Autorizar Amortización</a></li-->
  </ul>
</li>
<li><a href="{{ url('/secretaria/periodo/programar') }}">
  <i class="zmdi zmdi-close-circle-o"></i> Programar Períodos</a>
</li>
<li><a href="{!!URL::to('/secretaria/ciclo/cerrar')!!}">
  <i class="zmdi zmdi-close-circle-o"></i> Cerrar Ciclo</a>
</li>
<li class="sub-menu">
  <a href=""><i class="zmdi zmdi-pin-account"></i> Reportes</a>
  <ul>
    <li><a href="{!!URL::to('/secretaria/reportes')!!}">Cuenta de Alumno</a></li>
    <li><a href="{{ url('/secretaria/generar/reporte/deudas_por_grado') }}">Deudas por Grado</a></li>
  </ul>
</li>

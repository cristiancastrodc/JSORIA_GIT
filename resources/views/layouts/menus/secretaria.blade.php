<!-- Secretaria -->
<li class="sub-menu">
  <a href=""><i class="zmdi zmdi-pin-account"></i> Alumnos</a>
  <ul>
    <li><a href="{!!URL::to('/secretaria/alumnos/create')!!}" class="hidden" id="link_crear_alumnos">Nuevo</a></li>
    <li><a href="{{ url('/secretaria/alumno/matricular') }}" class="hidden" id="link_matricular_alumnos">Crear Matrícula</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/agregar')!!}" class="hidden" id="link_deudas_agregar">Añadir Deuda</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/listar')!!}" class="hidden" id="link_modificar_deudas">Modificar Deudas</a></li>
    <li><a href="{!!URL::to('/secretaria/alumno/deudas/cancelar')!!}" class="hidden" id="link_cancelar_actividad">Cancelar Deuda de Actividad</a></li>
    <li><a href="{{ url('/secretaria/alumno/deudas/anteriores/agregar') }}" class="hidden" id="link_deudas_antiguas">Añadir Deudas Anteriores</a></li>
  </ul>
</li>
<li><a href="{{ url('/secretaria/periodo/programar') }}" class="hidden" id="link_programar_periodos">
  <i class="zmdi zmdi-view-toc"></i> Programar Períodos</a>
</li>
<li><a href="{!!URL::to('/secretaria/ciclo/cerrar')!!}" class="hidden" id="link_cerrar_ciclo">
  <i class="zmdi zmdi-graduation-cap"></i> Cerrar Ciclo</a>
</li>
<li class="sub-menu">
  <a href=""><i class="zmdi zmdi-chart"></i> Reportes</a>
  <ul>
    <li><a href="{!!URL::to('/secretaria/reportes/cuenta_alumno')!!}">Cuenta de Alumno</a></li>
    <li><a href="{{ url('/secretaria/reportes/deudas_alumno') }}">Deudas de Alumno</a></li>
    <li><a href="{{ url('/secretaria/reportes/deudas_por_grado') }}">Deudas por Grado</a></li>
  </ul>
</li>

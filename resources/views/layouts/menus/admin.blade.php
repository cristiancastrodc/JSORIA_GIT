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
                <li> <a href="{!!URL::to('/admin/reporte/balance_ingresos_egresos')!!}">Balance de Ingresos/Egresos</a></li>
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
          <li><a href="{!!URL::to('/admin/configuracion')!!}">
            <i class="zmdi zmdi-settings"></i> Configuración</a>
          </li>

          <!-- Tesorera -->
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-money-off"></i> Egresos</a>
            <ul>
              <li><a href="{!!URL::to('/tesorera/egresos/create')!!}">Registrar</a></li>
              <li><a href="{!!URL::to('/tesorera/egresos')!!}">Modificar</a></li>
            </ul>
          </li>
          <li><a href="{!!URL::to('/tesorera/rubro/fixed_listar')!!}">
            <i class="zmdi zmdi-tag"></i> Rubros</a>
          </li>
          <li><a href="{!!URL::to('/tesorera/ingresos')!!}">
            <i class="zmdi zmdi-money"></i> Retirar Ingresos</a>
          </li>
          <li class="sub-menu">
            <a href="#"><i class="zmdi zmdi-chart"></i> Reportes</a>
            <ul>
                <li>
                  <a href="{!!URL::to('/tesorera/reporte/balance_ingresos_egresos')!!}" target="_blank">Balance de Ingresos/Egresos</a>
                </li>
                <li><a href="{!!URL::to('/tesorera/reportes/ListaIngresos')!!}">Lista de Ingresos</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/IngresosCategoria')!!}">Ingresos agrupados por Categorias</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/IngresosTotales')!!}">Ingresos Totales</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/ListaEgresos')!!}">Lista de Egresos</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/EgresosRubro')!!}">Egresos agrupados por Rubros</a></li>
                <li><a href="{!!URL::to('/tesorera/reportes/EgresosTotales')!!}">Egresos Totales</a></li>
                <!--<li><a href="{!!URL::to('/tesorera/reportes/Saldo')!!}" target="_blank">Saldo</a></li>-->
            </ul>
          </li>
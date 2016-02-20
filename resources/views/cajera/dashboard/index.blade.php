  <h1>COBROS</h1>

  @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{Session::get('message')}}
    </div>
  @endif

  @include('messages.errors')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body card-padding">
          {!!Form::open(['class' => 'form-horizontal'])!!}
            <div class="form-group">
              <label for="codigo" class="col-sm-3 control-label">Ingrese código</label>
              <div class="col-sm-6">
                  <div class="fg-line">
                      <input type="text" class="form-control input-sm" id="codigo" name="codigo" placeholder="DNI de alumno o Código de pago">
                  </div>
              </div>
              <div class="col-sm-3">
                <button class="btn btn-warning waves-effect">Buscar</button>
              </div>
            </div>
          {!!Form::close()!!}
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h3>Santiago Perez Huaman</h3>
          <h4>Universidad Privada Líder Peruana</h4>
        </div>
        <div class="card-body card-padding">
          <h4>Pagos Pendientes</h4>
          <div class="table-responsive">
            <table id="pagos-pendientes" class="table table-striped">
              <thead>
                  <tr>
                      <th data-column-id="id" data-visible="false" data-identifier="true">Id</th>
                      <th data-column-id="Nombre" class="warning c-white">Nombre</th>
                      <th data-column-id="Monto" class="warning c-white">Monto</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Matrícula Colegio 2016</td>
                  <td>100.00</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Matrícula CEBA 2016</td>
                  <td>100.00</td>
                </tr>
              </tbody>
            </table>
          </div>
          <h4>Compras</h4>
          <div class="table-responsive">
            <table id="categorias-compras" class="table table-striped">
              <thead>
                  <tr>
                      <th class="warning c-white">Concepto</th>
                      <th class="warning c-white">Cantidad</th>
                      <th class="warning c-white">Monto Unitario (S/)</th>
                      <th class="warning c-white">Importe</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Constancia</td>
                  <td>
                    <div class="fg-line">
                      <input type="text" class="form-control">
                    </div>
                  </td>
                  <td>100.00</td>
                  <td>100.00</td>
                </tr>
                <tr>
                  <td>FUT</td>
                  <td>
                    <div class="fg-line">
                      <input type="text" class="form-control">
                    </div>
                  </td>
                  <td>100.00</td>
                  <td>100.00</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button class="btn btn-warning pull-right waves-effect">
                FINALIZAR
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h3>Cliente: Marcelo Soto Paredes</h3>
        </div>
        <div class="card-body card-padding">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <div class="col-sm-2"><h4>Concepto:</h4></div>
              <div class="col-sm-8">Alquiler de local. Días 21-01 al 23-01.</div>
              <div class="col-sm-2">S/ 500.00</div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="pull-right">
                  <button class="btn btn-gray waves-effect">Cancelar</button>
                  <button class="btn bgm-green waves-effect">Comprobante</button>
                  <button class="btn bgm-indigo waves-effect">Boleta</button>
                  <button class="btn bgm-red waves-effect">Factura</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
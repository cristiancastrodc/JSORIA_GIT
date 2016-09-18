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
</head>
<body>
        <div class="card-body card-padding">
          {!!Form::open(array('route' => 'admin.usuarios.store', 'class' => 'form-horizontal', 'method' => 'POST'))!!}
            <div class="form-group">
              <label for="dni" class="col-sm-3 control-label">DNI</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="dni" name="dni" placeholder="DNI" data-mask="00000000">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="nombres" class="col-sm-3 control-label">Nombres</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="nombres" name="nombres" placeholder="Nombres">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="apellidos" name="apellidos" placeholder="Apellidos">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="tipo" class="col-sm-3 control-label">Tipo</label>
              <div class="col-sm-9">
                <select class="selectpicker" name="tipo" id="tipo">
                  <option>Administrador</option>
                  <option>Cajera</option>
                  <option>Secretaria</option>
                  <option>Tesorera</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="permisos" class="col-sm-3 control-label">Permisos</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <div class="select">
                    <select class="chosen" multiple data-placeholder="Elegir..." id="permisos" name="permisos[]">
                      <option value="1">I.E. J. Soria</option>
                      <option value="2">CEBA Konrad Adenahuer</option>
                      <option value="3">I.S.T. Urusayhua</option>
                      <option value="4">ULP</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="user" class="col-sm-3 control-label">Usuario</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="text" class="form-control input-sm" id="usuario_login" name="usuario_login" placeholder="Usuario">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-3 control-label">Contraseña</label>
              <div class="col-sm-9">
                <div class="fg-line">
                  <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Contraseña">
                </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-warning waves-effect pull-right">Guardar</button>
            </div>
          {!!Form::close()!!}
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
</body>
</html>
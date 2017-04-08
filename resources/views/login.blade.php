<!DOCTYPE html>
  <!--[if IE 9 ]><html class="ie9"><![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Intranet | Sistema de Caja</title>
    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
    <!-- Vendor CSS -->
    {!!Html::style('vendors/bower_components/animate.css/animate.min.css')!!}
    {!!Html::style('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')!!}
    <!-- CSS -->
    {!!Html::style('css/app.min.1.css')!!}
    {!!Html::style('css/app.min.2.css')!!}
    {!!Html::style('css/own.styles.css')!!}
  </head>
  <body class="login-content">
    <!-- Login -->
    <div class="lc-block toggled" id="l-login">
      <h1><span class="h3">..::J. SORIA::..</span>&nbsp<span class="h4">Corporación Educativa</span></h1>
      <h2><span class="h4">Sistema de Caja</span></h2>
      {!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
        <div class="input-group m-b-20">
          <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
          <div class="fg-line">
            {!!Form::text('usuario_login', null, ['class' => 'form-control', 'placeholder' => 'Usuario' ])!!}
          </div>
        </div>
        <div class="input-group m-b-20">
          <span class="input-group-addon"><i class="zmdi zmdi-key"></i></span>
          <div class="fg-line">
            {!!Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña'])!!}
          </div>
        </div>
        <div class="clearfix"></div>
        {!!Form::button('<i class="zmdi zmdi-arrow-forward"></i>', array('type' => 'submit', 'class' => 'btn btn-login main-color btn-float'))!!}
        @include('messages.login-error')
        @include('messages.errors')
      {!!Form::close()!!}
    </div>
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
      <div class="ie-warning">
        <h1 class="c-white">Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
          <ul class="iew-download">
            <li>
              <a href="http://www.google.com/chrome/">
                <img src="img/browsers/chrome.png" alt="">
                <div>Chrome</div>
              </a>
            </li>
            <li>
              <a href="https://www.mozilla.org/en-US/firefox/new/">
                <img src="img/browsers/firefox.png" alt="">
                <div>Firefox</div>
              </a>
            </li>
            <li>
              <a href="http://www.opera.com">
                <img src="img/browsers/opera.png" alt="">
                <div>Opera</div>
              </a>
            </li>
            <li>
              <a href="https://www.apple.com/safari/">
                <img src="img/browsers/safari.png" alt="">
                <div>Safari</div>
              </a>
            </li>
            <li>
              <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                <img src="img/browsers/ie.png" alt="">
                <div>IE (New)</div>
              </a>
            </li>
          </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
      </div>
    <![endif]-->
    <!-- Javascript Libraries -->
    {!!Html::script('vendors/bower_components/jquery/dist/jquery.min.js')!!}
    {!!Html::script('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')!!}
    {!!Html::script('vendors/bower_components/Waves/dist/waves.min.js')!!}
    <!-- Placeholder for IE9 -->
    <!--[if IE 9 ]>
        {!!Html::script('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js')!!}
    <![endif]-->
    {!!Html::script('js/functions.js')!!}
  </body>
</html>
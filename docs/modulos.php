use JSoria\Usuario_Modulos;

    $modulos = Usuario_Modulos::modulosDeUsuario();

    return view('admin.usuario.modulos', ['modulos' => $modulos]);

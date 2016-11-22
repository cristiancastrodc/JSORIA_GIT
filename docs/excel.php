        /*


        $view = \View::make('admin.reportes.balance_rept', compact('fecha', 'balance', 'balance_detallado', 'nombre_tesorera'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($archivo);
        */

        $archivo = 'Balance Ingresos Egresos-' . date('dmYHis');

        \Excel::create($archivo, function($excel) {
            $excel->sheet('Hoja 1', function($sheet) {
                $fecha = date('d-m-Y H:i:s');
                /*
                $balance = Balance::getBalanceTesorera($request->id_tesorera, date('Y-m-d'));
                $balance_detallado = Balance::getBalanceDetalladoTesorera($request->id_tesorera, date('Y-m-d'));

                $tesorera = User::find($request->id_tesorera);
                $nombre_tesorera = $tesorera->nombres . ' ' . $tesorera->apellidos;
                */
                $sheet->loadView('admin.reportes.balance_rept', array(
                    'fecha' => $fecha,
                    /*
                    'balance' => $balance,
                    'balance_detallado' => $balance_detallado,
                    'nombre_tesorera' => $nombre_tesorera)
                    */
                ));
            });
        })->download('xls');

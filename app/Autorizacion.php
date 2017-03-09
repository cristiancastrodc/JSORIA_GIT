<?php

namespace JSoria;

use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    protected $table = 'autorizacion';

	protected $fillable = ['rd','estado','id_alumno','fecha_limite'];
}

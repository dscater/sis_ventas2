<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'ci',
        'ci_exp',
        'dir',
        'cel',
        'fono',
        'foto',
        'correo',
        'rol',
        'user_id'
    ];

    protected $appends = ["foto_b64"];

    public function getFotoB64Attribute()
    {
        $path = public_path("imgs/empleado/" . $this->foto);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }
        return "";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'empleado_id', 'id');
    }
}

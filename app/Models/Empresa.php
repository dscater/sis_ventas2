<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cod',
        'nit',
        'nro_aut',
        'nro_emp',
        'name',
        'alias',
        'pais',
        'dpto',
        'ciudad',
        'zona',
        'calle',
        'nro',
        'email',
        'fono',
        'cel',
        'fax',
        'casilla',
        'web',
        'logo',
        'actividad_eco',
    ];

    protected $appends = ["logo_b64"];

    public function getLogoB64Attribute()
    {
        $path = public_path("imgs/empresa/" . $this->logo);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }
        return "";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    public $timestamps = true;

    protected $fillable = [
        'clave',
        'valor',
    ];

    public const CORREO_EVALUACIONES_PDF = 'correo_evaluaciones_pdf';

    public static function get(string $clave, ?string $default = null): ?string
    {
        $fila = static::where('clave', $clave)->first();

        return $fila?->valor ?: $default;
    }

    public static function getList(string $clave, array $default = []): array
    {
        $valor = static::get($clave);

        if (!$valor) {
            return $default;
        }

        return collect(explode(',', $valor))
            ->map(fn ($correo) => trim($correo))
            ->filter()
            ->values()
            ->all();
    }

    public static function set(string $clave, ?string $valor): void
    {
        static::updateOrCreate(
            ['clave' => $clave],
            ['valor' => $valor],
        );
    }
}

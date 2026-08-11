<?php

namespace App\Jobs;

use App\Mail\EvaluacionCompletadaMail;
use App\Models\Calificacion;
use App\Models\CorreoEnviado;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EnviarCorreoEvaluacionJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public int $tries = 3;
  public int $backoff = 60;

  public function __construct(
    public CorreoEnviado $correoEnviado,
    public Proyecto $proyecto,
    public Calificacion $calificacion,
    public User $juez,
    public string $pdfPath,
  ) {
    $this->onQueue('emails');
  }

  public function handle(): void
  {
    $correo = $this->correoEnviado->refresh();

    if ($correo->Estado === 'Enviado') {
      return;
    }

    Mail::to($correo->Correo_destino)->send(
      new EvaluacionCompletadaMail(
        $this->proyecto,
        $this->calificacion,
        $this->juez,
        $this->pdfPath,
        $correo,
      )
    );

    $correo->update([
      'Estado' => 'Enviado',
      'Fecha_Envio' => now(),
      'Mensaje_Error' => null,
    ]);
  }

  public function failed(Throwable $e): void
  {
    $this->correoEnviado->refresh()->update([
      'Estado' => 'Error',
      'Mensaje_Error' => $e->getMessage(),
    ]);
  }
}

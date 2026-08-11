<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CuentaCreadaMail extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  public function __construct(
    public string $nombreCompleto,
    public string $email,
    public string $cedula,
    public string $nombreUsuario,
  ) {
    $this->onQueue('emails');
  }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ExpoTÉCNICA 2026 — Cuenta Creada',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cuenta-creada',
        );
    }
}

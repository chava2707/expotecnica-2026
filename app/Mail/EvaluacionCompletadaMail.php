<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Proyecto;
use App\Models\Calificacion;
use App\Models\User;
use App\Models\CorreoEnviado;

class EvaluacionCompletadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Proyecto $proyecto,
        public Calificacion $calificacion,
        public User $juez,
        public string $pdfPath,
        public CorreoEnviado $correoEnviado,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ExpoTÉCNICA 2026 — Evaluación Completada: ' . $this->proyecto->Nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.evaluacion-completada',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->pdfPath)
                ->as('Rubrica-Evaluacion-' . $this->proyecto->ID_Proyecto . '-' . $this->juez->id . '-' . $this->calificacion->ID_Rubrica . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

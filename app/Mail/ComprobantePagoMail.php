<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobantePagoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pago;
    public $asesor;
    protected $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct($pago, $asesor, $pdfContent)
    {
        $this->pago = $pago;
        $this->asesor = $asesor;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $tipo = $this->pago->tipo == 'semanal' ? 'Semana ' . $this->pago->semana : 'Bono Mensual';
        return new Envelope(
            subject: 'Comprobante de Pago - ' . $tipo . ' - Creamos Hojas de Vida',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn () => $this->pdfContent,
                'Comprobante_Pago_' . $this->pago->id . '.pdf'
            )
                ->withMime('application/pdf'),
        ];
    }
}

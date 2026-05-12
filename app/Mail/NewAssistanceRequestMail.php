<?php

namespace App\Mail;

use App\Models\AssistanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAssistanceRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AssistanceRequest $assistanceRequest)
    {
    }

    public function envelope(): Envelope
    {
        $refNo = '#' . str_pad($this->assistanceRequest->id, 5, '0', STR_PAD_LEFT);

        return new Envelope(
            subject: "[BERKAT] Permohonan Baru Memerlukan Semakan – {$refNo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-assistance-request',
        );
    }
}

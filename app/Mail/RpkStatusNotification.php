<?php

namespace App\Mail;

use App\Models\Rpk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RpkStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Rpk $rpk;

    public string $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Rpk $rpk, string $status)
    {
        $this->rpk = $rpk->load(['user', 'verifiedBy']);
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusLabel = ucfirst($this->status);

        return new Envelope(
            subject: 'RPK ' . $statusLabel . ' — Tahun ' . ($this->rpk->tahun ?? '-') . ' Semester ' . ($this->rpk->semester ?? '-'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rpk-status',
            with: [
                'rpk' => $this->rpk,
                'status' => $this->status,
            ],
        );
    }
}
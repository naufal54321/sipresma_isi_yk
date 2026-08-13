<?php

namespace App\Mail;

use App\Models\Spk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpkStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Spk $spk;

    public string $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Spk $spk, string $status)
    {
        $this->spk = $spk->load(['user', 'kegiatan', 'verifiedBy']);
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusLabel = ucfirst($this->status);
        $judul = $this->spk->judul_karya ?? $this->spk->kegiatan?->judul_kegiatan ?? 'SPK';

        return new Envelope(
            subject: 'SPK ' . $statusLabel . ' — ' . $judul,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.spk-status',
            with: [
                'spk' => $this->spk,
                'status' => $this->status,
            ],
        );
    }
}
<?php

namespace App\Mail;

use App\Models\Spk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpkApprovedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public Spk $spk;

    /**
     * Create a new message instance.
     */
    public function __construct(Spk $spk)
    {
        $this->spk = $spk->load(['user', 'kegiatan']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nama = $this->spk->user->name ?? 'Mahasiswa';

        return new Envelope(
            subject: 'SPK Disetujui — Tambahkan Poin (' . $nama . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.spk-approved-admin',
            with: [
                'spk' => $this->spk,
            ],
        );
    }
}
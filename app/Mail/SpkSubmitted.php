<?php

namespace App\Mail;

use App\Models\Spk;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpkSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Spk $spk;

    public ?User $dosen;

    /**
     * Create a new message instance.
     */
    public function __construct(Spk $spk)
    {
        $this->spk = $spk->load(['user', 'kegiatan', 'user.dosenPembimbing']);
        $this->dosen = $spk->user->dosenPembimbing;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nama = $this->spk->user->name ?? 'Mahasiswa';

        return new Envelope(
            subject: 'SPK Baru Diajukan — ' . $nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.spk-submitted',
            with: [
                'spk' => $this->spk,
                'dosen' => $this->dosen,
            ],
        );
    }
}
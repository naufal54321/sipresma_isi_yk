<?php

namespace App\Mail;

use App\Models\Rpk;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RpkSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Rpk $rpk;

    public string $penerima;

    public ?User $dosen;

    /**
     * Create a new message instance.
     */
    public function __construct(Rpk $rpk, string $penerima = 'Admin')
    {
        $this->rpk = $rpk->load(['user', 'dosenPembimbing']);
        $this->penerima = $penerima;
        $this->dosen = $rpk->dosenPembimbing;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nama = $this->rpk->user->name ?? 'Mahasiswa';

        return new Envelope(
            subject: 'RPK Baru Diajukan — ' . $nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rpk-submitted',
            with: [
                'rpk' => $this->rpk,
                'penerima' => $this->penerima,
                'dosen' => $this->dosen,
            ],
        );
    }
}
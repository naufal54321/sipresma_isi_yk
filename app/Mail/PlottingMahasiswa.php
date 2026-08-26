<?php

namespace App\Mail;

use App\Models\Rpk;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlottingMahasiswa extends Mailable
{
    use Queueable, SerializesModels;

    public Rpk $rpk;

    public User $dosen;

    /**
     * Create a new message instance.
     */
    public function __construct(Rpk $rpk, User $dosen)
    {
        $this->rpk = $rpk->load(['user']);
        $this->dosen = $dosen;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nama = $this->rpk->user->name ?? 'Mahasiswa';

        return new Envelope(
            subject: 'Plotting Dosen Pembimbing — RPK ' . $nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.plotting-mahasiswa',
            with: [
                'rpk' => $this->rpk,
                'dosen' => $this->dosen,
            ],
        );
    }
}
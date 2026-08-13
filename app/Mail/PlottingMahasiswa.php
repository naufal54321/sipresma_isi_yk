<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlottingMahasiswa extends Mailable
{
    use Queueable, SerializesModels;

    public User $mahasiswa;

    public User $dosen;

    /**
     * Create a new message instance.
     */
    public function __construct(User $mahasiswa, User $dosen)
    {
        $this->mahasiswa = $mahasiswa;
        $this->dosen = $dosen;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mahasiswa Baru Bimbingan — ' . ($this->mahasiswa->name ?? 'Mahasiswa'),
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
                'mahasiswa' => $this->mahasiswa,
                'dosen' => $this->dosen,
            ],
        );
    }
}
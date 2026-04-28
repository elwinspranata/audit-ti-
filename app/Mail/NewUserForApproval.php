<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// Hapus atau komentari ini:
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;

class NewUserForApproval extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pemberitahuan Persetujuan User Baru')
                    ->markdown('emails.admin.new-user-approval')
                    ->with([
                        'user' => $this->user,
                    ]);
    }
}

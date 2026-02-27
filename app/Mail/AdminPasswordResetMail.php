<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\EmailTemplate;

class AdminPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $url;
    protected $template;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = route('admin.password.reset', ['token' => $token, 'email' => $user->email]);
        $this->template = EmailTemplate::where('slug', 'admin-password-reset')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template ? $this->template->subject : 'Admin Password Reset Request';
        $subject = str_replace(['{{company}}'], [config('app.name')], $subject);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->template) {
            $content = str_replace(
                ['{{name}}', '{{url}}', '{{company}}'],
                [$this->user?->first_name, $this->url, config('app.name')],
                $this->template?->description
            );

            return new Content(
                view: 'emails.dynamic',
                with: [
                    'content' => $content,
                ],
            );
        }

        return new Content(
            view: 'emails.admin.admin-password-reset',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

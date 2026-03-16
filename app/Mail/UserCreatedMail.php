<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    protected $template;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->template = EmailTemplate::where('slug', 'staff-created')->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template ? $this->template->subject : 'Your Account Details - ' . config('app.name');
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
                ['{{name}}', '{{email}}', '{{password}}', '{{login_url}}', '{{company}}'],
                [$this->user->first_name, $this->user->email, $this->password, route('admin.login'), config('app.name')],
                $this->template->description
            );

            return new Content(
                view: 'emails.dynamic',
                with: [
                    'content' => $content,
                ],
            );
        }

        return new Content(
            view: 'emails.dynamic',
            with: [
                'content' => '',
            ],
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

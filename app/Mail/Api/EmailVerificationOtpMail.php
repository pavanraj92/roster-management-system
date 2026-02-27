<?php

namespace App\Mail\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\EmailTemplate;

class EmailVerificationOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $htmlContent;
    public $subjectLine;

    public function __construct(User $user, string $otp)
    {
        // template fetch
        $template = EmailTemplate::where('slug', 'email-verification-otp')
            ->where('status', 1)
            ->first();

        if ($template) {
            $search = ['{{name}}', '{{otp}}', '{{company}}'];
            $replace = [
                $user->first_name,
                $otp,
                config('app.name') ?? 'Roster'
            ];

            $this->htmlContent = str_replace($search, $replace, $template->description);
            $this->subjectLine = $template->subject;
        } else {
            // fallback
            $this->htmlContent = "<p>Your OTP is: {$otp}</p>";
            $this->subjectLine = 'Email Verification OTP';
        }
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.api.dynamic-template') // tumhara blade
            ->with([
                'htmlContent' => $this->htmlContent,
            ]);
    }
}
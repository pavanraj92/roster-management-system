<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [

            // Email Verification OTP
            [
                'name' => 'Email Verification OTP',
                'subject' => 'Email Verification OTP',
                'slug' => 'email-verification-otp',
                'description' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Email Verification OTP</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hello {{name}},</h2>
    <p>Your email verification OTP is:</p>
    <h3>{{otp}}</h3>
    <p>This OTP is valid for <strong>5 minutes</strong>.</p>
    <p>If you did not request this, please ignore this email.</p>
    <p>Regards,<br>{{company}}</p>
</body>
</html>',
                'status' => 1,
            ],

            // Admin Password Reset
            [
                'name' => 'Admin Password Reset',
                'subject' => 'Admin Password Reset Request',
                'slug' => 'admin-password-reset',
                'description' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hello {{name}},</h2>
    <p>You are receiving this email because we received a password reset request for your admin account.</p>
    <p>Click the button below to reset your password:</p>
    <p><a href="{{url}}" style="background:#3b95b7;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;">Reset Password</a></p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Regards,<br>{{company}}</p>
</body>
</html>',
                'status' => 1,
            ],

            // Staff Created
            [
                'name' => 'Staff Created',
                'subject' => 'Your Account Details - {{company}}',
                'slug' => 'staff-created',
                'description' => '<!DOCTYPE html>
<html>
<head>
<title>Account Created</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2 style="color: #3b95b7;">Welcome to {{company}}!</h2>
    <p>Hello {{name}},</p>
    <p>Your account has been created by the administrator. Here are your login credentials:</p>
    <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p style="margin: 0;"><strong>Email:</strong> {{email}}</p>
        <p style="margin: 0;"><strong>Password:</strong> {{password}}</p>
    </div>
    <p>You can login using the link below:</p>
    <p><a href="{{login_url}}"
            style="display: inline-block; padding: 10px 20px; background-color: #3b95b7; color: #fff; text-decoration: none; border-radius: 5px;">Login
            Now</a></p>
    <p>For security reasons, we recommend you change your password after your first login.</p>
    <p>Best Regards,<br>{{company}} Team</p>
</body>
</html>',
                'status' => 1,
            ],

        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}

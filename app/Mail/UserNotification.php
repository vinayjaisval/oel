<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $email_body;
    public $attachmentPath;
    public $attachmentName;

    public function __construct($subject, $email_body, $attachmentPath = null, $attachmentName = null)
    {
        $this->subject = $subject;
        $this->email_body = $email_body;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentName = $attachmentName;
    }

    public function build()
    {
        $email = $this->subject($this->subject)
            ->view('admin.email.lead-user-email')
            ->with([
                'email_body' => $this->email_body,
                'subject' => $this->subject,
                'attachmentName' => $this->attachmentName 
                    ? preg_replace('/^\d+_/', '', $this->attachmentName)
                    : null,
            ]);

        // ✅ FINAL FIX: attach from file path
        if (!empty($this->attachmentPath) && file_exists($this->attachmentPath)) {

            $email->attach($this->attachmentPath, [
                'as' => preg_replace('/^\d+_/', '', $this->attachmentName),
                'mime' => $this->getMimeType($this->attachmentName),
            ]);
        }

        return $email;
    }

    private function getMimeType($filename)
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
    }
}
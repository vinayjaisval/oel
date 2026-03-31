<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StudentRegistraionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student_data;

    public function __construct($student_data)
    {
        $this->student_data = (array) $student_data;

        Log::info("📧 StudentRegistraionMail Constructed", [
            'email' => $this->student_data['email'] ?? 'N/A'
        ]);
    }

    public function build()
    {
        Log::info("📧 Building mail for: " . ($this->student_data['email'] ?? 'N/A'));

        return $this->view('emails.created_profile_success')
            ->with(['student_data' => $this->student_data])
            ->subject('Registration Successful');
    }
}

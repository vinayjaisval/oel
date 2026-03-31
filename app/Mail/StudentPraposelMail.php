<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentPraposelMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected  $studentData;
    public $attachmentPath;
    public $attachmentName;
    public function __construct($studentData)
    {
        $this->studentData = $studentData;
        
    }

    public function build()
    {
        return $this->view('emails.student_praposel')
       
            ->with([
                'studentData' => $this->studentData,
            ]);
             

    }
}

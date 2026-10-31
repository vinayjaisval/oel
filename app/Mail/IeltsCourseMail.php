<?php

namespace App\Mail;

use App\Models\IeltsCourseEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IeltsCourseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IeltsCourseEnquiry $enquiry,
        public string $event,
        public string $audience
    ) {
    }

    public function build()
    {
        $subject = $this->event === 'payment'
            ? 'IELTS course payment confirmed - ' . $this->enquiry->enquiry_reference
            : 'IELTS course enquiry - ' . $this->enquiry->enquiry_reference;

        return $this->subject($subject)->view('emails.ielts-course');
    }
}
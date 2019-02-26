<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $newsletter_text;
    public $client_email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newsletter_text, $client_email)
    {
        $this->newsletter_text = $newsletter_text;
        $this->client_email = $client_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.newsletter');
    }
}

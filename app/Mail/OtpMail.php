<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use stdClass;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var stdClass
     */
    public stdClass $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
                ->from(env('MAIL_FROM_ADDRESS'), 'solopayment.notification')
                ->subject('SOLOPAYMENT NOTIFICATION')
                ->view($this->mail->view);
    }
}

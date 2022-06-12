<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LogMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var stdClass
     */
    public $logs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
            ->from(env('MAIL_FROM_ADDRESS'), 'System Send Logs')
            ->subject('AI DIGITAL MEDIA')
            ->view('mail.logs');
    }
}

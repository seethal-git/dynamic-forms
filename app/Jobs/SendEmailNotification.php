<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $recipientEmail;
    protected $subject;
    protected $message;
    protected $fromEmail;
    protected $fromName;

    /**
     * Constructor to initialize the email sending parameters.
     *
     * @param string $recipientEmail The recipient's email address
     * @param string $subject The subject of the email
     * @param string $message The message body of the email
     * @param string $fromEmail The sender's email address
     * @param string|null $fromName The sender's name (optional)
     */
    public function __construct($recipientEmail, $subject, $message, $fromEmail, $fromName = null)
    {
        $this->recipientEmail = $recipientEmail;
        $this->subject = $subject;
        $this->message = $message;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    /**
     * Handle the process of sending an email with the specified details.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->message, function ($mail) {
            $mail->to($this->recipientEmail)
                 ->subject($this->subject)
                 ->from($this->fromEmail, $this->fromName);
        });
    }

   
}

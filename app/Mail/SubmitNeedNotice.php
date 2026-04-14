<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailable\Content;
use Illuminate\Queue\SerializesModels;

class SubmitNeedNotice extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $mssg, $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $mssg, $subject)
    {
        $this->name = $name;
        $this->mssg = $mssg;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notice of Need Submission',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.submitneedsnotice',
            with: ['name' => $this->name, 'message' => $this->mssg],

        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.submitneedsnotice')
            //->subject($subject);
            ->with([
                'name' => $this->name,
                'mssg' => $this->mssg
            ]);

        // return new Content(
        //     view: 'emails.submitneedsnotice',
        //     with: ['name' => $this->name, 'message' => $this->message],

        // );
    }
}



// You are by this notice reminded of the needed items of the department to be submitted through the procurement platform.
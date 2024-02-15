<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailFrom extends Mailable
{
    use Queueable, SerializesModels;

    private $customerFrom;
    private $customerTo;
    private $accountfrom;
    private $accountto;
    private $amount;
    private $date;


    /**
     * Create a new message instance.
     */

    public function __construct( $customerFrom,
                                 $customerTo,
                               $accountfrom,
                               $accountto,
                               $amount,
                               $date)
    {

        $this->customerFrom = $customerFrom;
        $this->customerTo = $customerTo;
        $this->accountfrom = $accountfrom;
        $this->accountto = $accountto;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Email From',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'FromEmail',
            with: ['customerFrom'=> $this->customerFrom ,
                'customerTo'=> $this->customerTo ,
                'accountfrom'=>$this->accountfrom  ,
                'accountto'=> $this->accountto ,
                'amount'=>$this->amount ,
                'date'=>$this->date ,],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

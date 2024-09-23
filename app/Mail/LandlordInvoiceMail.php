<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LandlordInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    protected $message;
    protected $invoicePath;
    protected $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $message
     * @param string $invoicePath
     * @param string $pdfPath
     */
    public function __construct($subject, $message, $invoicePath, $pdfPath)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->invoicePath = $invoicePath;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.landlord_invoice')
                    ->subject($this->subject)
                    ->with([
                        'messageContent' => is_array($this->message) ? implode(", ", $this->message) : $this->message,
                    ])
                    ->attachFromStorageDisk('public', $this->invoicePath, [
                        'as' => 'invoice.html',
                        'mime' => 'text/html',
                    ])
                    ->attachFromStorageDisk('public', $this->pdfPath, [
                        'as' => 'Rent_Statement.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

}

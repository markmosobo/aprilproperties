<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
        $this->message = is_array($message) ? implode(", ", $message) : $message;        
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
            'messageContent' => $this->message, // Guaranteed to be a string
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

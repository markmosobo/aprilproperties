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
        $this->message = is_array($message) ? implode(", ", array_map('strval', $message)) : $message;
        // $this->message = is_array($message) ? implode(", ", $message) : $message;        
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
    $email = $this->view('emails.landlord_invoice')
        ->subject($this->subject)
        ->with([
            'messageContent' => $this->message,
        ]);

    // Get the full paths for the files
    $invoiceFullPath = storage_path('app/public/' . $this->invoicePath);
    $pdfFullPath = storage_path('app/public/' . $this->pdfPath);

    // Attach invoice file
    if (file_exists($invoiceFullPath)) {
        $email->attach($invoiceFullPath, [
            'as' => 'invoice.html',
            'mime' => 'text/html',
        ]);
    } else {
        \Log::error('Invoice file not found.', ['path' => $invoiceFullPath]);
    }

    // Attach PDF file
    if (file_exists($pdfFullPath)) {
        $email->attach($pdfFullPath, [
            'as' => 'Rent_Statement.pdf',
            'mime' => 'application/pdf',
        ]);
    } else {
        \Log::error('PDF file not found.', ['path' => $pdfFullPath]);
    }

    return $email;
}

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $meil_array;
    public $total_invoice_sum;
    /** 
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meil_array, $total_invoice_sum)
    {
        $this->meil_array = $meil_array;
        $this->total_invoice_sum = $total_invoice_sum;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.invoice_order');
    }
}

<?php

namespace App\Mail;

use App\Models\Dedication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonorReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $dedication;
    public $intent;

    public function __construct(Dedication $dedication, $intent = null)
    {
        $this->dedication = $dedication;
        $this->intent = $intent;
    }

    public function build()
    {
        return $this->subject('Your Video Dedication is Confirmed.')
            ->view('emails.donor_receipt')
            ->with(['dedication' => $this->dedication, 'intent' => $this->intent]);
    }
}

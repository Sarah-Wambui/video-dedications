<?php

namespace App\Mail;

use App\Models\Dedication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
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
        return $this->subject('New Paid Video Dedication')
            ->view('emails.admin_notification')
            ->with(['dedication' => $this->dedication, 'intent' => $this->intent]);
    }
}

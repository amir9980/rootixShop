<?php

namespace App\Mail;

use App\Models\DiscountEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDiscountEvent extends Mailable
{
    use Queueable, SerializesModels;

    protected $event;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DiscountEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.discountEvent')->subject($this->event->title);
    }
}

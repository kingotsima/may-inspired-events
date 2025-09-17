<?php

// app/Notifications/BookingNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $message;

    public function __construct(Booking $booking, $message)
    {
        $this->booking = $booking;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'service' => $this->booking->service->title,
            'amount' => $this->booking->amount,
            'message' => $this->message,
            'reference' => $this->booking->reference,
        ];
    }
}

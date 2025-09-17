<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\AdminEventBooking;

class AdminEventBookingStatus extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(AdminEventBooking $booking)
    {
        $this->booking = $booking;
    }

    // Decide how this notification will be delivered
    public function via($notifiable)
    {
        return ['database', 'mail']; // database + email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Event Booking Status')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('Your booking for the event "' . $this->booking->event_name . '" has been ' . $this->booking->status . '.')
                    ->action('View Booking', url('/admin/event-bookings/' . $this->booking->id))
                    ->line('Thank you for using our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'event_name' => $this->booking->event_name,
            'status'     => $this->booking->status,
            'message'    => 'Your booking has been ' . $this->booking->status,
        ];
    }
}

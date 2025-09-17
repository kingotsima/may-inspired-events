<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use Yabacon\Paystack;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingNotification;
use GuzzleHttp\Exception\ConnectException;

class BookingController extends Controller
{
    /**
     * Store a service booking and initialize Paystack payment
     */
    public function store(Request $request, Service $service)
    {
        $amount = $service->base_price;

        // Create booking first
        $booking = Booking::create([
            'user_id'    => Auth::id(),
            'service_id' => $service->id,
            'type'       => 'service',
            'amount'     => $amount,
            'status'     => 'pending',
            'reference'  => Str::uuid()->toString(),
        ]);

        // ❌ Removed vendor notify here (only notify after payment success)

        // Initialize Paystack
        try {
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

            $tranx = $paystack->transaction->initialize([
                'amount'       => $booking->amount * 100, // Paystack wants amount in kobo
                'email'        => Auth::user()->email,
                'reference'    => $booking->reference,
                'callback_url' => route('booking.callback'),
            ]);

            return redirect($tranx->data->authorization_url);

        } catch (ConnectException $e) {
            return redirect()
                ->route('services.show', $service->id)
                ->with('error', 'Network error: Unable to connect to Paystack. Please try again.');
        } catch (Exception $e) {
            Log::error("Paystack error: " . $e->getMessage());

            return redirect()
                ->route('services.show', $service->id)
                ->with('error', 'Payment service is currently unavailable. Please try again later.');
        }
    }

    /**
     * Handle Paystack callback after payment
     */
    public function callback(Request $request)
    {
        try {
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

            $tranx = $paystack->transaction->verify([
                'reference' => $request->reference
            ]);

            $booking = Booking::where('reference', $request->reference)->firstOrFail();

            if ($tranx->data->status === 'success') {
                $booking->update(['status' => 'paid']);

                /** -------------------------
                 *  Notify USER (idempotent)
                 * -------------------------
                 */
                if (!$booking->user->notifications()
                        ->where('type', BookingNotification::class)
                        ->where('data->reference', $booking->reference)
                        ->exists()) {
                    $booking->user->notify(new BookingNotification(
                        $booking,
                        "✅ Your payment for {$booking->service->title} was successful!"
                    ));
                }

                /** -------------------------
                 *  Notify VENDOR (idempotent)
                 * -------------------------
                 */
                if ($booking->service->vendor && $booking->service->vendor->user) {
                    $vendorUser = $booking->service->vendor->user;
                    if (!$vendorUser->notifications()
                            ->where('type', BookingNotification::class)
                            ->where('data->reference', $booking->reference)
                            ->exists()) {
                        $vendorUser->notify(new BookingNotification(
                            $booking,
                            "💼 Your service '{$booking->service->title}' has been booked and paid!"
                        ));
                    }
                }

                return redirect()
                    ->route('client.bookings')
                    ->with('success', 'Payment successful! Booking confirmed.');

            } else {
                $booking->update(['status' => 'cancelled']);

                return redirect()
                    ->route('services.show', $booking->service_id)
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (ConnectException $e) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Network error while verifying payment. Please try again.');
        } catch (Exception $e) {
            \Log::error("Paystack callback error: " . $e->getMessage());

            return redirect()
                ->route('services.index')
                ->with('error', 'An error occurred while verifying your payment. Please contact support.');
        }
    }

    /**
     * Show admin event booking form
     */
    public function bookAdminEventForm()
    {
        return view('admin_booking.event_form');
    }

    /**
     * Store admin event booking request
     */
    public function bookAdminEvent(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'details'    => 'nullable|string',
        ]);

        // Store booking in the bookings table with type = 'event'
        Booking::create([
            'user_id'    => auth()->id(),
            'type'       => 'event',
            'status'     => 'pending', // admin must approve
            'amount'     => 0, // optional, can be updated later
            'reference'  => Str::uuid()->toString(),
            'details'    => [
                'event_name' => $request->event_name,
                'extra_info' => $request->details,
            ],
            'event_date' => $request->event_date,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Your request to book the admin for your event has been submitted! It will appear on your dashboard once approved.');
    }
}
<?php

// app/Http/Middleware/EnsureVendorActive.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureVendorActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user->vendor) {
            $status = $user->vendor->verification_status; // use verification_status

            if ($status === 'pending') {
                return redirect('/')->with('error', 'Your vendor application is pending approval. Please wait for the admin.');
            }

            if ($status === 'rejected') {
                return redirect('/')->with('error', 'Your vendor application was rejected. Contact admin for further assistance.');
            }

            if ($status === 'suspended') {
                return redirect('/')->with('error', 'Your account has been suspended. Contact admin to restore privileges.');
            }
        }

        return $next($request);
    }
}

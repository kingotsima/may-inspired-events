<?php

// app/Http/Controllers/Admin/AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Booking::where('status', 'paid')->sum('amount');
        $totalBookings = Booking::count();
        $paidBookings = Booking::where('status', 'paid')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();

        $totalUsers = User::count(); // ✅ counts all registered users
        $totalVendors = Vendor::count();
        $totalServices = Service::count();

        $revenueByDay = Booking::where('status', 'paid')
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'paidBookings',
            'pendingBookings',
            'totalUsers',    // ✅ send users count to view
            'totalVendors',
            'totalServices',
            'revenueByDay'
        ));
    }
}


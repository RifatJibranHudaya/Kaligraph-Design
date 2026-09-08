<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $activeBranchId = Session::get('active_branch_id', $user->branch_id);

        // Orders query filtered by branch if set
        $ordersQuery = Order::query();
        if ($activeBranchId) {
            $ordersQuery->where('branch_id', $activeBranchId);
        }

        $totalOrders = (clone $ordersQuery)->count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::where('is_active', true)->count();

        // Order status counts
        $ordersOrder      = (clone $ordersQuery)->where('status', 'order')->count();
        $ordersOnProgress = (clone $ordersQuery)->where('status', 'on_progress')->count();
        $ordersSelesai    = (clone $ordersQuery)->where('status', 'selesai')->count();
        $ordersCancelled  = (clone $ordersQuery)->where('status', 'cancelled')->count();

        // Total payments received
        $totalPembayaran = Payment::sum('jumlah');

        // Recent orders (latest 5)
        $recentOrders = Order::with(['user', 'branch', 'payments'])
            ->when($activeBranchId, fn($q) => $q->where('branch_id', $activeBranchId))
            ->latest('id')
            ->take(5)
            ->get();

        // Recent Activity Logs (latest 5)
        $recentLogs = ActivityLog::latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCategories',
            'ordersOrder',
            'ordersOnProgress',
            'ordersSelesai',
            'ordersCancelled',
            'totalPembayaran',
            'recentOrders',
            'recentLogs'
        ));
    }
}

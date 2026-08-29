<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Operational;
use App\Models\Order;
use App\Models\Product;
use App\Models\Production;
use App\Models\StockRecord;
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

        $totalOmset = (clone $ordersQuery)->sum('total');
        $totalOrders = (clone $ordersQuery)->count();
        $totalProducts = Product::where('is_active', true)->count();

        // Production costs
        $prodQuery = Production::query();
        if ($activeBranchId) {
            $prodQuery->where('branch_id', $activeBranchId);
        }
        $totalProductionCost = $prodQuery->sum('harga');

        // Operational costs
        $totalOperationalCost = Operational::sum('harga');
        $totalPengeluaran = $totalProductionCost + $totalOperationalCost;

        // Daily sales breakdown for chart (Last 7 days)
        $dailySales = (clone $ordersQuery)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_sales'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total_sales', 'date')
            ->toArray();

        // Category breakdown
        $categoryBreakdown = (clone $ordersQuery)
            ->select('kategori', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('kategori')
            ->get();

        // Stock Records overview (latest 5)
        $recentStockRecords = StockRecord::with('user')
            ->when($activeBranchId, fn($q) => $q->where('branch_id', $activeBranchId))
            ->latest('id')
            ->take(5)
            ->get();

        // Recent Activity Logs (latest 5)
        $recentLogs = ActivityLog::latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalOmset',
            'totalOrders',
            'totalProducts',
            'totalPengeluaran',
            'dailySales',
            'categoryBreakdown',
            'recentStockRecords',
            'recentLogs'
        ));
    }
}

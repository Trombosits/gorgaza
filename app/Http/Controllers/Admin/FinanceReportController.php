<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->input('status_pembayaran');
        $method = $request->input('metode_pembayaran');

        $query = $this->baseQuery($startDate, $endDate, $status, $method);

        $transactions = (clone $query)
            ->latest('waktu_transaksi')
            ->paginate(10)
            ->withQueryString();

        $summaryQuery = $this->baseQuery($startDate, $endDate, $status, $method);
        $paidRevenue = (clone $summaryQuery)->where('status_pembayaran', 'Paid')->sum('total_tagihan');
        $pendingRevenue = (clone $summaryQuery)->where('status_pembayaran', 'Pending')->sum('total_tagihan');
        $cancelledRevenue = (clone $summaryQuery)->where('status_pembayaran', 'Cancelled')->sum('total_tagihan');
        $transactionCount = (clone $summaryQuery)->count();

        $paymentStatusSummary = (clone $summaryQuery)
            ->select('status_pembayaran', DB::raw('COUNT(*) as total'), DB::raw('SUM(total_tagihan) as nominal'))
            ->groupBy('status_pembayaran')
            ->get();

        $paymentMethodSummary = (clone $summaryQuery)
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total'), DB::raw('SUM(total_tagihan) as nominal'))
            ->groupBy('metode_pembayaran')
            ->get();

        $dailyRevenue = (clone $summaryQuery)
            ->where('status_pembayaran', 'Paid')
            ->select(DB::raw('DATE(waktu_transaksi) as tanggal'), DB::raw('SUM(total_tagihan) as total'))
            ->groupBy(DB::raw('DATE(waktu_transaksi)'))
            ->orderBy('tanggal')
            ->get();

        $facilityRevenue = (clone $summaryQuery)
            ->where('transactions.status_pembayaran', 'Paid')
            ->join('reservations', 'transactions.id', '=', 'reservations.transaction_id')
            ->join('facilities', 'reservations.facility_id', '=', 'facilities.id')
            ->select('facilities.nama_fasilitas', DB::raw('COUNT(reservations.id) as total_booking'), DB::raw('SUM(reservations.subtotal) as total_revenue'))
            ->groupBy('facilities.id', 'facilities.nama_fasilitas')
            ->orderByDesc('total_revenue')
            ->get();

        return view('Admin.reports.finance', compact(
            'transactions',
            'startDate',
            'endDate',
            'status',
            'method',
            'paidRevenue',
            'pendingRevenue',
            'cancelledRevenue',
            'transactionCount',
            'paymentStatusSummary',
            'paymentMethodSummary',
            'dailyRevenue',
            'facilityRevenue'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->input('status_pembayaran');
        $method = $request->input('metode_pembayaran');

        $transactions = $this->baseQuery($startDate, $endDate, $status, $method)
            ->latest('waktu_transaksi')
            ->get();

        $fileName = 'laporan-keuangan-gorgaza-' . $startDate . '-sd-' . $endDate . '.csv';

        return response()->streamDownload(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID Transaksi', 'Tanggal', 'Customer', 'Email', 'Metode Pembayaran', 'Status Pembayaran', 'Total Tagihan', 'Jumlah Booking']);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    '#' . $transaction->id,
                    optional($transaction->waktu_transaksi)->format('Y-m-d H:i:s'),
                    $transaction->user->nama ?? $transaction->user->name ?? '-',
                    $transaction->user->email ?? '-',
                    $transaction->metode_pembayaran ?? 'Pay On Place',
                    $transaction->status_pembayaran,
                    $transaction->total_tagihan,
                    $transaction->reservations->count(),
                ]);
            }

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function baseQuery(?string $startDate, ?string $endDate, ?string $status, ?string $method = null)
    {
        return Transaction::with(['user', 'reservations.facility'])
            ->when($startDate, fn ($query) => $query->whereDate('waktu_transaksi', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('waktu_transaksi', '<=', $endDate))
            ->when($status, fn ($query) => $query->where('status_pembayaran', $status))
            ->when($method, fn ($query) => $query->where('metode_pembayaran', $method));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoicesDetails;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count_all = invoices::count();
        $count_invoices1 = invoices::where('value_status', 1)->count();
        $count_invoices2 = invoices::where('value_status', 2)->count();
        $count_invoices3 = invoices::where('value_status', 3)->count();

        $nspainvoices1 = $count_invoices1 / $count_all * 100;
        $nspainvoices2 = $count_invoices2 / $count_all * 100;
        $nspainvoices3 = $count_invoices3 / $count_all * 100;

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['Paid Invoices', 'Unpaid Invoices', 'Partially Paid Invoices'])
            ->datasets([
                [
                    "label" => "Percentage",
                    'backgroundColor' => ['#81b214', '#ec5858', '#ff9642'],
                    'data' => [$nspainvoices1, $nspainvoices2, $nspainvoices3]
                ],
            ])
            ->options([
                'legend' => ['display' => false], // إخفاء مفتاح الرسم البياني
                'scales' => [
                    'yAxes' => [[
                        'ticks' => ['beginAtZero' => true]
                    ]]
                ]
            ]);

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['Unpaid Invoices', 'Paid Invoices', 'Partially Paid Invoices'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1, $nspainvoices3]
                ]
            ])
            ->options([]);

        return view('dashboard', compact('chartjs', 'chartjs_2'));
    }
}
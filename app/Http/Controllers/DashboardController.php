<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index()
    {
        return Inertia::render('Dashboard/Admin', []);
    }

    public function feedback()
    {
        return Inertia::render('Feedback/Index', []);
    }

    public function warranty()
    {
        return Inertia::render('Warranty/Index', []);
    }

    public function warranty_dashboard()
    {
        return Inertia::render('WarrantyDashboard/Index', []);
    }
}

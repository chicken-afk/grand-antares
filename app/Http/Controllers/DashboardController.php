<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * Index Dashboard Page
     *
     * @return void
     */
    public function index()
    {
        $row = $this->dashboardRepository->index();
        return view('main.dashboard', compact('row'));
    }
}

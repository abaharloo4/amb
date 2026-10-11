<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Post;
use App\Models\Inquiry;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects_count' => Project::count(),
            'posts_count' => Post::count(),
            'inquiries_new' => Inquiry::where('status', 'new')->count(),
            'appointments_count' => Appointment::count(),
            'users_count' => User::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentProjects = Project::with('translations')->latest()->take(4)->get();
        $recentAppointments = Appointment::latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentProjects', 'recentAppointments'));
    }
}

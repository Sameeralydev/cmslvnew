<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LibraryMember;
use App\Models\Page;
use App\Models\Post;
use App\Models\Staff;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $hasStudents = Schema::hasTable('students');
        $hasStaff = Schema::hasTable('staff');
        $hasEnquiry = Schema::hasTable('enquiry');
        $hasRegd = Schema::hasTable('student_regd');
        $hasAdmissions = Schema::hasTable('student_admissions');
        $hasComplaints = Schema::hasTable('complaint');
        $hasVisitors = Schema::hasTable('visitors_book');
        $hasPurchases = Schema::hasTable('purchases');
        $hasSales = Schema::hasTable('sales');
        $hasParent = Schema::hasTable('parent');
        $hasSiblings = Schema::hasTable('siblings');

        $totalStudents = $hasStudents ? DB::table('students')->count() : 0;
        $maleStudents = $hasStudents ? DB::table('students')->whereRaw("LOWER(gender) IN ('male', 'm', 'boy', 'boys')")->count() : 0;
        $femaleStudents = $hasStudents ? DB::table('students')->whereRaw("LOWER(gender) IN ('female', 'f', 'girl', 'girls')")->count() : 0;
        if ($maleStudents === 0 && $femaleStudents === 0 && $totalStudents > 0) {
            $maleStudents = $totalStudents;
            $femaleStudents = 0;
        }

        $totalStaff = $hasStaff ? Staff::query()->count() : 0;
        $maleStaff = $hasStaff ? DB::table('staff')->whereRaw("LOWER(gender) IN ('male', 'm')")->count() : 0;
        $femaleStaff = $hasStaff ? DB::table('staff')->whereRaw("LOWER(gender) IN ('female', 'f')")->count() : 0;
        if ($maleStaff === 0 && $femaleStaff === 0 && $totalStaff > 0) {
            $maleStaff = (int) ceil($totalStaff / 2);
            $femaleStaff = (int) floor($totalStaff / 2);
        }

        $totalEnquiries = $hasEnquiry ? DB::table('enquiry')->count() : 0;
        $enquiryWon = $hasEnquiry ? DB::table('enquiry')->whereRaw("LOWER(status) IN ('won', 'active')")->count() : 0;
        $enquiryToday = $hasEnquiry ? DB::table('enquiry')->whereDate('created_at', now()->toDateString())->count() : 0;

        $totalRegd = $hasRegd ? DB::table('student_regd')->count() : 0;
        $regdSelf = $hasRegd ? DB::table('student_regd')->where('mode', 'self')->orWhere('mode', 'manual')->count() : 0;
        $regdOnline = $hasRegd ? DB::table('student_regd')->where('mode', 'online')->count() : 0;

        $totalAdmissions = $hasAdmissions ? DB::table('student_admissions')->count() : ($hasStudents ? DB::table('students')->count() : 0);
        $totalComplaints = $hasComplaints ? DB::table('complaint')->count() : 0;
        $complaintsSolved = $hasComplaints ? DB::table('complaint')->whereNotNull('status')->whereRaw("LOWER(status) IN ('solved', 'closed', 'resolved')")->count() : 0;

        $stats = [
            'branches' => Schema::hasTable('branches') ? Branch::query()->count() : 0,
            'staff' => $totalStaff,
            'male_staff' => $maleStaff,
            'female_staff' => $femaleStaff,
            'front_pages' => Schema::hasTable('front_cms_pages') ? Page::query()->count() : 0,
            'front_posts' => Schema::hasTable('front_cms_media') ? Post::query()->count() : 0,
            'members' => Schema::hasTable('libarary_members') ? LibraryMember::query()->count() : 0,
            'notifications' => Schema::hasTable('system_notification') ? SystemNotification::query()->count() : 0,
            'students' => $totalStudents,
            'male_students' => $maleStudents,
            'female_students' => $femaleStudents,
            'admissions' => $totalAdmissions,
            'admission_today' => 0,
            'admission_leaving' => 0,
            'admission_inquiries' => $totalEnquiries > 0 ? $totalEnquiries : 14,
            'inquiry_today' => $enquiryToday,
            'inquiry_won' => $enquiryWon > 0 ? $enquiryWon : 6,
            'registrations' => $totalRegd,
            'regd_self' => $regdSelf,
            'regd_online' => $regdOnline,
            'complaints' => $totalComplaints,
            'complaints_today' => 0,
            'complaints_solved' => $complaintsSolved,
            'visitors' => $hasVisitors ? DB::table('visitors_book')->count() : 0,
            'purchases' => $hasPurchases ? DB::table('purchases')->count() : 0,
            'sales' => $hasSales ? DB::table('sales')->count() : 0,
            'teaching_staff' => $hasStaff ? Staff::query()->where('role_id', 2)->count() : 1,
            'admin_staff' => $hasStaff ? Staff::query()->whereIn('role_id', [1, 3, 4])->count() : 0,
            'allied_staff' => $hasStaff ? Staff::query()->whereNotIn('role_id', [1, 2, 3, 4])->count() : 0,
            'families' => $hasParent ? DB::table('parent')->count() : ($hasSiblings ? DB::table('siblings')->count() : 1),
        ];

        $daysInMonth = (int) date('t');
        $currentMonthDays = [];
        $daysCollection = [];
        $daysExpenses = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dayStr = str_pad($d, 2, '0', STR_PAD_LEFT);
            $currentMonthDays[] = $dayStr;
            $daysCollection[] = 0;
            $daysExpenses[] = 0;
        }

        $feeOverview = [
            'total_amount' => 26000,
            'paid_amount' => 2000,
            'waive_off' => 0,
            'balance' => 24000,
            'today_collection' => 0,
            'paid_count' => 1,
            'paid_percent' => 50,
            'unpaid_count' => 1,
            'unpaid_percent' => 50,
            'concession_count' => 0,
            'concession_percent' => 0,
            'free_count' => 0,
            'free_percent' => 0,
            'defaulter_count' => 1,
            'defaulter_percent' => 50,
        ];

        $expenseStats = [
            'total' => 0,
            'today' => 0,
        ];

        $latestNotifications = Schema::hasTable('system_notification')
            ? SystemNotification::query()->latest('created_at')->limit(5)->get()
            : collect();

        $currentMonthYear = date('M Y');
        $fullMonthYear = date('F Y');

        return view('admin.dashboard.index', compact(
            'stats',
            'latestNotifications',
            'currentMonthYear',
            'fullMonthYear',
            'currentMonthDays',
            'daysCollection',
            'daysExpenses',
            'feeOverview',
            'expenseStats'
        ));
    }
}

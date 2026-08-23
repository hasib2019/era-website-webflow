<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CaseStudy;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $tiles = [
            ['label' => 'Pages', 'value' => Page::count(), 'route' => 'admin.pages.index', 'permission' => 'pages.view', 'icon' => 'document'],
            ['label' => 'Services', 'value' => Service::count(), 'route' => 'admin.services.index', 'permission' => 'services.manage', 'icon' => 'sparkles'],
            ['label' => 'Case studies', 'value' => CaseStudy::count(), 'route' => 'admin.case-studies.index', 'permission' => 'case-studies.manage', 'icon' => 'briefcase'],
            ['label' => 'Blog posts', 'value' => Post::count(), 'route' => 'admin.posts.index', 'permission' => 'posts.manage', 'icon' => 'newspaper'],
            ['label' => 'Media files', 'value' => Media::count(), 'route' => 'admin.media.index', 'permission' => 'media.view', 'icon' => 'photo'],
            ['label' => 'New messages', 'value' => ContactMessage::where('status', 'new')->count(), 'route' => 'admin.messages.index', 'permission' => 'messages.view', 'icon' => 'envelope'],
            ['label' => 'Applications', 'value' => JobApplication::count(), 'route' => 'admin.applications.index', 'permission' => 'applications.view', 'icon' => 'document'],
            ['label' => 'Subscribers', 'value' => Subscriber::where('is_active', true)->count(), 'route' => 'admin.subscribers.index', 'permission' => 'subscribers.view', 'icon' => 'at'],
        ];

        return view('admin.dashboard', [
            'tiles' => array_values(array_filter($tiles, fn ($t) => $user->hasPermission($t['permission']))),
            'recentMessages' => $user->hasPermission('messages.view')
                ? ContactMessage::latest()->take(5)->get()
                : collect(),
            'recentActivity' => $user->hasPermission('activity.view')
                ? ActivityLog::with('user')->latest()->take(8)->get()
                : collect(),
            'pages' => $user->hasPermission('pages.view')
                ? Page::orderBy('sort_order')->take(8)->get()
                : collect(),
        ]);
    }
}

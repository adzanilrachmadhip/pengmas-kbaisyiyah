<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\DevelopmentAspect;
use App\Models\Facility;
use App\Models\Feature;
use App\Models\GalleryCategory;
use App\Models\MissionPoint;
use App\Models\Photo;
use App\Models\SectionContent;
use App\Models\SiteSetting;
use App\Models\StaffMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /** Public-facing pages currently live on the site. */
    private const ACTIVE_PAGES = 7; // Home, About, Struktur Organisasi, SDM, Gallery, Artikel, Contact

    public function index(): View
    {
        $lastUpdated = collect([
            SectionContent::query()->max('updated_at'),
            Feature::query()->max('updated_at'),
            MissionPoint::query()->max('updated_at'),
            DevelopmentAspect::query()->max('updated_at'),
            Facility::query()->max('updated_at'),
            StaffMember::query()->max('updated_at'),
            GalleryCategory::query()->max('updated_at'),
            Photo::query()->max('updated_at'),
            Article::query()->max('updated_at'),
            SiteSetting::current()->updated_at,
        ])->filter()->max();

        return view('admin.dashboard', [
            'admin' => Auth::user(),
            'messages' => ContactMessage::query()->latest()->get(),
            'stats' => [
                'active_pages' => self::ACTIVE_PAGES,
                'gallery_photos' => Photo::query()->count(),
                'unread_messages' => ContactMessage::query()->unread()->count(),
                'last_updated' => $lastUpdated,
            ],
        ]);
    }
}

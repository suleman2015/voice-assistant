<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Events\Models\Event;
use Modules\PageBuilder\Models\Page;

class WebController extends Controller
{
    public function index()
    {
        // Site-wide defaults
        SEOMeta::setTitle(setting('site_name'));
        SEOMeta::setDescription(setting('site_description'));
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword(setting('seo_meta_keywords'));

        OpenGraph::setTitle(setting('site_name'))
            ->setDescription(setting('site_description'))
            ->setUrl(url()->current())
            ->addImage(setting_image_url('og_image'));

        TwitterCard::setTitle(setting('site_name'))
            ->setDescription(setting('site_description'))
            ->setImage(setting_image_url('twitter_image') ?: setting_image_url('og_image'));

        JsonLd::setTitle(setting('site_name'));
        JsonLd::setDescription(setting('site_description'));
        JsonLd::addImage(setting_image_url('og_image'));

        if (setting('seo_schema')) {
            JsonLd::addValues(json_decode(setting('seo_schema'), true) ?? []);
        }


        return view('frontend.index');
    }

    public function categoryPage($slug)
    {
        $category = Category::with([
            'posts' => fn($q) => $q->where('status', 'published')->orderBy('id', 'desc')->get(),
            'childrenRecursive' => fn($q) => $q->where('status', 'published')->orderBy('order', 'asc'),
            'childrenRecursive.posts' => fn($q) => $q->where('status', 'published')->orderBy('id', 'desc')->get(),
            'seoMeta'
        ])
            ->where('status', 'published')
            ->where('slug', $slug)
            ->orderBy('order', 'asc')
            ->firstOrFail();

        $seoData        = $category->seoMeta->seo_data ?? [];
        $seoTitle       = $seoData['seo_title'] ?? $category->name ?? setting('site_name');
        $seoDescription = $seoData['seo_description'] ?? $category->description ?? setting('site_description');
        $seoKeywords    = $this->normalizeKeywords($seoData['meta_keywords'] ?? null, setting('seo_meta_keywords'));

        // Priority: seo_image -> category image -> site default
        $ogImage = $this->pickSeoFirstImage(
            $seoData,
            $category->image,
            setting_image_url('og_image')
        );

        SEOMeta::setTitle($seoTitle);
        SEOMeta::setDescription($seoDescription);
        SEOMeta::setCanonical(url()->current());
        if (!empty($seoKeywords)) {
            SEOMeta::addKeyword($seoKeywords);
        }

        OpenGraph::setTitle($seoTitle)
            ->setDescription($seoDescription)
            ->setUrl(url()->current())
            ->addImage($ogImage);

        TwitterCard::setTitle($seoTitle)
            ->setDescription($seoDescription)
            ->setImage($ogImage);

        JsonLd::setTitle($seoTitle);
        JsonLd::setDescription($seoDescription);
        JsonLd::addImage($ogImage);

        if (!empty($seoData['schema']) && is_array($seoData['schema'])) {
            JsonLd::addValues($seoData['schema']);
        }

        return view('frontend.category', compact('category'));
    }

    public function postPage($slug)
    {
        $post = Post::with(['seoMeta', 'categories', 'tags'])->where('slug', $slug)->firstOrFail();

        $seoData        = $post->seoMeta->seo_data ?? [];
        $seoTitle       = $seoData['seo_title'] ?? $post->name ?? setting('site_name');
        $seoDescription = $seoData['seo_description'] ?? $post->description ?? setting('site_description');
        $seoKeywords    = $this->normalizeKeywords($seoData['meta_keywords'] ?? null, setting('seo_meta_keywords'));

        // Priority: seo_image -> post image -> site default
        $ogImage = $this->pickSeoFirstImage(
            $seoData,
            $post->image,
            setting_image_url('og_image')
        );

        SEOMeta::setTitle($seoTitle);
        SEOMeta::setDescription($seoDescription);
        SEOMeta::setCanonical(url()->current());
        if (!empty($seoKeywords)) {
            SEOMeta::addKeyword($seoKeywords);
        }

        OpenGraph::setTitle($seoTitle)
            ->setDescription($seoDescription)
            ->setUrl(url()->current())
            ->addProperty('type', 'article')
            ->addImage($ogImage);

        TwitterCard::setTitle($seoTitle)
            ->setDescription($seoDescription)
            ->setImage($ogImage);

        JsonLd::setType('Article');
        JsonLd::setTitle($seoTitle);
        JsonLd::setDescription($seoDescription);
        JsonLd::addImage($ogImage);

        if ($post->author_name) {
            JsonLd::addValue('author', $post->author_name);
        }
        JsonLd::addValue('datePublished', optional($post->created_at)->toDateString());
        JsonLd::addValue('mainEntityOfPage', url()->current());

        if (!empty($seoData['schema']) && is_array($seoData['schema'])) {
            JsonLd::addValues($seoData['schema']);
        }

        return view('frontend.blog-details', compact('post'));
    }

    public function contact()
    {
        $page = Page::with('seoMeta')->where('slug', 'contact-us')->first();
        if (!$page) abort(404, 'Contact page not found.');
        $this->applySeoFromPage(
            $page,
            'Contact Us | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );
        return view('frontend.contact', compact('page'));
    }

    public function rohitGosainMd()
    {
        $page = Page::with('seoMeta')->where('slug', 'rohit-gosain-md')->first();
        if (!$page) abort(404, 'Rohit gosain page not found.');
        $this->applySeoFromPage(
            $page,
            'Rohit Gosain | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );
        return view('frontend.dr-rohit', compact('page'));
    }

    public function rahulGosainMd()
    {
        $page = Page::with('seoMeta')->where('slug', 'rahul-gosain-md')->first();
        if (!$page) abort(404, 'Rahul gosain page not found.');
        $this->applySeoFromPage(
            $page,
            ' Rahul Gosain | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );
        return view('frontend.dr-rahul', compact('page'));
    }

    public function cookiePolicy()
    {
        $page = Page::with('seoMeta')->where('slug', 'cookie-policy')->first();
        if (!$page) abort(404, 'Contact page not found.');
        $this->applySeoFromPage(
            $page,
            'Cookie Policy | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );
        return view('frontend.cookie-policy', compact('page'));
    }

    public function upcomingEvents()
    {
        $page = Page::with('seoMeta')->where('slug', 'upcoming-events')->first();
        $this->applySeoFromPage(
            $page,
            'Upcoming Events | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );

        $today = now();

        $upcomingEvents = Event::with([
            'images:id,event_id,image_url',
            'eventDates:id,event_id,date'
        ])
            ->where(function ($query) use ($today) {
                $query
                    ->whereHas('eventDates', function ($subQuery) use ($today) {
                        $subQuery->whereDate('date', '>=', $today);
                    })
                    ->orWhereDate('event_date', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.live-events.upcoming-events', compact('upcomingEvents', 'page'));
    }

    public function privacyPolicy()
    {
        $page = Page::with('seoMeta')->where('slug', 'privacy-policy')->first();
        $this->applySeoFromPage(
            $page,
            'Privacy Policy | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );

        return view('frontend.privacy-policy', compact('page'));
    }

    public function termsAndConditions()
    {
        $page = Page::with('seoMeta')->where('slug', 'terms-and-conditions')->first();
        $this->applySeoFromPage(
            $page,
            'Terms and Conditions | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );

        return view('frontend.terms-and-conditions', compact('page'));
    }

    public function liveEvents()
    {
        $page = Page::with('seoMeta')->where('slug', 'live-events')->first();
        $this->applySeoFromPage(
            $page,
            'Live Events | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );

        $today = now();

        $upcomingEvents = Event::with([
            'images:id,event_id,image_url',
            'eventDates:id,event_id,date'
        ])
            ->where(function ($query) use ($today) {
                $query
                    ->whereHas('eventDates', function ($subQuery) use ($today) {
                        $subQuery->whereDate('date', '>=', $today);
                    })
                    ->orWhereDate('event_date', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $pastEvents = Event::with([
            'images:id,event_id,image_url',
            'eventDates:id,event_id,date'
        ])
            ->where(function ($query) use ($today) {
                $query
                    ->whereHas('eventDates', function ($subQuery) use ($today) {
                        $subQuery->whereDate('date', '<', $today);
                    })
                    ->orWhereDate('event_date', '<', $today);
            })
            ->orderBy('event_date', 'desc')
            ->get();

        return view('frontend.live-events.index', compact('upcomingEvents', 'pastEvents', 'page'));
    }

    public function userCases()
    {
        $page = Page::with('seoMeta')->where('slug', 'user-cases')->first();
        if (!$page) abort(404, 'User Cases page not found.');

        $this->applySeoFromPage(
            $page,
            'User Cases | ' . setting('site_name'),
            setting('site_description'),
            setting_image_url('og_image')
        );

        return view('frontend.user-cases', compact('page'));
    }

    /* ===========================
     | Helpers (SEO + Keywords)
     =========================== */

    /**
     * Normalize keywords from array / JSON / CSV into a flat array.
     */
    private function normalizeKeywords($raw, $fallbackCsv = null): array
    {
        $out = [];

        if (!empty($raw)) {
            if (is_array($raw)) {
                foreach ($raw as $kw) {
                    $out[] = is_array($kw) && isset($kw['value']) ? trim($kw['value']) : trim((string)$kw);
                }
            } else {
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    foreach ($decoded as $kw) {
                        $out[] = is_array($kw) && isset($kw['value']) ? trim($kw['value']) : trim((string)$kw);
                    }
                } else {
                    $out = array_map('trim', explode(',', (string)$raw));
                }
            }
        } elseif (!empty($fallbackCsv)) {
            $out = array_map('trim', explode(',', $fallbackCsv));
        }

        return array_values(array_filter($out, fn($v) => $v !== ''));
    }

    /**
     * Pick image by priority: SEO image first, then primary, then fallback.
     * Returns an absolute URL.
     */
    private function pickSeoFirstImage(array $seoData, $primaryPath = null, $fallback = null): ?string
    {
        $seoPath = $seoData['seo_image'] ?? null;

        // Prefer SEO image
        if ($url = $this->absoluteImageUrl($seoPath)) {
            return $url;
        }

        // Else primary (e.g., post/category image)
        if ($url = $this->absoluteImageUrl($primaryPath)) {
            return $url;
        }

        // Else fallback (site default)
        return $this->absoluteImageUrl($fallback) ?: setting_image_url('og_image');
    }

    /**
     * Convert relative path into absolute URL, keep http(s) as-is.
     */
    private function absoluteImageUrl(?string $path): ?string
    {
        if (!$path) return null;
        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }
        return asset($path);
    }

    /**
     * Apply SEO from a Page model (SEO-first image priority).
     */
    private function applySeoFromPage(?Page $page, string $fallbackTitle, string $fallbackDescription, ?string $fallbackImage = null): void
    {
        $seoData = $page?->seoMeta?->seo_data ?? [];

        $title = $seoData['seo_title'] ?? $page?->title ?? $fallbackTitle;
        $desc  = $seoData['seo_description'] ?? $fallbackDescription;
        $keys  = $this->normalizeKeywords($seoData['meta_keywords'] ?? null, setting('seo_meta_keywords'));

        // Priority: page seo_image -> fallback image
        $image = $this->pickSeoFirstImage($seoData, null, $fallbackImage);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($desc);
        SEOMeta::setCanonical(url()->current());
        if (!empty($keys)) {
            SEOMeta::addKeyword($keys);
        }

        OpenGraph::setTitle($title)
            ->setDescription($desc)
            ->setUrl(url()->current())
            ->addImage($image);

        TwitterCard::setTitle($title)
            ->setDescription($desc)
            ->setImage($image);

        JsonLd::setTitle($title);
        JsonLd::setDescription($desc);
        JsonLd::addImage($image);

        if (!empty($seoData['schema']) && is_array($seoData['schema'])) {
            JsonLd::addValues($seoData['schema']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Blog\Models\Post; // Make sure this points to your new Post model
use Modules\Blog\Models\Category; // Make sure this points to your new Category model
use Modules\Blog\Models\Tag;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Enable two-factor authentication for the user.
     */
    public function enableTwoFactor(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->google2fa_enabled) {
            return Redirect::route('profile.edit')->with('status', 'two-factor-already-enabled');
        }

        $google2fa = app(Google2FA::class);
        $secretKey = $google2fa->generateSecretKey(32);

        $user->forceFill([
            'google2fa_secret' => $secretKey,
            'google2fa_enabled' => true,
        ])->save();

        $otpauthUri = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secretKey
        );

        return Redirect::route('profile.edit')->with([
            'status' => 'two-factor-enabled',
            'two_factor_secret' => $secretKey,
            'two_factor_qr' => $this->generateInlineQrCode($otpauthUri),
        ]);
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disableTwoFactor(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->google2fa_enabled) {
            return Redirect::route('profile.edit')->with('status', 'two-factor-not-enabled');
        }

        $user->forceFill([
            'google2fa_secret' => null,
            'google2fa_enabled' => false,
        ])->save();

        return Redirect::route('profile.edit')->with('status', 'two-factor-disabled');
    }

    /**
     * Create a base64 inline QR code for the given otpauth string.
     */
    protected function generateInlineQrCode(string $otpauthUri): string
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale' => 5,
            'eccLevel' => QRCode::ECC_L,
            'imageBase64' => true,
        ]);

        $qrCode = new QRCode($options);

        return $qrCode->render($otpauthUri);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // public function importPost()
    // {
    //     $oldPosts = DB::connection('oncbrothers_admin')->table('posts')->get();

    //     foreach ($oldPosts as $oldPost) {
    //         foreach ($oldPosts as $oldPost) {
    //             // Get categories of this post
    //             // Get old category IDs linked to this post
    //             $oldCategoryIds = DB::connection('oncbrothers_admin')
    //                 ->table('post_categories')
    //                 ->where('post_id', $oldPost->id)
    //                 ->pluck('category_id');

    //             // Now find new category IDs by slug in your NEW database
    //             $oldCategorySlugs = DB::connection('oncbrothers_admin')->table('slugs')
    //                 ->where('reference_type', 'Botble\\Blog\\Models\\Category') // <-- new namespace
    //                 ->whereIn('reference_id', $oldCategoryIds) 
    //                 ->pluck('key');

    //             $oldpostSlug = DB::connection('oncbrothers_admin')->table('slugs')
    //                 ->where('reference_type', 'Botble\\Blog\\Models\\Post') // <-- new namespace
    //                 ->where('reference_id', $oldPost->id) 
    //                 ->pluck('key')->first();
    //             $oldseoData = DB::connection('oncbrothers_admin')->table('meta_boxes')
    //                 ->where('reference_type', 'Botble\\Blog\\Models\\Post') // <-- new namespace
    //                 ->where('reference_id', $oldPost->id) 
    //                 ->where('meta_key', 'seo_meta') 
    //                 ->pluck('meta_value')->first();
    //            $newCategoiresID = Category::whereIn('slug', $oldCategorySlugs)->pluck('id')->toArray();
    //             dd([
    //                 'post' => $oldPost,
    //                 'oldCategoryIds' => $oldCategoryIds,
    //                 'oldCategorySlugs' => $oldCategorySlugs,
    //                 'oldpostSlug' => $oldpostSlug,
    //                 'categorties' => $newCategoiresID,
    //                 'oldseoData' => $oldseoData,
    //             ]);

    //         Post::updateOrCreate(
    //             ['slug' => Str::slug($oldPost->name ?? 'untitled')],
    //             [
    //                 'name' => $oldPost->name ?? 'Untitled',
    //                 'slug' => $oldpostSlug ?? Str::slug($oldPost->name ?? 'untitled') . '-' . Str::random(5),
    //                 'type' => $oldPost->type ?? 'blog',
    //                 'description' => $oldPost->description ?? '',
    //                 'content' => $oldPost->content ?? '',
    //                 'status' => $oldPost->status ?? 'draft',
    //                 'author_id' => $oldPost->author_id ?? 1,
    //                 'author_name' => $oldPost->author_name ?? null,
    //                 'is_featured' => $oldPost->is_featured ?? 0,
    //                 'is_trending_onc_update' => $oldPost->is_trending_onc_update ?? 0,
    //                 'image' => $oldPost->image ?? null,
    //                 'dr_image' => $oldPost->dr_image ?? null,
    //                 'dr_name' => $oldPost->dr_name ?? null,
    //                 'apple_link' => $oldPost->apple_link ?? null,
    //                 'spotify_link' => $oldPost->spotify_link ?? null,
    //                 'yt_link' => $oldPost->yt_link ?? null,
    //                 'key_points' => $oldPost->key_points
    //                     ? collect(json_decode($oldPost->key_points, true))
    //                     ->pluck('description')
    //                     ->filter()
    //                     ->values()
    //                     ->toArray()
    //                     : [],
    //                 'created_at' => $oldPost->created_at ?? now(),
    //                 'updated_at' => $oldPost->updated_at ?? now(),
    //             ]
    //         );
    //     }
    // }

    //     return response()->json([
    //         'message' => 'Posts imported successfully!',
    //         'total' => $oldPosts->count()
    //     ]);
    // }
    public function importTags()
    {
        $oldTags = DB::connection('oncbrothers_admin')->table('tags')->get();

        foreach ($oldTags as $oldTag) {
            Tag::updateOrCreate(
                ['name' => $oldTag->name ?? 'Untitled'],
                [
                    'name'        => $oldTag->name ?? 'Untitled',
                    'description' => $oldTag->description ?? '',
                    'status'      => $oldTag->status ?? 'draft',
                    'created_at'  => $oldTag->created_at ?? now(),
                    'updated_at'  => $oldTag->updated_at ?? now(),
                ]
            );
        }

        return response()->json([
            'message' => 'Tags imported successfully!',
            'total'   => $oldTags->count()
        ]);
    }
    public function importPost()
    {
        $oldPosts = DB::connection('oncbrothers_admin')->table('posts')->get();

        foreach ($oldPosts as $oldPost) {
            // 1. Get old category IDs
            $oldCategoryIds = DB::connection('oncbrothers_admin')
                ->table('post_categories')
                ->where('post_id', $oldPost->id)
                ->pluck('category_id');
            $oldTagIds = DB::connection('oncbrothers_admin')
                ->table('post_tags')
                ->where('post_id', $oldPost->id)
                ->pluck('tag_id');
            $oldTags = DB::connection('oncbrothers_admin')
                ->table('tags')
                ->whereIn('id',$oldTagIds)->pluck('name')->toArray();
            $oldKeywordIds = DB::connection('oncbrothers_admin')
                ->table('post_keywords')
                ->where('post_id', $oldPost->id)
                ->pluck('tag_id');
            $oldKeywords = DB::connection('oncbrothers_admin')
                ->table('tags')
                ->whereIn('id',$oldKeywordIds)->pluck('name')->toArray();

            // 2. Get old category slugs
            $oldCategorySlugs = DB::connection('oncbrothers_admin')
                ->table('slugs')
                ->where('reference_type', 'Botble\\Blog\\Models\\Category')
                ->whereIn('reference_id', $oldCategoryIds)
                ->pluck('key');

            // 3. Get old post slug
            $oldpostSlug = DB::connection('oncbrothers_admin')
                ->table('slugs')
                ->where('reference_type', 'Botble\\Blog\\Models\\Post')
                ->where('reference_id', $oldPost->id)
                ->pluck('key')
                ->first();

            // 4. Get old SEO data
            $oldseoData = DB::connection('oncbrothers_admin')
                ->table('meta_boxes')
                ->where('reference_type', 'Botble\\Blog\\Models\\Post')
                ->where('reference_id', $oldPost->id)
                ->where('meta_key', 'seo_meta')
                ->pluck('meta_value')
                ->first();

            // 5. Map old categories to new IDs
            $newCategoryIds = Category::whereIn('slug', $oldCategorySlugs)->pluck('id')->toArray();
            $newTagsIds = Tag::whereIn('name', $oldTags)->pluck('id')->toArray();
            $newkeyworIds = Tag::whereIn('name', $oldKeywords)->pluck('id')->toArray();
            // dd($newCategoryIds,$oldTagIds,$oldTags,$newTagsIds,$oldKeywordIds,$oldKeywords,$newkeyworIds);

            // 6. Create / update Post in new DB
            $post = Post::updateOrCreate(
                ['slug' => $oldpostSlug ?? Str::slug($oldPost->name ?? 'untitled')],
                [
                    'name' => $oldPost->name ?? 'Untitled',
                    'slug' => $oldpostSlug ?? Str::slug($oldPost->name ?? 'untitled') . '-' . Str::random(5),
                    'type' => $oldPost->type ?? 'blog',
                    'description' => $oldPost->description ?? '',
                    'content' => $oldPost->content ?? '',
                    'status' => $oldPost->status ?? 'draft',
                    'author_id' => $oldPost->author_id ?? 1,
                    'author_name' => $oldPost->author_name ?? null,
                    'is_featured' => $oldPost->is_featured ?? 0,
                    'is_trending_onc_update' => $oldPost->is_trending_onc_update ?? 0,
                    'image' => $oldPost->image ?? null,
                    'dr_image' => $oldPost->dr_image ?? null,
                    'dr_name' => $oldPost->dr_name ?? null,
                    'apple_link' => $oldPost->apple_link ?? null,
                    'spotify_link' => $oldPost->spotify_link ?? null,
                    'yt_link' => $oldPost->yt_link ?? null,
                    'key_points' => $oldPost->key_points
                        ? collect(json_decode($oldPost->key_points, true))
                        ->pluck('description')
                        ->filter()
                        ->values()
                        ->toArray()
                        : [],
                    'created_at' => $oldPost->created_at ?? now(),
                    'updated_at' => $oldPost->updated_at ?? now(),
                ]
            );

            // 7. Attach categories
            if (!empty($newCategoryIds)) {
                $post->categories()->sync($newCategoryIds);
            }
            if (!empty($newTagsIds)) {
                $post->tags()->sync($newTagsIds);
            }
            if (!empty($newkeyworIds)) {
                $post->keywords()->sync($newkeyworIds);
            }

            // 8. Insert SEO data if available
            if ($oldseoData) {
                $decodedSeo = json_decode($oldseoData, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSeo)) {
                    $seo = $decodedSeo[0] ?? $decodedSeo;

                    // Normalize to new structure
                    $seoFields = [
                        'seo_title'       => $seo['seo_title'] ?? $oldPost->name ?? null,
                        'seo_description' => $seo['seo_description'] ?? null,
                        'meta_keywords'   => !empty($seo['meta_keywords'])
                            ? (is_array($seo['meta_keywords'])
                                ? $seo['meta_keywords']
                                : (array) $seo['meta_keywords'])
                            : [],
                        'schema'          => $seo['schema'] ?? null,
                    ];

                    $post->setSeoData($seoFields);
                }
            }
        }

        return response()->json([
            'message' => 'Posts imported successfully!',
            'total'   => $oldPosts->count()
        ]);
    }

    public function importCategorySeoData()
    {
        $oldCategories = DB::connection('oncbrothers_admin')->table('categories')->get();

        foreach ($oldCategories as $oldCategory) {
             $oldcategoryslug = DB::connection('oncbrothers_admin')
                ->table('slugs')
                ->where('reference_type', 'Botble\\Blog\\Models\\Category')
                ->where('reference_id', $oldCategory->id)
                ->pluck('key')
                ->first();

            $oldseoData = DB::connection('oncbrothers_admin')->table('meta_boxes')
                ->where('reference_type', 'Botble\\Blog\\Models\\Category')
                ->where('reference_id', $oldCategory->id)
                ->where('meta_key', 'seo_meta')
                ->pluck('meta_value')
                ->first();
                
                if ($oldseoData) {
                    $decodedSeo = json_decode($oldseoData, true);
                    

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSeo)) {
                    $seo = $decodedSeo[0] ?? $decodedSeo;

                    // Normalize to new structure
                    $seoFields = [
                        'seo_title'       => $seo['seo_title'] ?? $oldCategory->name ?? null,
                        'seo_description' => $seo['seo_description'] ?? null,
                        'meta_keywords'   => !empty($seo['meta_keywords'])
                            ? (is_array($seo['meta_keywords'])
                                ? $seo['meta_keywords']
                                : (array) $seo['meta_keywords'])
                            : [],
                        'schema'          => $seo['schema'] ?? null,
                    ];
                    // dd($oldCategory,$oldseoData,$oldcategoryslug,$decodedSeo,$seo,$seoFields);

                    // Find the category in the new database by slug
                    $newCategory = Category::where('slug', $oldcategoryslug)->first();

                    if ($newCategory) {
                        $newCategory->setSeoData($seoFields);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Categories imported successfully!',
            'total'   => $oldCategories->count()
        ]);
    }
}

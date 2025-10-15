<?php

namespace Modules\UrlRedirector\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\UrlRedirector\Models\UrlRedirector;

class UrlRedirectorController extends Controller
{
    /**
     * Retrieve all URL redirects.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $urls = UrlRedirector::all()->map(function ($url) {
                return [
                    'id'           => $url->id,
                    'original_url' => $url->original_url,
                    'target_url'   => $url->target_url,
                    'is_active'    => $url->is_active,
                    'expires_at'   => $url->expires_at,
                    'visits'       => $url->visits,
                    'created_at'   => $url->created_at,
                    'updated_at'   => $url->updated_at,
                ];
            });

            if ($urls->isEmpty()) {
                return response()->json([
                    'error'   => true,
                    'data'    => [],
                    'message' => 'No URL redirects found.',
                ], 404);
            }

            return response()->json([
                'error'   => false,
                'data'    => $urls,
                'message' => $urls->count() . ' URLs redirect retrieved successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => true,
                'data'    => [],
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}

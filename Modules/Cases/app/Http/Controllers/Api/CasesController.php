<?php

namespace Modules\Cases\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Cases\Http\Requests\StoreCaseRequest;
use Modules\Cases\Models\CaseImage;
use Illuminate\Support\Str;
use Modules\Cases\Models\UserCase;

class CasesController extends Controller
{
    public function store(StoreCaseRequest $request)
    {
        // ---- 0) Anti-bot (tolerant): works even if the form doesn't send these yet ----
        $hpField   = $request->input('_hp_website');      // should be empty if present
        $startedAt = (int) $request->input('_hp_time', 0); // unix timestamp set at render time (optional)
        $minSeconds = 3;

        // If honeypot is filled, or if a timestamp was provided and it's too quick, silently "succeed"
        if (filled($hpField) || ($startedAt > 0 && (now()->timestamp - $startedAt) < $minSeconds)) {
            usleep(300000); // small delay to reduce fingerprinting
            return response()->json([
                'status'  => true,
                'message' => 'Case(s) submitted successfully',
                'count'   => 0,
                'data'    => [],
            ], 201);
        }

        // ---- 1) Pull validated data (keeps your existing rules) ----
        $data = $request->validated();

        // ---- 2) Sanitizers (strip tags, trim, clamp length) ----
        $clean = function ($v, $max = 5000, $rmCRLF = false) {
            $s = Str::limit(trim(strip_tags((string)$v)), $max, '');
            return $rmCRLF ? preg_replace('/[\r\n]+/', ' ', $s) : $s;
        };

        // Respect anonymity globally for this payload
        $name = $request->boolean('is_anonymous') ? null : ($data['name'] ?? null);
        $name = $name ? $clean($name, 150, true) : null;

        // Normalize possible multi-case inputs (array or scalar)
        $specialities = $request->input('speciality', []);
        $contents     = $request->input('content', []);

        // Ensure arrays
        if (!is_array($specialities)) $specialities = [$specialities];
        if (!is_array($contents))     $contents     = [$contents];

        // ---- 3) Cap abuse: limit total rows per submit ----
        $maxCases = 20;
        if (count($specialities) > $maxCases || count($contents) > $maxCases) {
            $specialities = array_slice($specialities, 0, $maxCases);
            $contents     = array_slice($contents, 0, $maxCases);
        }

        DB::beginTransaction();

        try {
            $createdIds = [];

            // ---- 4) Multi-row path (if any arrays have >1 or at least one non-empty pair) ----
            $isMulti = (count($specialities) > 1) || (count($contents) > 1);

            if ($isMulti) {
                $count = max(count($specialities), count($contents));

                for ($i = 0; $i < $count; $i++) {
                    $specialtyRaw   = $specialities[$i] ?? null;
                    $descriptionRaw = $contents[$i] ?? null;

                    // Sanitize
                    $specialty   = $specialtyRaw   !== null ? $clean($specialtyRaw, 150, true) : null;
                    $description = $descriptionRaw !== null ? $clean($descriptionRaw, 5000)     : null;

                    // Skip empty rows
                    if (blank($specialty) && blank($description)) {
                        continue;
                    }

                    $case = UserCase::create([
                        'name'         => $name,
                        'is_anonymous' => $request->boolean('is_anonymous'),
                        'profession'   => $clean($data['profession'] ?? '', 150, true) ?: null,
                        'specialty'    => $specialty,
                        'case_date'    => $data['case_date'] ?? null,
                        'description'  => $description,
                        'terms_agreed' => $request->boolean('terms_agreed'),
                        'status'       => 'pending',
                    ]);

                    $createdIds[] = $case->id;
                }

                if (empty($createdIds)) {
                    throw new \RuntimeException('No valid cases provided.');
                }

                DB::commit();

                $created = UserCase::with('images')
                    ->whereIn('id', $createdIds)
                    ->latest('id')
                    ->get();

                return response()->json([
                    'status'  => true,
                    'message' => 'Case(s) submitted successfully',
                    'count'   => count($createdIds),
                    'data'    => $created,
                ], 201);
            }

            // ---- 5) Fallback single-row path (backward compatible) ----
            $case = UserCase::create([
                'name'         => $name,
                'is_anonymous' => $request->boolean('is_anonymous'),
                'profession'   => $clean($data['profession'] ?? '', 150, true) ?: null,
                'specialty'    => $clean($data['specialty']  ?? '', 150, true) ?: null,
                'case_date'    => $data['case_date'] ?? null,
                'description'  => $clean($data['description'] ?? '', 5000) ?: null,
                'terms_agreed' => $request->boolean('terms_agreed'),
                'status'       => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Case submitted successfully',
                'data'    => $case->load('images'),
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            // Return safe error payload for AJAX clients
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while saving the case.',
                'error'   => app()->hasDebugModeEnabled() && config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function index()
    {
        $cases = UserCase::with('images')->latest()->get();

        // Append full URLs
        $cases->each(function ($case) {
            $case->images->each(function ($image) {
                $image->full_url = url($image->file_path);
            });
        });

        return response()->json([
            'status' => true,
            'data'   => $cases,
        ]);
    }
}

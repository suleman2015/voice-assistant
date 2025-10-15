<?php

namespace Modules\Cases\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Cases\Models\UserCase;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CasesController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {
        $cases = UserCase::with('images');

        return DataTables::of($cases)
            ->addIndexColumn()
            ->addColumn('name', fn($case) => $case->name ?? '-')
            ->addColumn('specialty', fn($case) => $case->specialty)
            ->addColumn('profession', fn($case) => $case->profession)
            ->addColumn('status', function ($case) {
                return "<span class='badge bg-" . ($case->status === 'published' ? 'success' : ($case->status === 'draft' ? 'warning' : 'secondary')) . "'>" . ucfirst($case->status) . "</span>";
            })
            ->addColumn('created_at', fn($case) => $case->created_at ? $case->created_at->format('Y-m-d H:i') : '-')
            ->addColumn('updated_at', fn($case) => $case->updated_at ? $case->updated_at->format('Y-m-d H:i') : '-')
            ->addColumn('action', function ($case) {
                $editUrl = route('cases.edit', $case->id);
                $deleteUrl = route('cases.destroy', $case->id);
                return <<<HTML
                    <a href="{$editUrl}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{$case->id}" data-name="{$case->name}" data-delete-url="{$deleteUrl}"><i class="fas fa-trash"></i></button>
                HTML;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('cases::index');
}


    public function edit($id)
    {
        $case = UserCase::with('images')->findOrFail($id);

        return view('cases::detail', compact('case'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $case = UserCase::with('images')->findOrFail($id);

            foreach ($case->images as $image) {
                $filePath = public_path($image->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $image->delete();
            }

            $case->delete();

            DB::commit();

            return redirect()->route('cases.index')->with('success', __('Case deleted successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('An error occurred while deleting the case: ') . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $case = UserCase::findOrFail($id);
        $case->status = $request->status;
        $case->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}

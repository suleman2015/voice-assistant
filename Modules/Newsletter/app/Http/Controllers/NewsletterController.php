<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Models\Newsletter;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{
    /**
     * Display listing with DataTables.
     */
    public function index(Request $request)
    {
        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Newsletters', route('admin.newsletters.index'));
    
        if ($request->ajax()) {
            $query = Newsletter::query()->latest();
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = ucfirst($row->status);
                    $badgeClass = match (strtolower($row->status)) {
                        'subscribed' => 'bg-success',
                        'unsubscribed' => 'bg-warning',
                        default => 'bg-secondary',
                    };
                    return "<span class='badge {$badgeClass}'>{$status}</span>";
                })
                ->addColumn('action', function ($row) {
                    $email = e($row->email);
    
                    return <<<HTML
                        <button type="button"
                                class="btn btn-sm btn-danger deleteNewsletterBtn"
                                data-id="{$row->id}"
                                data-email="{$email}">
                            <i class="bi bi-trash3"></i>
                        </button>
                    HTML;
                })
                ->rawColumns(['status', 'action'])
                ->editColumn('email', fn($row) => e($row->email))
                ->editColumn('name', fn($row) => e($row->name))
                ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d'))
                ->make(true);
        }
    
        return view('newsletter::admin.index');
    }

    /**
     * Store a new subscription.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        Newsletter::create([
            'email' => $request->email,
            'name' => auth()->check() ? auth()->user()->name : null,
            'status' => 'subscribed',
        ]);

        return response()->json(['success' => true, 'message' => 'Subscribed successfully']);
    }

    /**
     * Delete a record.
     */
    public function destroy($id)
    {
        Newsletter::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }
}

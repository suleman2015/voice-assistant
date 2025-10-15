<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Models\Contact;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Contacts', route('contact.index'));

        if ($request->ajax()) {
            $data = Contact::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = ucfirst($row->status);
                    $badgeClass = match (strtolower($row->status)) {
                        'unread' => 'bg-secondary',
                        'read' => 'bg-info',
                        'replied' => 'bg-success',
                        default => 'bg-dark',
                    };
                    return "<span class='badge {$badgeClass}'>{$status}</span>";
                })
                ->addColumn('action', function ($row) {
                    $contactName = e($row->name);

                    return <<<HTML
                        <button type="button"
                                class="btn btn-sm btn-info showContactBtn"
                                data-id="{$row->id}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-danger deleteContactBtn"
                                data-id="{$row->id}"
                                data-name="{$contactName}">
                            <i class="bi bi-trash3"></i>
                        </button>
                    HTML;
                })
                ->rawColumns(['status', 'action'])
                ->editColumn('name', fn($row) => e($row->name))
                ->editColumn('email', fn($row) => e($row->email))
                ->editColumn('country', fn($row) => e($row->country))
                ->editColumn('city', fn($row) => e($row->city))
                ->make(true);
        }

        return view('contact::index');
    }
    public function store(ContactRequest $request)
    {
        // --- 1) Anti-bot honeypot & timing gate ---
        $honeypotFilled = filled($request->input('_hp_website')); // should remain empty
        $startedAt = (int) $request->input('_hp_time', 0);
        $minSeconds = 3; // minimum time a human would reasonably take
        $tooFast = now()->timestamp - $startedAt < $minSeconds;

        if ($honeypotFilled || $tooFast) {
            // Pretend success to not help bots fingerprint responses
            usleep(400000); // ~0.4s delay
            return back()->with('success', 'Thank you for your message!');
        }

        // --- 2) Pull validated data from your ContactRequest (keeps your current rules) ---
        $data = $request->validated();

        // --- 3) Basic sanitization + header-injection guards (no CRLF in headers) ---
        $stripTags = fn($v, $max = 5000) => Str::limit(trim(strip_tags((string) $v)), $max, '');
        $noCRLF    = fn($v) => preg_replace('/[\r\n]+/', ' ', (string) $v); // prevent header injection

        $safe = [
            'name'    => $noCRLF($stripTags($data['name']    ?? '', 150)),
            'email'   => $noCRLF($stripTags($data['email']   ?? '', 254)),
            'phone'   => $stripTags($data['phone']   ?? '', 40),
            'address' => $stripTags($data['address'] ?? '', 255),
            'subject' => $noCRLF($stripTags($data['subject'] ?? '', 150)),
            'content' => $stripTags($data['content'] ?? '', 5000),
        ];


        // --- 4) Create record using only sanitized fields (keeps your current UX) ---
        $contact = Contact::create($safe);

        // --- 5) Choose admin recipient with safe fallbacks ---
        $adminEmail = setting('contact_email')
            ?: setting('mail_from_address')
            ?: config('mail.from.address');

        // Defensive: validate admin and user email formats before using in headers
        $isValidEmail = fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL) !== false;

        try {
            Mail::send('contact::contact-email', [
                'name'    => $contact->name,
                'email'   => $contact->email,
                'phone'   => $contact->phone,
                'address' => $contact->address,
                'subject' => $contact->subject,
                'content' => $contact->content,
            ], function ($message) use ($adminEmail, $contact, $isValidEmail) {
                // Always use configured from, not user input
                $message->from(config('mail.from.address'), config('mail.from.name'));

                // Set recipient if valid
                if ($isValidEmail($adminEmail)) {
                    $message->to($adminEmail);
                }

                // Safe subject (no CRLF)
                $subject = 'New Contact Message: ' . ($contact->subject ?: 'Contact Form');
                $subject = preg_replace('/[\r\n]+/', ' ', $subject);
                $message->subject($subject);

                // Optional safe reply-to (only if user email is valid and clean)
                if ($isValidEmail($contact->email)) {
                    $message->replyTo($contact->email, Str::limit($contact->name ?? 'Contact User', 150, ''));
                }
            });
        } catch (\Throwable $e) {
            Log::warning('Contact email failed: ' . $e->getMessage(), [
                'route' => 'contact.submit',
                'ip' => $request->ip(),
            ]);
            // Continue without failing the UX
        }

        return redirect()->back()->with('success', 'Thank you for your message!');
    }


    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();

        return redirect()->route('contact.index')->with('success', 'Contact message deleted successfully.');
    }
}

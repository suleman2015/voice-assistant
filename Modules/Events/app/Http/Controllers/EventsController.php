<?php

namespace Modules\Events\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Events\Http\Requests\EventsRequest;
use Modules\Events\Models\Event;
use Modules\Events\Models\EventDate;
use Modules\Events\Models\EventImage;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {
        $events = Event::with(['images', 'eventDates']);

        return DataTables::of($events)
            ->addIndexColumn()
            ->addColumn('title', fn($event) => humanize_string($event->title))
            ->addColumn('slug', fn($event) => $event->slug)
            ->addColumn('event_date', function ($event) {
                return $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') : '-';
            })
            ->addColumn('status', function ($event) {
                return "<span class='badge bg-" . ($event->status === 'published' ? 'success' : ($event->status === 'draft' ? 'warning' : 'secondary')) . "'>" . ucfirst($event->status) . "</span>";
            })
            ->addColumn('created_at', fn($event) => $event->created_at ? $event->created_at->format('Y-m-d H:i') : '-')
            ->addColumn('updated_at', fn($event) => $event->updated_at ? $event->updated_at->format('Y-m-d H:i') : '-')
            ->addColumn('action', function ($event) {
                $editUrl = route('events.edit', $event->id);
                $deleteUrl = route('events.destroy', $event->id);
                return <<<HTML
                    <a href="{$editUrl}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{$event->id}" data-name="{$event->title}" data-delete-url="{$deleteUrl}"><i class="fas fa-trash"></i></button>
                HTML;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('events::index');
}

    public function create()
    {
        return view('events::create');
    }

    public function edit(Event $event)
    {
        $event = Event::with(['images', 'eventDates'])->findOrFail($event->id);

        return view('events::edit', compact('event'));
    }

    public function store(EventsRequest $request)
    {
        $event = Event::create($request->only([
            'title',
            'slug',
            'event_date',
            'description',
            'link',
            'image_url',
            'status'
        ]));

        // Decode JSON string if needed
        $images = $request->images;
        if (is_string($images)) {
            $images = json_decode($images, true) ?? [];
        }

        $this->syncImages($event, $images);
        $this->syncEventDates($event, $request->event_dates ?? []);

        return redirect()->route('events.index')
            ->with('success', 'Event added successfully.');
    }

    public function update(EventsRequest $request, $id)
    {
        $event = Event::findOrFail($id);

        $event->update($request->only([
            'title',
            'slug',
            'event_date',
            'description',
            'link',
            'image_url',
            'status'
        ]));

        // Decode JSON string if needed
        $images = $request->images;
        if (is_string($images)) {
            $images = json_decode($images, true) ?? [];
        }

        $this->syncImages($event, $images);
        $this->syncEventDates($event, $request->event_dates ?? []);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->images()->delete();
        $event->eventDates()->delete();
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Deleted successfully!');
    }

    /**
     * Sync gallery images
     */
    protected function syncImages(Event $event, array $images): void
    {
        $event->images()->delete();

        foreach ($images as $image) {
            if ($image) {
                $event->images()->create(['image_url' => $image]);
            }
        }
    }

    /**
     * Sync repeater event dates
     */
    protected function syncEventDates(Event $event, array $dates): void
    {
        $event->eventDates()->delete();

        foreach ($dates as $date) {
            if (!empty($date['date'])) {
                $event->eventDates()->create([
                    'name' => $date['name'] ?? null,
                    'date' => $date['date'],
                    'link' => $date['link'] ?? null,
                ]);
            }
        }
    }
}

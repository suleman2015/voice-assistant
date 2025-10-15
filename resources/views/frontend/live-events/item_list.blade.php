{{-- ✅ Upcoming Events --}}
@if ($upcomingEvents->isNotEmpty())
    <div class="col-md-12 mb-4" data-aos="fade-up">
        <h3 class="section-title">Upcoming Events</h3>
    </div>

    @foreach ($upcomingEvents as $event)
        @php
            $image = imageOrPlaceholder(
                optional($event->images->first())->image_url ?? $event->image_url ?? null,
                'assets/images/post.webp'
            );
            $eventDate = optional($event->eventDates->first())->date ?? $event->event_date;
        @endphp

        <div class="col-md-4 mb-3" data-aos="fade-up">
            <h6 class="title-event">
                {{ $eventDate ? \Carbon\Carbon::parse($eventDate)->format('F d, Y') : 'TBA' }}
            </h6>

            <div class="media_link"
                style="background-image: url('{{ $image }}'); background-size: cover; background-position: center; border-radius: 8px; height: 250px; position: relative; cursor: pointer;"
                data-title="{{ $event->title ?? 'Untitled Event' }}"
                data-image="{{ $image }}"
                data-link="{{ $event->register_link ?? '#' }}">
                <div class="details-btn work-popup d-flex align-items-center justify-content-center h-100">
                    <i class="ri-arrow-right-up-line text-white fs-3"></i>
                </div>
            </div>
        </div>
    @endforeach
@endif

{{-- ✅ Past Events --}}
@if ($pastEvents->isNotEmpty())
    <div class="col-md-12 mt-5 mb-4" data-aos="fade-up">
        <h3 class="section-title">Past Events</h3>
    </div>

    @foreach ($pastEvents as $event)
        @php
            $image = imageOrPlaceholder(
                optional($event->images->first())->image_url != null ? $event->images->first()->image_url : $event->image_url ?? null,
                'assets/images/post.webp'
            );
            $eventDate = optional($event->eventDates->first())->date ?? $event->event_date;
        @endphp

        <div class="col-md-4 mb-3" data-aos="fade-up">
            <h6 class="title-event">
                {{ $eventDate ? \Carbon\Carbon::parse($eventDate)->format('F d, Y') : 'TBA' }}
            </h6>

            <div class="media_link"
                style="background-image: url('{{ $image }}'); background-size: cover; background-position: center; border-radius: 8px; height: 250px; position: relative; cursor: pointer;"
                data-title="{{ $event->title ?? 'Untitled Event' }}"
                data-image="{{ $image }}"
                data-link="{{ $event->link ?? '#' }}">
                <div class="details-btn work-popup d-flex align-items-center justify-content-center h-100">
                    <i class="ri-arrow-right-up-line text-white fs-3"></i>
                </div>
            </div>
        </div>
    @endforeach
@endif

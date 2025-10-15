<section class="slider-main-wrapper py-5 border-bar">
    <div class="container-fluid">
        <div class="sec-name mb-10">
            <h2 class="">Search Results</h2>
        </div>

        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-4 col-lg-3 mb-3">
                    <article class="hover-up-2 transition-normal">
                        <div class="post-card-1 border-radius-10 hover-up">
                            <div class="post-thumb thumb-overlay img-hover-slide position-relative">
                                <a href="{{ route('postPage', $post->slug) }}" class="fix_heading d-block">
                                    <img src="{{ imageOrPlaceholder($post->image, 'assets/frontend/images/placeholder.jpg') }}"
                                        alt="{{ $post->name }}" class="w-100 rounded-3"
                                        style="object-fit: cover; height: 200px;">
                                </a>
                            </div>

                            <div class="post-content p-10 fix_cards">
                                <div class="entry-meta meta-0 font-small mb-10">
                                    @if ($post->categories && $post->categories->count() > 0)
                                        @foreach ($post->categories as $category)
                                            <a href="{{ route('categoryPage', $category->slug) }}"
                                               class="post-cate me-1 text-decoration-none text-primary">
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="post-cate">Uncategorized</span>
                                    @endif
                                </div>

                                <div class="d-flex flex-column post-card-content">
                                    <h5 class="blog-post-title font-weight-700">
                                        <a href="{{ route('postPage', $post->slug) }}" class="fix_heading">
                                            {{ str_replace('&amp;', '&', $post->name) ?? '' }}
                                        </a>
                                    </h5>

                                    @php
                                        // Prefer direct description; fallback to first paragraph from content
                                        $desc = $post->description ?? '';
                                        if (empty($desc) && !empty($post->content)) {
                                            if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $post->content, $matches)) {
                                                $desc = $matches[1];
                                            }
                                        }
                                        $desc = strip_tags($desc);
                                    @endphp

                                    <p class="fix_paragraph">
                                        {{ \Illuminate\Support\Str::limit($desc, 120) }}
                                    </p>

                                    <div class="entry-meta meta-1 float-left font-x-small text-uppercase">
                                        <span class="post-date">
                                            {{ optional($post->created_at)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">No results found for "{{ $keywords }}".</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@section('title', __('User Cases'))
@extends('frontend.layouts.master')

@section('content')

    {{-- Hero --}}
    <div class="home_banner general-banner position-relative"
         style="background-image: url('{{ asset('assets/frontend/images/banner2.webp') }}'); background-size:cover; background-position:center;">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">User Cases</h1>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    <div class="container py-5 last_section">
        {!! $page->content !!}
    </div>

    @php
        $oldSpecialities = old('speciality', ['']);
        $oldContents     = old('content', ['']);
        $caseCount       = max(count($oldSpecialities), count($oldContents));
        if ($caseCount === 0) { $caseCount = 1; }
        $primary = '#24456E';
        $accent  = '#f8951e';
    @endphp

    {{-- Form Card --}}
    <div class="container pb-5">
        <div class="mx-auto" style="max-width: 900px;">
            <div class="uc-card shadow-sm">
                <div class="uc-card-header d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Submit Your Case(s)</h3>
                    <span class="badge uc-badge">Secure & Confidential</span>
                </div>

                {{-- ALERT SLOT FOR AJAX --}}
                <div id="uc-alert" class="mb-3" style="display:none;"></div>

                <form id="casesForm" action="" method="POST" novalidate>
                    @csrf

                    {{-- Flash Success (kept for non-AJAX fallbacks) --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="contact_name" class="form-label uc-label required">{{ __('Name') }}</label>
                        <input
                            type="text"
                            class="form-control uc-input @error('name') is-invalid @enderror"
                            id="contact_name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="{{ __('Name') }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Anonymous --}}
                    <div class="mb-3">
                        <label class="form-label uc-label required">{{ __('Would you want to stay anonymous?') }}</label>
                        <div class="uc-radio-row">
                            @php $oldAnon = old('is_anonymous'); @endphp
                            <input class="btn-check" type="radio" name="is_anonymous" id="anon_yes" value="1" {{ $oldAnon === '1' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="anon_yes">Yes</label>

                            <input class="btn-check" type="radio" name="is_anonymous" id="anon_no" value="0" {{ $oldAnon === '0' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="anon_no">No</label>
                        </div>
                        @error('is_anonymous')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profession --}}
                    <div class="mb-3">
                        <label class="form-label uc-label required">{{ __('Profession') }}</label>
                        <div class="uc-radio-row flex-wrap">
                            @php $oldProf = old('profession'); @endphp

                            <input class="btn-check" type="radio" name="profession" id="prof_physician" value="Physician" {{ $oldProf === 'Physician' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="prof_physician">Physician</label>

                            <input class="btn-check" type="radio" name="profession" id="prof_intraining" value="In-Training" {{ $oldProf === 'In-Training' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="prof_intraining">In-Training</label>

                            <input class="btn-check" type="radio" name="profession" id="prof_app" value="App" {{ $oldProf === 'App' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="prof_app">App</label>

                            <input class="btn-check" type="radio" name="profession" id="prof_industry" value="Industry" {{ $oldProf === 'Industry' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="prof_industry">Industry</label>

                            <input class="btn-check" type="radio" name="profession" id="prof_other" value="Other" {{ $oldProf === 'Other' ? 'checked' : '' }}>
                            <label class="btn uc-radio-pill" for="prof_other">Other</label>
                        </div>
                        @error('profession')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Cases Header + Add button --}}
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label uc-label required mb-0">Cases</label>
                        <button type="button" id="addCaseBtn" class="btn btn-sm uc-add-btn rounded-pill">
                            <i class="fa-solid fa-circle-plus me-1"></i> Add More Case
                        </button>
                    </div>

                    {{-- Cases Container --}}
                    <div class="row g-4" id="cases-container">
                        @for ($i = 0; $i < $caseCount; $i++)
                            <div class="col-12 case-item">
                                <div class="uc-subcard">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="uc-case-chip">Case <span class="uc-case-index">{{ $i + 1 }}</span></span>
                                        </div>
                                        @if ($i > 0)
                                            <button type="button" class="btn btn-sm uc-del-btn rounded-pill delete-case-btn">
                                                <i class="fa-solid fa-trash-can me-1"></i> Delete
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Speciality --}}
                                    <div class="mt-3">
                                        @php
                                            $selectId = 'speciality_' . $i;
                                            $oldSpec  = $oldSpecialities[$i] ?? '';
                                        @endphp
                                        <label for="{{ $selectId }}" class="form-label uc-label">Speciality</label>
                                        <select
                                            class="form-select uc-input @error('speciality.'.$i) is-invalid @enderror"
                                            id="{{ $selectId }}"
                                            name="speciality[]">
                                            <option value="">Select Speciality</option>
                                            <option value="GI"     {{ $oldSpec === 'GI' ? 'selected' : '' }}>GI</option>
                                            <option value="GU"     {{ $oldSpec === 'GU' ? 'selected' : '' }}>GU</option>
                                            <option value="Breast" {{ $oldSpec === 'Breast' ? 'selected' : '' }}>Breast</option>
                                        </select>
                                        @error('speciality.'.$i)
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Content --}}
                                    <div class="mt-3">
                                        @php
                                            $txtId = 'content_' . $i;
                                            $oldTxt = $oldContents[$i] ?? '';
                                        @endphp
                                        <label for="{{ $txtId }}" class="form-label uc-label">Description</label>
                                        <textarea
                                            id="{{ $txtId }}"
                                            name="content[]"
                                            rows="5"
                                            class="form-control uc-input @error('content.'.$i) is-invalid @enderror"
                                            placeholder="Describe Your Case Briefly...">{{ $oldTxt }}</textarea>
                                        @error('content.'.$i)
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;overflow:hidden;" aria-hidden="true">
                                        <label for="_hp_website">Website</label>
                                        <input type="text" name="_hp_website" id="_hp_website" tabindex="-1" autocomplete="off" />
                                        <input type="hidden" name="_hp_time" value="{{ now()->timestamp }}">
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    {{-- Submit --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn uc-submit-btn" id="uc-submit-btn">
                            <span class="me-2">Submit Cases</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
/* (Your CSS kept exactly as provided) */
:root{
    --uc-primary: #24456E;
    --uc-accent:  #f8951e;
    --uc-bg:      #f7f9fc;
    --uc-border:  #e8eef6;
    --uc-text:    #1f2a37;
    --uc-muted:   #6b7a90;
    --uc-white:   #fff;
}
.uc-card{background: var(--uc-white);border: 1px solid var(--uc-border);border-radius: 16px;padding: 24px;}
.uc-card-header{border-bottom: 1px dashed var(--uc-border);padding-bottom: 16px;margin-bottom: 20px;}
.uc-badge{background: rgba(36,69,110,0.1);color: var(--uc-primary);font-weight: 600;border-radius: 999px;padding: 6px 12px;font-size: 12px;}
.uc-label{font-weight: 600;color: var(--uc-text);}
.required::after{content: ' *';color: var(--uc-accent);font-weight: 700;}
.uc-input{border: 1px solid var(--uc-border);border-radius: 12px;padding: 10px 12px;transition: box-shadow .2s ease, border-color .2s ease;background: #fff;}
.uc-input:focus{outline: none;border-color: rgba(36,69,110,.35);box-shadow: 0 0 0 4px rgba(36,69,110,.08);}
.uc-radio-row{display: flex;gap: 8px;}
.uc-radio-pill{border: 1px solid var(--uc-border);border-radius: 999px;padding: 6px 14px;font-weight: 600;color: var(--uc-text);background: #fff;transition: all .2s ease;}
.btn-check:checked + .uc-radio-pill{color: #fff;background: var(--uc-primary);border-color: var(--uc-primary);box-shadow: 0 6px 16px rgba(36,69,110,.18);}
.uc-subcard{background: var(--uc-bg);border: 1px dashed var(--uc-border);border-radius: 14px;padding: 16px;}
.uc-case-chip{background: rgba(36,69,110,.08);color: var(--uc-primary);font-weight: 700;border-radius: 999px;padding: 6px 12px;display: inline-block;}
.uc-add-btn{background: var(--uc-accent);color: #fff;border: none;font-weight: 700;padding: 6px 12px;box-shadow: 0 8px 18px rgba(248,149,30,.25);}
.uc-add-btn:hover{ filter: brightness(.96); color:#fff; }
.uc-del-btn{background: #fff2ee;color: #c0361d;border: 1px solid #ffd7cc;font-weight: 700;padding: 6px 12px;}
.uc-del-btn:hover{ background:#ffe9e3; }
.uc-submit-btn{background: linear-gradient(180deg, var(--uc-accent), #f07d00);color: #fff;font-weight: 800;border: none;border-radius: 12px;padding: 10px 16px;box-shadow: 0 10px 24px rgba(248,149,30,.3);}
.uc-submit-btn:hover{ filter: brightness(.97); color:#fff; }
.invalid-feedback{ font-size: .9rem; }
.btn-close{ background:none; border:0; font-size:1.25rem; line-height:1; }
</style>
@endSection

@section('scripts')
<script>
(function(){
    const casesContainer = document.getElementById('cases-container');
    const addBtn = document.getElementById('addCaseBtn');
    const form = document.getElementById('casesForm');
    const alertBox = document.getElementById('uc-alert');
    const submitBtn = document.getElementById('uc-submit-btn');
    const API_URL = "{{ url('/api/onc/cases') }}";

    const makeCaseItem = (index) => {
        const uid = Date.now().toString(36) + '_' + Math.floor(Math.random()*1e6);
        return `
        <div class="col-12 case-item">
            <div class="uc-subcard">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="uc-case-chip">Case <span class="uc-case-index">${index}</span></span>
                    </div>
                    <button type="button" class="btn btn-sm uc-del-btn rounded-pill delete-case-btn">
                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                    </button>
                </div>

                <div class="mt-3">
                    <label for="speciality_${uid}" class="form-label uc-label">Speciality</label>
                    <select id="speciality_${uid}" name="speciality[]" class="form-select uc-input">
                        <option value="">Select Speciality</option>
                        <option value="GI">GI</option>
                        <option value="GU">GU</option>
                        <option value="Breast">Breast</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="content_${uid}" class="form-label uc-label">Description</label>
                    <textarea id="content_${uid}" name="content[]" rows="5"
                              class="form-control uc-input"
                              placeholder="Describe Your Case Briefly..."></textarea>
                </div>
            </div>
        </div>`;
    };

    const renumberCases = () => {
        const indices = casesContainer.querySelectorAll('.uc-case-index');
        indices.forEach((el, i) => el.textContent = (i + 1));
    };

    // Add new case
    if (addBtn){
        addBtn.addEventListener('click', () => {
            const nextIndex = casesContainer.querySelectorAll('.case-item').length + 1;
            casesContainer.insertAdjacentHTML('beforeend', makeCaseItem(nextIndex));
            renumberCases();
        });
    }

    // Delete via event delegation
    casesContainer.addEventListener('click', (e) => {
        const delBtn = e.target.closest('.delete-case-btn');
        if (!delBtn) return;
        const item = delBtn.closest('.case-item');
        if (item) {
            item.remove();
            renumberCases();
        }
    });

    // Optional: disable Name when anonymous is yes
    const anonYes = document.getElementById('anon_yes');
    const anonNo  = document.getElementById('anon_no');
    const nameInp = document.getElementById('contact_name');
    const toggleName = () => {
        if (anonYes && anonYes.checked){
            if (nameInp) { nameInp.disabled = true; nameInp.classList.add('opacity-75'); }
        } else {
            if (nameInp) { nameInp.disabled = false; nameInp.classList.remove('opacity-75'); }
        }
    };
    [anonYes, anonNo].forEach(r => r && r.addEventListener('change', toggleName));
    toggleName();

    // ---- AJAX SUBMIT ----
    const showAlert = (type, html) => {
        alertBox.className = ''; // reset
        alertBox.style.display = 'block';
        alertBox.classList.add('alert', `alert-${type}`, 'alert-dismissible', 'fade', 'show');
        alertBox.innerHTML = `
            ${html}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    };

    const clearAlert = () => {
        alertBox.style.display = 'none';
        alertBox.className = '';
        alertBox.innerHTML = '';
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearAlert();

        // Disable button
        submitBtn.disabled = true;

        const fd = new FormData(form);

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                body: fd,
                headers: {
                    'Accept': 'application/json',
                }
            });

            const json = await res.json();

            if (res.ok) {
                showAlert('success', `<strong>Success:</strong> ${json.message || 'Submitted successfully.'}`);

                // Reset form (keep exactly your form logic)
                form.reset();

                // Reset cases container to a single empty case
                casesContainer.innerHTML = '';
                casesContainer.insertAdjacentHTML('beforeend', makeCaseItem(1));
                renumberCases();

                // Re-apply anonymous toggle UI
                toggleName();
            } else if (res.status === 422) {
                const errs = json.errors || {};
                let list = '<ul class="mb-0 ps-3">';
                Object.keys(errs).forEach(k => {
                    errs[k].forEach(msg => { list += `<li>${msg}</li>`; });
                });
                list += '</ul>';
                showAlert('danger', `<strong>Validation failed.</strong> ${list}`);
            } else {
                showAlert('danger', `<strong>Error:</strong> ${json.message || 'Unable to submit your cases.'}`);
            }
        } catch (err) {
            showAlert('danger', `<strong>Network Error:</strong> ${err?.message || err}`);
        } finally {
            submitBtn.disabled = false;
        }
    });

    // Initial numbering
    renumberCases();
})();
</script>
@endsection

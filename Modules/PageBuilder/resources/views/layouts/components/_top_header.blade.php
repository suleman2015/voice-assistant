   <!-- Topbar Start -->
   <div class="container-fluid topbar px-0 px-lg-4 bg-theme py-3 d-none d-lg-block">
       <div class="container">
           <div class="row gx-0 align-items-center">
              
               <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                   <div class="d-flex flex-wrap justify-content-start">
                    <div class="">
                           <a href="#" class="text-light small"><i
                                   class="fas fa-map-marker-alt text-light me-2"></i>2464 Royal Ln. Mesa, New Jersey
                               45463</a>
                       </div>
                       <div class="ps-3">
                           <a href="mailto:example@gmail.com" class="text-light small"><i
                            class="fas fa-phone-alt me-2"></i>00905349329231</a>
                        </div>
                        <div class="border-end border-primary ps-3">
                            <a href="mailto:example@gmail.com" class="text-light small"><i
                                    class="fas fa-envelope text-light me-2"></i>info@releasemesyria.org</a>
                        </div>
                       
                   </div>
               </div>
                <div class="col-lg-4 text-center text-lg-start">
                   <div class="d-flex justify-content-end">
                       <div class="d-flex border-end align-items-center border-primary pe-3">
                           <a class="btn p-0 text-primary me-3 btn-smedia" href="#"><i
                                   class="fab fa-facebook-f"></i></a>
                           <a class="btn p-0 text-primary me-3 btn-smedia" href="#"><i
                                   class="fab fa-twitter"></i></a>
                           <a class="btn p-0 text-primary me-3 btn-smedia" href="#"><i
                                   class="fab fa-linkedin-in"></i></a>
                           <a class="btn p-0 text-primary me-0 btn-smedia" href="#"><i
                                   class="fab fa-instagram"></i></a>
                       </div>
                       <div class="dropdown ms-3">
                       <form method="POST" action="{{ route('language.switch') }}">
                            @csrf
                            <select name="locale" onchange="this.form.submit()" class="form-select w-auto">
                                @php
                                    $activeLangs = \Modules\Language\Models\Language::where('status', true)->get();
                                @endphp
                                @foreach ($activeLangs as $lang)
                                    <option value="{{ $lang->short_code }}" {{ app()->getLocale() == $lang->short_code ? 'selected' : '' }}>
                                        {{ $lang->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Topbar End -->

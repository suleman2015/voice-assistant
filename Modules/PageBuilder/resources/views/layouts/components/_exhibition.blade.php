   <div class="container-fluid bg-light about py-5">
       <div class="container py-5 mb-5">
           <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
               <h1 class="display-4 mb-4 text-primary">{{ $content['exhibition_heading']['value'] ?? 'Our Exhibition' }}</h1>
           </div>
           <div class="row g-4">
               <!-- Image 1 -->
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                   <img src="{{ asset('assets/frontend/img/g1.jpg') }}" alt="Gallery 1" class="gallery-img">
               </div>
               <!-- Image 2 -->
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.4s">
                   <img src="{{ asset('assets/frontend/img/g2.jpg') }}" alt="Gallery 2" class="gallery-img">
               </div>
               <!-- Image 3 -->
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.6s">
                   <img src="{{ asset('assets/frontend/img/g3.jpg') }}" alt="Gallery 3" class="gallery-img">
               </div>
               <!-- Image 4 -->
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="0.8s">
                   <img src="{{ asset('assets/frontend/img/g4.jpg') }}" alt="Gallery 4" class="gallery-img">
               </div>
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="1s">
                   <img src="{{ asset('assets/frontend/img/g5.jpg') }}" alt="Gallery 5" class="gallery-img">
               </div>
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="1.2s">
                   <img src="{{ asset('assets/frontend/img/g6.jpg') }}" alt="Gallery 6" class="gallery-img">
               </div>
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="1.3s">
                   <img src="{{ asset('assets/frontend/img/g7.png') }}" alt="Gallery 7" class="gallery-img">
               </div>
               <div class="col-12 col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay="1.4s">
                   <img src="{{ asset('assets/frontend/img/g8.png') }}" alt="Gallery 8" class="gallery-img">
               </div>
           </div>
       </div>
   </div>

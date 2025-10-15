<div class="offcanvas-body">
  <div class="list-group list-group-flush">
      @foreach($menu->items as $item)
          @include('menu::frontend.partials.mobile-item', ['item' => $item])
      @endforeach
  </div>
</div>

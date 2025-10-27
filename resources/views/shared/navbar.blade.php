<nav class="navbar navbar-expand-lg bg-body-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dedicate.landing') }}">
        <div class="navbar-brand-container">
            <img src="{{ asset('assets/uploads/Rivnitz_flame_logo_icon_6358de21.png') }}"  alt="Rivnitz logo" width="28" height="28" class="object-contain">
            <div class="leading-tight">
                <div  class="text-[26px] tracking-[0.02em] font-serif font-semibold" style="color: var(--brand-teal);">Rivnitz</div>
                <div class="text-[14px] -mt-[2px]" style="color: var(--brand-gold);">Miracles Through Mission</div>
            </div>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('dedicate.landing') }}">Dedicate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('videos') }}">Videos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Admin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
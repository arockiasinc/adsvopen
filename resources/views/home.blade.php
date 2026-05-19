@include('partials.header')

@php
    $authUser = auth()->user();
    $primaryCta = $authUser
        ? ($authUser->isAdmin()
            ? route('filament.admin.pages.dashboard')
            : route('filament.advertiser.pages.dashboard'))
        : route('filament.advertiser.auth.register');
@endphp

@if ($heroSlides->isNotEmpty())
<section class="hp-banner-slider" id="hero" aria-label="Homepage banner slider" data-carousel>
  <div class="hp-banner-stage">
    @foreach ($heroSlides as $index => $slide)
    <div class="hp-banner-slide absolute inset-0 {{ $index === 0 ? 'visible pointer-events-auto opacity-100 translate-y-0' : 'invisible pointer-events-none opacity-0 translate-y-2' }}" data-slide style="--banner-image: url('{{ $slide['image_url'] }}');" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
      <div class="hp-banner-slide-caption">
        <div class="hp-banner-slide-title-panel">
          <h2 class="hp-banner-slide-title">{{ $slide['title'] }}</h2>
        </div>
        @if (!empty($slide['copy']) || !empty($slide['detail']))
          <div class="hp-banner-slide-copy-panel">
            @if (!empty($slide['copy']))
              <p>{{ $slide['copy'] }}</p>
            @endif
            @if (!empty($slide['detail']))
              <p class="hp-banner-slide-detail">{{ $slide['detail'] }}</p>
            @endif
          </div>
        @endif
        @if (!empty($slide['highlights']))
          <div class="hp-banner-slide-pill-panel" aria-label="Advertisement types">
            @foreach ($slide['highlights'] as $highlight)
              <span class="hp-banner-pill">{{ $highlight }}</span>
            @endforeach
          </div>
        @endif
        @if (!empty($slide['buttonRows']))
          <div class="hp-banner-slide-button-panel" aria-label="Advertisement options">
            @foreach ($slide['buttonRows'] as $row)
              <div class="hp-banner-button-row">
                @foreach ($row as $buttonLabel)
                  <span class="hp-banner-option-button">{{ $buttonLabel }}</span>
                @endforeach
              </div>
            @endforeach
          </div>
        @endif
        @if (!empty($slide['footer']))
          <div class="hp-banner-slide-copy-panel hp-banner-slide-footer-panel">
            <p>{{ $slide['footer'] }}</p>
          </div>
        @endif
      </div>
    </div>
    @endforeach

    <div class="hp-banner-backdrop" aria-hidden="true"></div>

    @if ($heroSlides->count() > 1)
    <div class="hp-slider-controls hp-banner-controls">
      <button class="hp-slider-arrow" type="button" data-direction="prev" aria-label="Show previous slide">
        <span aria-hidden="true">&#8592;</span>
      </button>
      <div class="hp-slider-dots" aria-label="Choose slide">
        @foreach ($heroSlides as $index => $slide)
          <button class="h-2.5 w-2.5 rounded-full {{ $index === 0 ? 'bg-accent scale-110' : 'bg-ink/20' }} transition" type="button" aria-label="Show slide {{ $index + 1 }}" aria-pressed="{{ $index === 0 ? 'true' : 'false' }}" data-dot="{{ $index }}"></button>
        @endforeach
      </div>
      <button class="hp-slider-arrow" type="button" data-direction="next" aria-label="Show next slide">
        <span aria-hidden="true">&#8594;</span>
      </button>
    </div>
    @endif

    <div class="hp-anchor-group" aria-hidden="true">
      <span class="hp-anchor" id="benefits"></span>
      <span class="hp-anchor" id="latest-news"></span>
      <span class="hp-anchor" id="video-campaign"></span>
    </div>
  </div>
</section>
@endif

<section class="hp-assistant-cta">
  <div class="hp-shell">
    <div class="hp-assistant-panel">
      <span class="hp-kicker">Start Advertising</span>
      <h2 class="hp-section-title">Launch your business account in just a few minutes.</h2>
      <div class="hp-assistant-text hp-assistant-text-intro">
        <p>Start advertising with Canada's Only VOpen Market using a quick business account setup designed to get you moving fast.</p>
      </div>
      <div class="hp-assistant-steps">
        <article class="hp-assistant-step-card">
          <span class="hp-assistant-step-number">01</span>
          <h3>Register your business account</h3>
          <p>Simply register using your business account. It only takes a few minutes to get started.</p>
        </article>
        <article class="hp-assistant-step-card">
          <span class="hp-assistant-step-number">02</span>
          <h3>Get approved and go live</h3>
          <p>Once your account is approved, you'll be ready to launch your advertising campaigns and start reaching more customers right away.</p>
        </article>
        <article class="hp-assistant-step-card">
          <span class="hp-assistant-step-number">03</span>
          <h3>Grow with VOpen Market</h3>
          <p>We're excited to have you on board and can't wait to see your business grow with us.</p>
        </article>
      </div>
      <a class="hp-button hp-button-primary hp-cta-button" href="{{ $primaryCta }}">Register now</a>
    </div>
  </div>
</section>

<section class="hp-assistant-cta" id="assistant-guide">
  <div class="hp-shell">
    <div class="hp-assistant-panel">
      <div class="hp-anchor-group" aria-hidden="true">
        <span class="hp-anchor" id="campaign-setup"></span>
        <span class="hp-anchor" id="placements"></span>
        <span class="hp-anchor" id="importance"></span>
        <span class="hp-anchor" id="case-studies"></span>
        <span class="hp-anchor" id="partner-support"></span>
        <span class="hp-anchor" id="creative-support"></span>
        <span class="hp-anchor" id="courses"></span>
        <span class="hp-anchor" id="guides"></span>
        <span class="hp-anchor" id="faq"></span>
      </div>

      <span class="hp-kicker">Need a hand?</span>
      <h2 class="hp-section-title">Unsure where to begin?</h2>
      <div class="hp-assistant-text">
        <p>Our Intelligent Assistant can guide you. Simply answer a few brief questions for a personalized recommendation tailored to your business.</p>
      </div>
      <a class="hp-button hp-button-primary hp-cta-button" href="{{ $primaryCta }}">Let's begin</a>
    </div>
  </div>
</section>

@include('partials.footer')

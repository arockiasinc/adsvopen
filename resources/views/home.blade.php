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

<section class="hp-welcome" id="welcome" aria-label="Welcome">
  <div class="hp-shell hp-welcome-shell">
    <p class="hp-welcome-intro">Welcome to our advertising portal, reserved exclusively for registered advertisers. Verifying your business credentials and campaign details now ensures priority activation and seamless updates to your marketing strategy.</p>

    <h2 class="hp-welcome-headline">Command the Canadian click!</h2>

    <p class="hp-welcome-lead">Make a powerful first impression. All of our campaigns feature a flat-fee model&mdash;meaning absolutely no pay-per-view or pay-per-click charges. We believe the market should be accessible to businesses of all sizes, not just the highest bidder. Ours is the only platform that gives you total control over exactly where your ads appear.</p>

    <h2 class="hp-welcome-headline">Choose your audience!</h2>

    @php
      $audienceWords = ['City wide', 'Region wide', 'District wide', 'County wide', 'Municipality wide', 'Province wide', 'Coast to coast'];
    @endphp
    <div class="hp-audience-rotator" data-word-rotator data-words='@json($audienceWords)'>
      <span class="hp-audience-word" data-typed-output aria-hidden="true">{{ $audienceWords[0] }}</span><span class="hp-audience-cursor" aria-hidden="true"></span>
      <span class="sr-only">Choose your audience: {{ implode(', ', $audienceWords) }}.</span>
    </div>

    <div class="hp-anchor-group" aria-hidden="true">
      <span class="hp-anchor" id="panoramic-banner-ads"></span>
      <span class="hp-anchor" id="leaderboard-ads"></span>
      <span class="hp-anchor" id="product-sponsored-ads"></span>
      <span class="hp-anchor" id="product-carousel"></span>
      <span class="hp-anchor" id="contact"></span>
    </div>
  </div>
</section>

<section class="border-t border-black/10 py-10 md:py-[72px]" aria-labelledby="why-advertise-heading">
  <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
    <div class="w-full text-center">
      <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]" id="why-advertise-heading">Why advertise with us</h2>
      <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
    </div>

    <div class="grid gap-[14px] md:grid-cols-2 xl:grid-cols-4">
      <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
        <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-targeting.svg') }}" alt="Precise targeting icon">
        <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Precise Targeting</h3>
        <p class="text-[0.9rem] leading-[1.55] text-muted">Reach directly with your ideal customers through VOpen Market&rsquo;s advanced audience matching that maximizes your return on investment.</p>
      </article>

      <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
        <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/fixed-icon.png') }}" alt="Flat-rate pricing icon">
        <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Not a Cost-Per-Click</h3>
        <p class="text-[0.9rem] leading-[1.55] text-muted">Enjoy the complete visibility and unlimited traffic potential with VOpen Market&rsquo;s high-value, flat-rate pricing model.</p>
      </article>

      <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
        <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-measure.svg') }}" alt="Transparent fees icon">
        <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Transparent Fees</h3>
        <p class="text-[0.9rem] leading-[1.55] text-muted">Build your campaign with complete peace of mind, knowing every cost is fully visible upfront with zero surprises.</p>
      </article>

      <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
        <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-placement.svg') }}" alt="Guaranteed display icon">
        <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Guaranteed Display</h3>
        <p class="text-[0.9rem] leading-[1.55] text-muted">Lock in your premium ad real estate today and enjoy non-stop visibility that keeps your brand at the top of the VOpen Market platform.</p>
      </article>
    </div>
  </div>
</section>

<section class="hp-assistant-cta">
  <div class="hp-shell">
    <div class="hp-assistant-panel">
      <span class="hp-kicker">Start Advertising</span>
      <h2 class="hp-section-title">Launch your advertisement campaign in just a few minutes</h2>
      <div class="hp-assistant-steps">
        <article class="hp-assistant-step-card">
          <span class="hp-assistant-step-number">01</span>
          <h3>Register your Advertisement account</h3>
          <p>Simply register using your business account. It only takes a few minutes to get started.</p>
        </article>
        <article class="hp-assistant-step-card">
          <span class="hp-assistant-step-number">02</span>
          <h3>Get approved and go live</h3>
          <p>Once your account is approved, (usually 72 hours) you'll be ready to launch your advertising campaigns and start reaching more customers right away.</p>
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

<section class="hp-assistant-cta" id="registration-fee">
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

      <h2 class="hp-section-title">Registration fee</h2>
      <div class="hp-assistant-text hp-assistant-text-full">
        <p>To maintain a high-quality, scam- and spam-free environment for our users, advertising is exclusively permitted for government-registered Canadian companies and organizations. We thoroughly review all advertisers and their promotional content; accordingly, account activation requires a $475.99 registration deposit. This full amount will be credited back to your account balance when your campaign is approved and launched.</p>
      </div>
    </div>
  </div>
</section>

@include('partials.footer')

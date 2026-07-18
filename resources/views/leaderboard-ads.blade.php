@include('partials.header')

  <section class="border-t border-black/10 py-10">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="grid gap-4 text-center lg:text-left">
        <div>
          <span class="lb-chip">
            <span class="lb-chip-dot" aria-hidden="true"></span>
            Local ads serving across Canada
          </span>
        </div>
        <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Premium Homepage Placements</h2>
        <p class="text-[0.98rem] leading-[1.7] text-muted">
          <b>Maximum Visibility, Zero Wasted Ad Spend.</b> Put your brand front and center where it cannot be missed.
          Our prime homepage placements capture maximum audience attention the moment visitors land on our site,
          positioning your business as the market leader.
        </p>
        @php
          $audienceWords = ['City wide', 'Region wide', 'District wide', 'County wide', 'Province wide', 'Coast to coast'];
        @endphp
        <p class="text-[0.98rem] font-extrabold leading-[1.7] text-copy">Claim your territory!</p>
        <div class="hp-audience-rotator hp-audience-rotator--start" data-word-rotator data-words='@json($audienceWords)'>
          <span class="hp-audience-word" data-typed-output aria-hidden="true">{{ $audienceWords[0] }}</span><span class="hp-audience-cursor" aria-hidden="true"></span>
          <span class="sr-only">Claim your territory: {{ implode(', ', $audienceWords) }}.</span>
        </div>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 py-16 md:py-[72px]" id="hero">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-8">
      <div class="max-w-[520px]">
        <div class="mb-5">
          <span class="inline-grid h-[42px] w-[42px] place-items-center rounded-xl bg-ink shadow-[10px_10px_0_rgba(255,101,7,0.18)]">
            <img class="h-6 w-6" src="{{ asset('images/stars-icon.svg') }}" alt="">
          </span>
        </div>
        <h1 class="mb-[18px] whitespace-nowrap text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em]">Leaderboard Ads</h1>
        <p class="mb-7 max-w-[36ch] text-[0.98rem] leading-[1.7] text-muted">
          <b>Dual-Placement Exposure: High Traffic &amp; Contextual Relevancy.</b><br/>
          Your campaign doesn&rsquo;t just sit in one spot. To maximize your frequency and conversion rates, your brand is
          integrated into the two most active zones on our homepage.
        </p>
        <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-accent px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="#how-to-start">Claim your territory</a>
      </div>

      <div class="flex justify-center lg:justify-end">
        {{-- VOpen Market website mock showing the Leaderboard banner plus in-feed product banners --}}
        <figure class="vm-mock w-full max-w-[620px]" aria-label="Leaderboard Ad shown at the top of the VOpen Market homepage, plus in-feed product banners">
          <div class="vm-mock-window">
            <div class="vm-mock-chrome" aria-hidden="true">
              <span class="vm-mock-dot vm-mock-dot--red"></span>
              <span class="vm-mock-dot vm-mock-dot--amber"></span>
              <span class="vm-mock-dot vm-mock-dot--green"></span>
              <span class="vm-mock-address">vopenmarket.com</span>
            </div>

            <div class="vm-mock-page">
              <div class="vm-mock-siteheader" aria-hidden="true">
                <img class="vm-mock-sitelogo" src="{{ asset('images/logo.webp') }}" alt="VOpen Market">
                <nav class="vm-mock-sitenav">
                  <span></span><span></span><span></span><span></span>
                </nav>
                <span class="vm-mock-searchpill"></span>
              </div>

              {{-- The Master Leaderboard: above-the-fold banner --}}
              <div class="vm-mock-ad" style="min-height:92px;" role="img" aria-label="Your master leaderboard advertisement: your logo left, your message center, your website right">
                <span class="vm-mock-ad-tag">Ad</span>
                <span class="vm-mock-ad-logo" style="top:50%;transform:translateY(-50%);">YOUR&nbsp;LOGO</span>
                <span class="vm-mock-ad-message" style="margin-top:20px;font-size:clamp(0.95rem,2.6vw,1.3rem);">Master Leaderboard</span>
                <span class="vm-mock-ad-site">www.yourwebsite.com</span>
              </div>

              {{-- In-feed product banners sit alongside trending products --}}
              <div class="vm-mock-grid" aria-hidden="true">
                <span></span>
                <span style="background:linear-gradient(120deg,#ff6507 0%,#ff6507 100%);border:0;"></span>
                <span></span>
                <span></span>
                <span></span>
                <span style="background:linear-gradient(120deg,#ff6507 0%,#ff6507 100%);border:0;"></span>
              </div>
            </div>
          </div>
          <figcaption class="vm-mock-caption">Your brand appears as the Master Leaderboard <b>and</b> in-feed beside trending products.</figcaption>
        </figure>
      </div>
    </div>
  </section>

  <section class="pp-section" id="dual-placement">
    <div class="pp-shell">
      <div class="pp-head">
        <span class="pp-eyebrow">
          <span class="pp-eyebrow-dot" aria-hidden="true"></span>
          Dual-placement exposure
        </span>
        <h2 class="pp-title">Two high-traffic zones, <span class="pp-title-accent">one campaign</span></h2>
        <p class="pp-intro">
          To maximize your frequency and conversion rates, your brand is integrated into the two most active zones on our
          homepage&mdash;catching shoppers the moment they arrive and again while they are actively browsing.
        </p>
      </div>

      <div class="pp-grid">
        <article class="pp-card">
          <span class="pp-card-icon"><img src="{{ asset('images/icon-placement.svg') }}" alt=""></span>
          <h3 class="pp-card-title">The Master Leaderboard</h3>
          <p class="pp-card-text">A premium, above-the-fold banner that serves as the very first visual touchpoint for every incoming visitor&mdash;your brand controls the narrative from the millisecond the page loads.</p>
        </article>

        <article class="pp-card">
          <span class="pp-card-icon"><img src="{{ asset('images/icon-discovery.svg') }}" alt=""></span>
          <h3 class="pp-card-title">In-Feed Product Banners</h3>
          <p class="pp-card-text">Your ads appear directly alongside trending products and active listings. This contextual placement catches users while they are comparison shopping and ready to buy.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 py-16 md:py-[76px]" id="geotargeting">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="w-full text-center">
        <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Advanced geotargeting</p>
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Engineered for location-based businesses</h2>
        <p class="mx-auto max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
          If your business relies on local clients, national ad networks waste your budget on clicks from across the country.
          Our platform lets you scale your market boundaries dynamically&mdash;so you only pay for local impressions.
        </p>
      </div>

      <div class="lb-geo-grid">
        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-targeting.svg') }}" alt=""></span>
          <div>
            <h3>Realtors &amp; Brokers</h3>
            <p>Dominate specific neighborhoods, cities, or districts to ensure home buyers and sellers see your face and active listings first.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-brand.svg') }}" alt=""></span>
          <div>
            <h3>Dental Clinics &amp; Medical Practices</h3>
            <p>Target exact municipal zones or counties to consistently capture new patient acquisitions within driving distance.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-measure.svg') }}" alt=""></span>
          <div>
            <h3>Law Firms &amp; Legal Services</h3>
            <p>Establish local authority across city, region, or province-wide boundaries where your practice holds jurisdiction.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-visuals.svg') }}" alt=""></span>
          <div>
            <h3>Insurance Agencies &amp; Local Contractors</h3>
            <p>Lock down your precise fleet dispatch radii&mdash;whether city-wide or region-wide&mdash;to capture high-intent inquiries.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 py-10 md:py-14" id="exclusive">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 lg:grid-cols-[minmax(0,1fr)_minmax(280px,380px)] lg:gap-16 lg:px-8">
      <div class="w-full">
        <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Hyper-exclusive ad space</p>
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Claim your territory before competitors do</h2>
        <p class="mb-4 max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
          To prevent banner fatigue and maintain a premium user experience, ad inventory is strictly capped per location.
        </p>
        <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
          Because spaces are highly limited for each city, region, and province, your business gets uncrowded exposure.
          Securing a territory means locking out your immediate competitors and ensuring your brand remains the dominant
          choice in your target market.
        </p>
        <ul class="lb-checklist">
          <li class="lb-check-item">
            <span class="lb-check-mark" aria-hidden="true">&#10003;</span>
            Strictly capped inventory per location
          </li>
          <li class="lb-check-item">
            <span class="lb-check-mark" aria-hidden="true">&#10003;</span>
            Uncrowded, premium exposure
          </li>
          <li class="lb-check-item">
            <span class="lb-check-mark" aria-hidden="true">&#10003;</span>
            Lock out your direct competitors
          </li>
        </ul>
      </div>

      <div class="lb-territory-media overflow-hidden rounded-sm">
        <img class="h-full w-full object-cover" src="{{ asset('images/claim-territory-map.jpg') }}" alt="Hands examining a map with a magnifying glass and marking a target location with a red flag pin">
      </div>
    </div>
  </section>

  <section class="bg-accent py-10 md:py-[76px]" id="creative-swaps">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="w-full text-center">
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]">Infinite creative swaps</h2>
        <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
        <p class="mx-auto mt-5 max-w-[560px] text-[0.98rem] leading-[1.7] text-[#141922]">
          Total agility, zero extra fees. Our self-managed dashboard grants you <b>infinite real-time ad swaps</b> for
          your entire campaign window.
        </p>
      </div>

      <div class="ad-solutions-grid">
        <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(0,0,0,0.08)]">
          <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-visuals.svg') }}" alt="">
          <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Pivot Instantly</h3>
          <p class="text-[0.9rem] leading-[1.55] text-muted">Shift your marketing messaging on the fly based on breaking news, changing local weather, or seasonal promotions.</p>
        </article>
        <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(0,0,0,0.08)]">
          <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-measure.svg') }}" alt="">
          <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Continuous Optimization</h3>
          <p class="text-[0.9rem] leading-[1.55] text-muted">Perform limitless A/B testing on your headlines, promo codes, and visual layouts to find the highest-converting combination.</p>
        </article>
        <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(0,0,0,0.08)]">
          <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/fixed-icon.svg') }}" alt="">
          <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Zero Friction</h3>
          <p class="text-[0.9rem] leading-[1.55] text-muted">Update your banner graphics, text, or destination links any time. Changes push live instantly&mdash;no support tickets, no delay.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="sb-section sb-campaign-section" id="how-to-start">
    <div class="sb-shell">
      <div class="sb-campaign-panel">
        <div class="sb-campaign-intro">
          <h2>How to start your Leaderboard campaign</h2>
        </div>

        <ol class="sb-campaign-grid" aria-label="Steps to start a Leaderboard Ads campaign">
          <li class="sb-campaign-step">
            <span class="sb-campaign-step-number">1</span>
            <p><a class="sb-campaign-step-link" href="#top">Register</a> for your self-managed advertiser account.</p>
          </li>
          <li class="sb-campaign-step">
            <span class="sb-campaign-step-number">2</span>
            <p>Select your target geographic tier&mdash;City, District, County, Region, Province, or Country-wide.</p>
          </li>
          <li class="sb-campaign-step">
            <span class="sb-campaign-step-number">3</span>
            <p>Upload your image assets for the Master Leaderboard and in-feed product banners.</p>
          </li>
          <li class="sb-campaign-step">
            <span class="sb-campaign-step-number">4</span>
            <p>Once approved, watch your business take over the homepage through your self-managed dashboard.</p>
          </li>
          <li class="sb-campaign-step">
            <span class="sb-campaign-step-number">5</span>
            <p>Swap creatives, update offers, or change links an unlimited number of times at zero extra cost.</p>
          </li>
        </ol>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 bg-canvas py-16 md:py-[72px]" id="faq">
    <div class="sb-shell grid justify-items-center gap-9">
      <div class="w-full text-center">
        <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]" data-faq-title>Leaderboard Ads, answered</h2>
      </div>

      <div class="grid w-full gap-3" data-faq-list>
        <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(0,0,0,0.08)]" data-faq-item>
          <h3>
            <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-1" id="faq-trigger-1" data-faq-trigger>
              <span class="w-full">Where exactly will my Leaderboard Ad appear?</span>
              <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
            </button>
          </h3>
          <div class="px-5 py-4" id="faq-panel-1" role="region" aria-labelledby="faq-trigger-1" hidden data-faq-panel>
            <p class="text-[0.94rem] leading-[1.7] text-muted">Your brand appears in two homepage zones: the above-the-fold Master Leaderboard banner and as in-feed product banners next to trending products and active listings.</p>
          </div>
        </article>

        <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(0,0,0,0.08)]" data-faq-item>
          <h3>
            <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-2" id="faq-trigger-2" data-faq-trigger>
              <span class="w-full">How precisely can I target my location?</span>
              <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
            </button>
          </h3>
          <div class="px-5 py-4" id="faq-panel-2" role="region" aria-labelledby="faq-trigger-2" hidden data-faq-panel>
            <p class="text-[0.94rem] leading-[1.7] text-muted">You can scale your market boundaries dynamically across City, District, County, Region, Province, or Country-wide zones&mdash;so you only pay for local impressions that matter to your business.</p>
          </div>
        </article>

        <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(0,0,0,0.08)]" data-faq-item>
          <h3>
            <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-3" id="faq-trigger-3" data-faq-trigger>
              <span class="w-full">Can I change my creative after the campaign starts?</span>
              <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
            </button>
          </h3>
          <div class="px-5 py-4" id="faq-panel-3" role="region" aria-labelledby="faq-trigger-3" hidden data-faq-panel>
            <p class="text-[0.94rem] leading-[1.7] text-muted">Yes&mdash;you get infinite real-time ad swaps. Update your banner graphics, text, or destination links an unlimited number of times during your campaign window at zero extra cost. Changes push live instantly.</p>
          </div>
        </article>

        <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(0,0,0,0.08)]" data-faq-item>
          <h3>
            <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-4" id="faq-trigger-4" data-faq-trigger>
              <span class="w-full">Why is inventory limited per location?</span>
              <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
            </button>
          </h3>
          <div class="px-5 py-4" id="faq-panel-4" role="region" aria-labelledby="faq-trigger-4" hidden data-faq-panel>
            <p class="text-[0.94rem] leading-[1.7] text-muted">We strictly cap ad inventory per city, region, and province to prevent banner fatigue and maintain a premium user experience. This gives your business uncrowded exposure and locks out your immediate competitors.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

@include('partials.footer')

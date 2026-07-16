@include('partials.header')

  <section class="border-t border-black/10 py-16 md:py-[72px]" id="intro">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto grid max-w-[820px] gap-5 text-center">
        <div>
          <span class="lb-chip">
            <span class="lb-chip-dot" aria-hidden="true"></span>
            An unprecedented national first in Canada
          </span>
        </div>
        <h1 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">The Ultimate Conversion Intercept</h1>
        <p class="text-[1.05rem] font-extrabold tracking-[-0.02em] text-accentDeep">Zero Competitor Noise. 100% Visual Monopoly.</p>
        <p class="text-[0.98rem] leading-[1.7] text-muted">
          Stop wasting your marketing budget on platforms where your brand is buried under algorithmic noise, crowded
          social feeds, or endless pages of search results.
        </p>
        <p class="text-[0.98rem] leading-[1.7] text-muted">
          The <b>Product Details Page Premium Ad</b> is an exclusive, high-impact ad placement engineered for businesses
          that demand undivided consumer attention. When a buyer clicks to view an item&rsquo;s specifications, pricing, and
          contact options, your brand message is guaranteed to load right alongside it. Every single user. Every single view.
        </p>
        <p class="text-[0.98rem] leading-[1.7] text-muted">
          This level of unmissable, hyper-targeted local positioning is completely unprecedented in the country&mdash;giving
          you an absolute visual monopoly at the precise second a purchase decision is being made.
        </p>
        <div class="pt-2">
          <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-accent px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="#secure">Secure your category</a>
        </div>
      </div>
    </div>
  </section>

  <section class="pp-section" id="impression-guarantee">
    <div class="pp-shell">
      <div class="pp-head">
        <span class="pp-eyebrow">
          <span class="pp-eyebrow-dot" aria-hidden="true"></span>
          100% impression guarantee
        </span>
        <h2 class="pp-title">Unmissable <span class="pp-title-accent">above-the-fold</span> placement</h2>
        <p class="pp-intro">
          On typical ad networks, users skip past banners or use ad-blockers. On our platform, your brand message is
          natively woven into the core infrastructure of the product page.
        </p>
      </div>

      <div class="grid gap-5 md:grid-cols-3">
        <article class="pp-card">
          <span class="pp-card-icon"><img src="{{ asset('images/icon-placement.svg') }}" alt=""></span>
          <h3 class="pp-card-title">Guaranteed Eyes on Your Brand</h3>
          <p class="pp-card-text">Every single visitor viewing a product detail page in your target category will view your message. No scrolling required, no exceptions.</p>
        </article>

        <article class="pp-card">
          <span class="pp-card-icon"><img src="{{ asset('images/icon-discovery.svg') }}" alt=""></span>
          <h3 class="pp-card-title">The Last Word Before Checkout</h3>
          <p class="pp-card-text">While homepage ads build broad awareness, this placement catches users at the final conversion step. You are pitching your services to a customer who is already deep in the buying mindset.</p>
        </article>

        <article class="pp-card">
          <span class="pp-card-icon"><img src="{{ asset('images/icon-brand.svg') }}" alt=""></span>
          <h3 class="pp-card-title">An Unprecedented National First</h3>
          <p class="pp-card-text">No other localized platform in Canada offers this level of forced-view contextual placement. It gives your business an unfair advantage over competitors who are stuck using traditional, easy-to-ignore banners.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 py-16 md:py-[76px]" id="contextual-matching">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="w-full text-center">
        <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Contextual matching</p>
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Intercepting the perfect consumer ecosystem</h2>
        <p class="mx-auto max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
          Your ad space functions as a smart, automated referral system. We place your brand on product pages where the
          buyer is practically guaranteed to need your services next.
        </p>
      </div>

      <div class="lb-geo-grid">
        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-targeting.svg') }}" alt=""></span>
          <div>
            <h3>Realtors</h3>
            <p>Your ad appears on high-value asset listings, home good categories, and neighborhood pages&mdash;putting your face in front of local families preparing to move, buy, or sell.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-brand.svg') }}" alt=""></span>
          <div>
            <h3>Dental Clinics &amp; Medical Practices</h3>
            <p>Showcase your family plans, teeth-whitening promos, or corporate packages right next to local health, lifestyle, and wellness listings.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-measure.svg') }}" alt=""></span>
          <div>
            <h3>Law Firms &amp; Insurance Agencies</h3>
            <p>Embed your business solutions, liability coverage, or notary services next to automotive, commercial equipment, or property listings where legal and protection services are legally required.</p>
          </div>
        </article>

        <article class="lb-geo-card">
          <span class="lb-geo-icon"><img src="{{ asset('images/icon-visuals.svg') }}" alt=""></span>
          <div>
            <h3>HVAC, Plumbers &amp; Cabinet Companies</h3>
            <p>Showcase your premium renovations or emergency repair capabilities directly on home improvement, appliance, or fixture pages.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="border-t border-black/10 py-10 md:py-14" id="hyper-local">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 lg:grid-cols-[minmax(0,1fr)_minmax(280px,380px)] lg:gap-16 lg:px-8">
      <div class="w-full">
        <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Hyper-local dominance</p>
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Own your territory, lock out competitors</h2>
        <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
          Our platform lets you restrict this unmissable placement to your exact operating radius. Target your audience
          seamlessly by City, District, County, Region, Province, or Country-wide parameters.
        </p>
        <ul class="lb-checklist">
          <li class="lb-check-item">
            <span class="lb-check-mark" aria-hidden="true">&#10003;</span>
            <span><b>Strictly Capped Allocation:</b> To maintain this premium, high-impact experience, only ONE exclusive business per category can claim a location.</span>
          </li>
          <li class="lb-check-item">
            <span class="lb-check-mark" aria-hidden="true">&#10003;</span>
            <span><b>Total Competitive Lockout:</b> When you secure the product details page ad space for your industry in your city, your direct competitors are entirely locked out. You own the category. Every local user browsing those products sees only you.</span>
          </li>
        </ul>
      </div>

      <div class="flex min-h-[220px] items-center justify-center overflow-hidden rounded-sm bg-accent p-6 sm:min-h-[260px]">
        <div class="relative flex h-full w-full items-center justify-center">
          <div class="absolute right-[18px] top-[18px] inline-grid h-[34px] w-[34px] place-items-center rounded-lg bg-white">
            <img class="h-5 w-5" src="{{ asset('images/stars-icon.svg') }}" alt="">
          </div>
          <img class="w-full max-w-[270px]" src="{{ asset('images/faq-icon.svg') }}" alt="Illustration of one exclusive business per category locking out competitors in a location">
        </div>
      </div>
    </div>
  </section>

  <section class="bg-accent py-10 md:py-[76px]" id="creative-swaps">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="w-full text-center">
        <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]">Self-Managed Infinite Swaps</h2>
        <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
        <p class="mx-auto mt-5 max-w-[560px] text-[0.98rem] leading-[1.7] text-[#141922]">
          Complete control, zero extra fees. Your business is dynamic, and your advertising should be too. Our self-managed
          advertiser dashboard gives you <b>infinite creative swaps</b> with instant live updates.
        </p>
      </div>

      <div class="mx-auto grid w-full max-w-[760px] gap-3.5 sm:grid-cols-2">
        <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(0,0,0,0.08)]">
          <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-visuals.svg') }}" alt="">
          <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Pivot Instantly</h3>
          <p class="text-[0.9rem] leading-[1.55] text-muted">Shift your headline, promotional offer, or call-to-action button in real-time to match sudden shifts in local weather, competitor pricing, or inventory changes.</p>
        </article>
        <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(0,0,0,0.08)]">
          <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="{{ asset('images/icon-measure.svg') }}" alt="">
          <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Continuous Optimization</h3>
          <p class="text-[0.9rem] leading-[1.55] text-muted">Run endless A/B tests on your graphics and copy at zero additional cost to find the exact combination that drives the most phone calls and website clicks.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="bg-ink py-16 text-white md:py-[76px]" id="secure">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="mx-auto grid max-w-[760px] gap-4 text-center">
        <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accent">100% viewability. Zero competition.</p>
        <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-[1.05] tracking-[-0.05em]">Product Details Page Ads</h2>
        <p class="text-[0.98rem] leading-[1.7] text-white/75">
          Welcome to the most powerful local conversion tool in the country. Our Product Details Page Premium Placement
          grants your business an absolute visual monopoly at the final stage of the consumer buying journey.
        </p>
        <p class="text-[0.98rem] leading-[1.7] text-white/75">
          When a user clicks to view a product, your brand message is guaranteed to load on their screen. This unmissable,
          high-intent targeting framework is completely unique to our platform&mdash;offering a marketing edge found nowhere
          else in Canada.
        </p>
      </div>

      <div class="mx-auto grid w-full max-w-[920px] gap-3.5 sm:grid-cols-2">
        <article class="rounded-[18px] border border-white/15 bg-white/[0.03] p-6">
          <h3 class="mb-2 text-[1.02rem] font-extrabold leading-[1.2]">100% Guaranteed Views</h3>
          <p class="text-[0.92rem] leading-[1.6] text-white/70">Every single user who opens a product page in your category views your message. You capture highly qualified local buyers at the exact moment they are ready to transact.</p>
        </article>
        <article class="rounded-[18px] border border-white/15 bg-white/[0.03] p-6">
          <h3 class="mb-2 text-[1.02rem] font-extrabold leading-[1.2]">Exclusive Category Lockout</h3>
          <p class="text-[0.92rem] leading-[1.6] text-white/70">Inventory is strictly limited to one business per industry per location. Secure your territory today (City, Region, or Province-wide) to completely block out your direct competitors and claim 100% of the local market&rsquo;s attention.</p>
        </article>
        <article class="rounded-[18px] border border-white/15 bg-white/[0.03] p-6">
          <h3 class="mb-2 text-[1.02rem] font-extrabold leading-[1.2]">Perfect for Location-Based Leaders</h3>
          <p class="text-[0.92rem] leading-[1.6] text-white/70">The ultimate customer acquisition engine for Realtors, Dental Clinics, Law Firms, Insurance Companies, and Home Service Contractors.</p>
        </article>
        <article class="rounded-[18px] border border-white/15 bg-white/[0.03] p-6">
          <h3 class="mb-2 text-[1.02rem] font-extrabold leading-[1.2]">Infinite Real-Time Freedom</h3>
          <p class="text-[0.92rem] leading-[1.6] text-white/70">Update your ad files, change your phone numbers, or update your promotional text an unlimited number of times during your campaign window with zero hidden fees and instant deployment.</p>
        </article>
      </div>

      <div class="text-center">
        <a class="inline-flex min-h-[52px] items-center justify-center rounded-[12px] bg-accent px-8 text-center text-[0.98rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="{{ route('start.advertising') }}">Secure Your Category and Location Before Your Competitors Do</a>
      </div>
    </div>
  </section>

@include('partials.footer')

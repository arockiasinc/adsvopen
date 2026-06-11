@include('partials.header')

   <section class="border-t border-black/10 py-10">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid gap-4 text-center lg:text-left">
        
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Command the Canadian click!</h2>
          <p class="text-[0.98rem] leading-[1.7] text-muted">
            Own the first impression. Our Premium Panoramic Placement is impossible to ignore, placing your brand front-and-center with Canada&rsquo;s #1 Open Market.
          </p>
          @php
            $audienceWords = ['City wide', 'Region wide', 'District wide', 'County wide', 'Province wide', 'Coast to coast'];
          @endphp
          <p class="text-[0.98rem] font-extrabold leading-[1.7] text-copy">Choose your market!</p>
          <div class="hp-audience-rotator hp-audience-rotator--start" data-word-rotator data-words='@json($audienceWords)'>
            <span class="hp-audience-word" data-typed-output aria-hidden="true">{{ $audienceWords[0] }}</span><span class="hp-audience-cursor" aria-hidden="true"></span>
            <span class="sr-only">Choose your market: {{ implode(', ', $audienceWords) }}.</span>
          </div>
        </div>
      </div>
    </section>

   <section class="border-t border-black/10 py-16 md:py-[72px]" id="hero">
      <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-8">
        <div class="max-w-[520px]">
          <div class="mb-5">
            <span class="inline-grid h-[42px] w-[42px] place-items-center rounded-xl bg-ink shadow-[10px_10px_0_rgba(247,90,6,0.18)]">
              <img class="h-6 w-6" src="images/stars-icon.svg" alt="">
            </span>
          </div>
          <h1 class="mb-[18px] whitespace-nowrap text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em]">Panoramic Ads</h1>
          <p class="mb-7 max-w-[36ch] text-[0.98rem] leading-[1.7] text-muted">
            <b>Massive Reach and Brand Awareness</b><br/>

            This is perfect for &ldquo;top of funnel&rdquo; marketing&mdash;making sure people know you exist before they
            even realize they need your product.
          </p>
          <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-accent px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="#benefits">Register</a>
        </div>

        <div class="flex justify-center lg:justify-end">
          {{-- VOpen Market website mock with the Panoramic Ad placed at the top of the homepage --}}
          <figure class="vm-mock w-full max-w-[620px]" aria-label="Panoramic Ad shown at the top of the VOpen Market homepage">
            <div class="vm-mock-window">
              <div class="vm-mock-chrome" aria-hidden="true">
                <span class="vm-mock-dot vm-mock-dot--red"></span>
                <span class="vm-mock-dot vm-mock-dot--amber"></span>
                <span class="vm-mock-dot vm-mock-dot--green"></span>
                <span class="vm-mock-address">vopenmarket.com</span>
              </div>

              <div class="vm-mock-page">
                <div class="vm-mock-siteheader" aria-hidden="true">
                  <img class="vm-mock-sitelogo" src="images/logo.webp" alt="VOpen Market">
                  <nav class="vm-mock-sitenav">
                    <span></span><span></span><span></span><span></span>
                  </nav>
                  <span class="vm-mock-searchpill"></span>
                </div>

                {{-- The Panoramic Advertisement: logo top-left, message center, website bottom-right --}}
                <div class="vm-mock-ad" role="img" aria-label="Your panoramic advertisement: your logo top left, your message in the center, your website bottom right">
                  <span class="vm-mock-ad-tag">Ad</span>
                  <span class="vm-mock-ad-logo">YOUR&nbsp;LOGO</span>
                  <span class="vm-mock-ad-message">Your Message Here</span>
                  <span class="vm-mock-ad-site">www.yourwebsite.com</span>
                </div>

                <div class="vm-mock-grid" aria-hidden="true">
                  <span></span><span></span><span></span>
                  <span></span><span></span><span></span>
                </div>
              </div>
            </div>
            <figcaption class="vm-mock-caption">Your Panoramic Ad dominates the top of the VOpen Market homepage.</figcaption>
          </figure>
        </div>
      </div>
    </section>

    <section class="pp-section" id="prominent-placement">
      <div class="pp-shell">
        <div class="pp-head">
          <span class="pp-eyebrow">
            <span class="pp-eyebrow-dot" aria-hidden="true"></span>
            Prominent placement
          </span>
          <h2 class="pp-title">Dominate the Homepage: <span class="pp-title-accent">The Panoramic Advertisement</span></h2>
          <p class="pp-intro">
            Conquer your territory with absolute visibility. Our premium Panoramic Advertisement is a cinematic,
            wide-format canvas engineered to sit at the absolute apex of our homepage. It is the very first thing
            every visitor sees, ensuring your brand controls the narrative from the millisecond the page loads.
          </p>
        </div>

        <div class="pp-grid">
          <article class="pp-card">
            <span class="pp-card-icon"><img src="images/icon-placement.svg" alt=""></span>
            <h3 class="pp-card-title">Exclusive Digital Real Estate</h3>
            <p class="pp-card-text">We strictly limit the number of available slots. Your brand will never be buried in a crowded sea of competing tiles or sidebars.</p>
          </article>

          <article class="pp-card">
            <span class="pp-card-icon"><img src="images/fixed-icon.png" alt=""></span>
            <h3 class="pp-card-title">Predictable, Fixed Pricing</h3>
            <p class="pp-card-text">Say goodbye to volatile auction environments and unpredictable bidding. Lock in the flat rate to completely control your marketing budget with zero financial surprises.</p>
          </article>

          <article class="pp-card">
            <span class="pp-card-icon"><img src="images/icon-visuals.svg" alt=""></span>
            <h3 class="pp-card-title">High-Impact Wide Canvas</h3>
            <p class="pp-card-text">The ultra-wide banner proportions give your design team massive creative freedom to deliver bold imagery, sharp messaging, and undeniable calls-to-action.</p>
          </article>

          <article class="pp-card">
            <span class="pp-card-icon"><img src="images/icon-targeting.svg" alt=""></span>
            <h3 class="pp-card-title">Territorial Ownership</h3>
            <p class="pp-card-text">Select your target zone and command full authority over that demographic. This is your chance to block out competitors and establish complete market dominance.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 py-10 md:py-14" id="how-it-works">
      <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-8">
        <div class="order-first flex min-h-[220px] items-center justify-center overflow-hidden rounded-sm bg-accent p-6 sm:min-h-[260px]">
          <div class="relative flex h-full w-full items-center justify-center">
            <div class="absolute right-[18px] top-[18px] inline-grid h-[34px] w-[34px] place-items-center rounded-lg bg-white">
              <img class="h-5 w-5" src="images/stars-icon.svg" alt="">
            </div>
            <img class="w-full max-w-[340px]" src="images/workflow-illustration.svg" alt="Illustrated workflow showing products, creative, and discovery touchpoints">
          </div>
        </div>

        <div class="w-full">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">How does Panoramic Ads work?</h2>
          <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
            Panoramic Ads combine a headline, brand identity, and featured products in a single ad experience.
            Shoppers can discover several products at once and continue on to a product page or curated brand destination.
          </p>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 py-10 md:py-14" id="importance">
      <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 lg:grid-cols-[minmax(0,1fr)_minmax(280px,380px)] lg:gap-16 lg:px-8">
        <div class="w-full">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Why is Panoramic Ads important?</h2>
          <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
            This format gives brands stronger control over how they show up during discovery. It helps build awareness,
            encourages product exploration, and supports a more memorable brand presence than single-product ads alone.
          </p>
        </div>

        <div class="flex min-h-[220px] items-center justify-center overflow-hidden rounded-sm bg-panel p-7 sm:min-h-[260px]">
          <img class="w-full max-w-[270px]" src="images/faq-icon.svg" alt="Illustration representing brand awareness and recognition">
        </div>
      </div>
    </section>

    <div class="relative">
      <div class="hp-anchor-group" aria-hidden="true">
        <span class="hp-anchor" id="placements"></span>
      </div>

      <section class="border-t border-black/10 py-10 md:py-[72px]" aria-labelledby="ad-solutions-heading">
        <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
          <div class="w-full text-center">
            <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]" id="ad-solutions-heading">Ad solutions that work</h2>
            <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
          </div>

          <div class="ad-solutions-grid">
            <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/fixed-icon.png" alt="Fixed and transparent fees icon">
              <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Fixed &amp; Transparent Fees</h3>
              <p class="text-[0.9rem] leading-[1.55] text-muted">No cost-per-click means your ads can run during regular business hours or 24/7, on weekdays or weekends. You stay in control of your spending.</p>
            </article>

            <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/start-small.jpg" alt="Start small icon">
              <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Start Small</h3>
              <p class="text-[0.9rem] leading-[1.55] text-muted">Begin with a smaller ad budget and increase your spend as your sales grow. Scale at a pace that works for your business.</p>
            </article>

            <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/plan-your-budget.png" alt="Plan your ad budget icon">
              <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Plan Your Ad Budget</h3>
              <p class="text-[0.9rem] leading-[1.55] text-muted">No surprise fees, no pay-per-view charges, and no cost-per-click. Your advertisement stays visible without unexpected costs.</p>
            </article>
          </div>
        </div>
      </section>
    </div>

    <section class="bg-accent py-10 md:py-[76px]" id="benefits">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="w-full text-center">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]">Benefits of display ads</h2>
          <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
        </div>

        <div class="grid gap-[14px] md:grid-cols-2">
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-placement.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Prominent placement</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Show up at the top of search results and product pages to capture attention at key moments in the shopper journey.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-targeting.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Reach relevant shoppers</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Reach shoppers who matter most to your business through precise keyword and product targeting.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-brand.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Showcase your brand</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Use creatives and collections to highlight your catalog and build brand recognition.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-discovery.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Inspire product discovery</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Drive traffic to your Brand Store or product page that support product evaluation and catalogue discovery.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-measure.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Measure your brand-building efforts</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Get insights into how and which shoppers engage with your ads to understand your brand’s impact.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-ink py-16 md:py-[76px]" id="courses">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="w-full text-center">
          <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Learning path</p>
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-white">Panoramic Ads courses</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 01</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Get started with Panoramic Ads</h3>
            <p class="text-[0.98rem] leading-[1.7] text-white">Build a foundational understanding of campaign setup, creative choices, and measurement.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-white transition" href="#courses">
              Start learning
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 02</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Drive discoverability with Panoramic Ads</h3>
            <p class="text-[0.98rem] leading-[1.7] text-white">Explore tactics that help more shoppers find your brand across key browsing and search moments.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-white transition" href="#courses">
              View course
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 03</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Adopt Panoramic Ads reporting</h3>
            <p class="text-[0.98rem] leading-[1.7] text-white">Learn which metrics matter most when you want to optimize visibility and campaign quality over time.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-white transition" href="#courses">
              Read overview
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 py-16 md:py-[76px]" id="guides">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="w-full text-center">
          <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Practical reads</p>
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Panoramic Ads guides</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 01</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Your complete guide to Panoramic Ads with AdsVOpen</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">Understand campaign formats, placements, and how to structure a stronger branded discovery experience.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#guides">
              Read guide
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 02</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">How to get started with Panoramic Ads video ads</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">Use a simple framework to launch creative that is focused, easy to digest, and ready for mobile shoppers.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#video-campaign">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 03</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">A guide to setting up Panoramic Ads video creative</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">Follow a checklist for preparing assets, selecting products, and refining campaign targeting choices.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#partner-support">
              Open guide
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-[radial-gradient(circle_at_top_right,rgba(247,90,6,0.12),transparent_34%),linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,248,239,0.96))] py-16 md:py-[76px]" id="video-campaign">
      <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-8">
        <div class="flex justify-center">
          <div class="w-full max-w-[260px] rounded-[22px] border border-black/10 bg-white p-[18px] shadow-soft">
            <img class="w-full rounded-xl bg-white" src="images/placement-mobile.svg" alt="Panoramic Ads mobile video placement">
          </div>
        </div>

        <div class="grid gap-5">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Creative formats</p>
          <h2 class="max-w-[560px] text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Use video in your Panoramic Ads campaign</h2>
          <p class="max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
            Panoramic Ads video helps visually highlight key product benefits directly in shopping results,
            giving your campaign a more dynamic and memorable presence.
          </p>
          <p class="max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
            Use your Panoramic Ads video asset to stand out from nearby placements, showcase product value quickly,
            and move shoppers closer to purchase intent.
          </p>
          <div>
            <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-accent px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="#partner-support">Learn more</a>
          </div>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-canvas py-10" id="creative-support">
      <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-center gap-5 px-6 text-center lg:flex-nowrap lg:justify-between lg:px-8">
        <div class="grid gap-4">
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">No video? No problem</h2>
          <p class="max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
            Explore creative support options, production guidance, and partner services that can help you launch faster.
          </p>
        </div>
        <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-ink px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#partner-support">Explore options</a>
      </div>
    </section>

    <section class="border-t border-black/10 bg-[radial-gradient(circle_at_top_right,rgba(247,90,6,0.12),transparent_34%),linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,248,239,0.96))] py-16 md:py-[76px]" id="partner-support">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="grid gap-5">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-copy">Partner directory</p>
          <h2 class="text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em] text-copy">Get support from a <span class="text-accentDeep">partner that specializes in Panoramic Ads campaigns</span></h2>
          <p class="text-[0.98rem] leading-[1.7] text-muted">
            AdsVOpen partners are a community of Canadian agencies and technology providers that offer a variety of
            services at different price points. Partners can help you launch, manage and optimize your panoramic ad campaigns,
            which can save you time and help you get the most from your placements across the Canadian Open Market.
          </p>
          <div>
            <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-ink px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#partner-support">View all partners</a>
          </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <div class="inline-grid place-items-center rounded-[18px] border border-black/10 bg-canvas p-6 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="h-[42px] w-[42px]" src="images/icon-brand.svg" alt="Sample partner image for AiHello AutoPilo">
            </div>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">AiHello AutoPilo</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Grow revenues and reduce work hours spent on panoramic ad management with automated placement discovery and
              continuous campaign optimization from AiHello.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#partner-support">
              Contact partner
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <div class="inline-grid place-items-center rounded-[18px] border border-black/10 bg-canvas p-6 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="h-[42px] w-[42px]" src="images/icon-discovery.svg" alt="Sample partner image for Perpetua">
            </div>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Perpetua</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Perpetua provides growth optimization and intelligence technology, allowing sellers to create goals and
              rely on Perpetua&rsquo;s AI-powered ad engine to execute tactically.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#partner-support">
              Contact partner
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <div class="inline-grid place-items-center rounded-[18px] border border-black/10 bg-canvas p-6 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
              <img class="h-[42px] w-[42px]" src="images/icon-measure.svg" alt="Sample partner image for Helium 10">
            </div>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Helium 10</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              From opportunity seekers, to full-time sellers, brands, agencies and everyone in between, Helium 10
              champions sellers of all stages with the tools to succeed.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#partner-support">
              Contact partner
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
        </div>

        <p class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">
          Advertisers observed a <strong class="text-accentDeep">18% increase</strong> in brand reach 6 months after
          <span class="text-accentDeep">working with an AdsVOpen Partner</span>
        </p>
      </div>
    </section>

    <section class="border-t border-black/10 bg-[radial-gradient(circle_at_top_right,rgba(247,90,6,0.12),transparent_34%),linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,248,239,0.96))] py-16 md:py-[76px]" id="latest-news">
      <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:px-8">
        <div class="grid w-full gap-5">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Product announcements</p>
          <h2 class="text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em] text-copy">What&apos;s new with Panoramic Ads</h2>
          <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
            Browse the latest Panoramic Ads feature releases and enhancements designed to help advertisers build
            stronger visibility, sharper measurement, and more relevant shopper journeys.
          </p>
          <div>
            <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-ink px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#latest-news">Browse the latest news</a>
          </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 01</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Secure branded visibility with Panoramic Ads reserve share of voice</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Advertisers can now reserve Panoramic Ads top-of-search placements for branded keywords at a fixed,
              upfront price, helping maintain consistent visibility when shoppers search for your brand.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#latest-news">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>

          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 02</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Enhancements to branded search metrics</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Branded search metrics now better identify when advertising influences shoppers to search for brand
              names, trademarks, and common variations like abbreviations.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#latest-news">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>

          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 03</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">New audiences for bid adjustment for Panoramic Ads worldwide</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Panoramic Ads adds two new audiences, purchased brand products and clicked or added to cart, to help
              advertisers re-engage high-value shoppers and drive repeat purchases worldwide.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#latest-news">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>

          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 04</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Panoramic Ads is now available for single-book authors</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Single-book authors can now create eye-catching video and custom image ads to showcase a single book to
              their audience in prominent Panoramic Ads placements.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#latest-news">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
        </div>
      </div>
    </section>

    <section class="sb-section sb-campaign-section" id="campaign-setup">
      <div class="sb-shell">
        <div class="sb-campaign-panel">
        

          <div class="sb-campaign-intro">
            <h2>How do I create a Panoramic Ads campaign?</h2>
            <a class="sb-campaign-cta" href="#top">Register</a>
          </div>

          <ol class="sb-campaign-grid" aria-label="Steps to create a Panoramic Ads campaign">
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">1</span>
              <p>Register for <a href="#top">sponsored ads</a>.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">2</span>
              <p>Sign in to your account, click &ldquo;Create campaign,&rdquo; and choose Panoramic Ads. Give your campaign a name and choose your settings.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">3</span>
              <p>Choose the campaign goal that aligns with your business objective.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">4</span>
              <p>Select your ad format. For assistance with building video creative, use <a href="#how-it-works">Video Generator</a> in the &ldquo;Creative tools&rdquo; tab or get help from trusted service providers.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">5</span>
              <p>Under &ldquo;Landing page,&rdquo; select whether you want to drive shoppers directly to your Brand Store or to a product detail page.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">6</span>
              <p>Define your targeting strategy and select bids for your campaign, or use our recommendations.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">7</span>
              <p>Upload your creative, which can be a static image or video that features a product or brand.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">8</span>
              <p>Submit your ad. It will be reviewed within 72 hours.</p>
              <a class="sb-campaign-step-link" href="#top">Register</a>
            </li>
          </ol>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-canvas py-16 md:py-[72px]" id="faq">
      <div class="sb-shell grid justify-items-center gap-9">
        <div class="w-full text-center">
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]" data-faq-title>Frequently asked questions, answered</h2>
        </div>

        <div class="grid w-full gap-3" data-faq-list>
          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-1" id="faq-trigger-1" data-faq-trigger>
                <span class="w-full">How much does Panoramic Ads cost?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-1" role="region" aria-labelledby="faq-trigger-1" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Panoramic Ads uses a cost-per-click model, so you decide how much to bid and set the budget that fits your goals. You only pay when shoppers click your ad.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-2" id="faq-trigger-2" data-faq-trigger>
                <span class="w-full">How can I measure results from my Panoramic Ads campaign?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-2" role="region" aria-labelledby="faq-trigger-2" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Use reporting in the advertising console to review impressions, clicks, spend, sales, return on ad spend, and new-to-brand performance. These metrics help you understand both reach and downstream outcomes.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-3" id="faq-trigger-3" data-faq-trigger>
                <span class="w-full">Who can use Panoramic Ads?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-3" role="region" aria-labelledby="faq-trigger-3" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Panoramic Ads is available to eligible sellers, vendors, book vendors, and agencies with enrolled brands and products that meet marketplace requirements.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-4" id="faq-trigger-4" data-faq-trigger>
                <span class="w-full">What categories are not eligible for Panoramic Ads?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-4" role="region" aria-labelledby="faq-trigger-4" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Eligibility can vary by marketplace, but restricted, prohibited, or sensitive product categories may not qualify. Check the latest ad policy and product eligibility guidance for your account before launching.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-5" id="faq-trigger-5" data-faq-trigger>
                <span class="w-full">What are new-to-brand metrics, and why should I use them?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-5" role="region" aria-labelledby="faq-trigger-5" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">New-to-brand metrics show orders and sales from shoppers who have not purchased your brand within the lookback window. They help you evaluate how well your campaign is bringing in first-time customers.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-6" id="faq-trigger-6" data-faq-trigger>
                <span class="w-full">What are the different goals I can achieve with Panoramic Ads?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-6" role="region" aria-labelledby="faq-trigger-6" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">You can use Panoramic Ads to build awareness, drive consideration, grow Store visits, promote product discovery, and support sales across a collection of products or a featured video creative.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-7" id="faq-trigger-7" data-faq-trigger>
                <span class="w-full">What are the video specification requirements for Panoramic Ads video?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-7" role="region" aria-labelledby="faq-trigger-7" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Use a high-resolution video file that meets the platform requirements for aspect ratio, duration, file size, and safe-area placement. Keep branding and product messaging clear so the creative remains effective across placements.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

  @include('partials.footer')

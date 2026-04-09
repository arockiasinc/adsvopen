@include('partials.header')

   <section class="border-t border-black/10 py-16 md:py-[72px]" id="hero">
      <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:gap-16 lg:px-8">
        <div class="max-w-[430px]">
          <div class="mb-5">
            <span class="inline-grid h-[42px] w-[42px] place-items-center rounded-xl bg-ink shadow-[10px_10px_0_rgba(247,90,6,0.18)]">
              <img class="h-6 w-6" src="images/stars-icon.svg" alt="">
            </span>
          </div>
          <h1 class="mb-[18px] text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em]">Sponsored<br>Brands</h1>
          <p class="mb-7 max-w-[36ch] text-[0.98rem] leading-[1.7] text-muted">
            Sponsored Brands help advertisers introduce their brand and product range in high-visibility placements.
            Use headline-led creative, custom imagery, and product collections to stand out early in the shopping journey.
          </p>
          <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-accent px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accentDeep focus-visible:-translate-y-0.5 focus-visible:bg-accentDeep" href="#benefits">Register</a>
        </div>

        <div class="flex justify-center lg:justify-end">
          <div class="w-full max-w-[620px] rounded-[18px] bg-gradient-to-b from-[#2d3548] to-[#20293b] p-[14px_14px_18px] shadow-soft sm:p-[18px_22px_26px]">
            <img class="w-full rounded-xl bg-white" src="images/placement-desktop.svg" alt="Sponsored Brands placement shown on a laptop screen">
          </div>
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
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">How does Sponsored Brands work?</h2>
          <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
            Sponsored Brands ads combine a headline, brand identity, and featured products in a single ad experience.
            Shoppers can discover several products at once and continue on to a product page or curated brand destination.
          </p>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 py-10 md:py-14" id="importance">
      <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 lg:grid-cols-[minmax(0,1fr)_minmax(280px,380px)] lg:gap-16 lg:px-8">
        <div class="w-full">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Why is Sponsored Brands important?</h2>
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

    <section class="border-t border-black/10 py-10 md:py-[72px]" id="placements">
      <div class="mx-auto grid max-w-7xl justify-items-center gap-9 px-6 lg:px-8">
        <div class="w-full">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em]">Where do Sponsored Brands ads appear?</h2>
          <div class="h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
        </div>

        <section class="w-full max-w-[760px]" aria-label="Sponsored Brands placement examples" data-carousel>
          <div class="grid gap-5 rounded-[22px] border border-black/10 bg-[radial-gradient(circle_at_top_right,rgba(247,90,6,0.12),transparent_34%),linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,248,239,0.96))] p-[18px] shadow-soft sm:gap-6 sm:rounded-[28px] sm:p-7">
            <div class="relative min-h-[470px] sm:min-h-[500px] lg:min-h-[520px]">
              <figure class="absolute inset-0 grid translate-y-0 content-start justify-items-center gap-[18px] opacity-100 transition duration-300 ease-out visible pointer-events-auto" data-slide>
                <div class="w-full max-w-[560px] rounded-[18px] bg-gradient-to-b from-[#2d3548] to-[#20293b] p-[14px_14px_18px] shadow-soft sm:p-[18px_22px_26px]">
                  <img class="w-full rounded-xl bg-white" src="images/placement-desktop.svg" alt="Sponsored Brands placement at the top of Amazon search results">
                </div>
                <figcaption class="grid max-w-[480px] justify-items-center gap-2.5 text-center">
                  <span class="rounded-full bg-accent/10 px-[10px] py-1.5 text-[0.75rem] font-extrabold uppercase tracking-[0.08em] text-accentDeep">Placement 01</span>
                  <strong class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em]">Top of search results on Amazon</strong>
                  <p class="max-w-[42ch] text-[0.98rem] leading-[1.7] text-muted">Lead with your brand and feature a group of products before shoppers scroll deeper.</p>
                </figcaption>
              </figure>

              <figure class="absolute inset-0 grid translate-y-2 content-start justify-items-center gap-[18px] opacity-0 transition duration-300 ease-out invisible pointer-events-none" data-slide>
                <div class="w-full max-w-[560px] rounded-[18px] bg-gradient-to-b from-[#2d3548] to-[#20293b] p-[14px_14px_18px] shadow-soft sm:p-[18px_22px_26px]">
                  <img class="w-full rounded-xl bg-white" src="images/placement-mobile.svg" alt="Sponsored Brands mobile placement example">
                </div>
                <figcaption class="grid max-w-[480px] justify-items-center gap-2.5 text-center">
                  <span class="rounded-full bg-accent/10 px-[10px] py-1.5 text-[0.75rem] font-extrabold uppercase tracking-[0.08em] text-accentDeep">Placement 02</span>
                  <strong class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em]">Mobile-first product discovery</strong>
                  <p class="max-w-[42ch] text-[0.98rem] leading-[1.7] text-muted">Stay visible on smaller screens with creative that keeps browsing simple and focused.</p>
                </figcaption>
              </figure>

              <figure class="absolute inset-0 grid translate-y-2 content-start justify-items-center gap-[18px] opacity-0 transition duration-300 ease-out invisible pointer-events-none" data-slide>
                <div class="w-full max-w-[560px] rounded-[18px] bg-gradient-to-b from-[#2d3548] to-[#20293b] p-[14px_14px_18px] shadow-soft sm:p-[18px_22px_26px]">
                  <img class="w-full rounded-xl bg-white" src="images/placement-home.svg" alt="Sponsored Brands branded discovery placement example">
                </div>
                <figcaption class="grid max-w-[480px] justify-items-center gap-2.5 text-center">
                  <span class="rounded-full bg-accent/10 px-[10px] py-1.5 text-[0.75rem] font-extrabold uppercase tracking-[0.08em] text-accentDeep">Placement 03</span>
                  <strong class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em]">Brand-led discovery moments</strong>
                  <p class="max-w-[42ch] text-[0.98rem] leading-[1.7] text-muted">Use richer layouts to introduce your storefront feel and invite shoppers into a wider range.</p>
                </figcaption>
              </figure>
            </div>

            <div class="flex items-center justify-center gap-3 sm:gap-4">
              <button class="inline-grid h-10 w-10 place-items-center rounded-full bg-ink text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent sm:h-11 sm:w-11" type="button" data-direction="prev" aria-label="Show previous placement">
                <span aria-hidden="true">&#8592;</span>
              </button>
              <div class="flex items-center gap-2.5" aria-label="Choose placement slide">
                <button class="h-2.5 w-2.5 rounded-full bg-accent scale-110 transition" type="button" aria-label="Show placement 1" aria-pressed="true" data-dot="0"></button>
                <button class="h-2.5 w-2.5 rounded-full bg-ink/20 transition" type="button" aria-label="Show placement 2" aria-pressed="false" data-dot="1"></button>
                <button class="h-2.5 w-2.5 rounded-full bg-ink/20 transition" type="button" aria-label="Show placement 3" aria-pressed="false" data-dot="2"></button>
              </div>
              <button class="inline-grid h-10 w-10 place-items-center rounded-full bg-ink text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent sm:h-11 sm:w-11" type="button" data-direction="next" aria-label="Show next placement">
                <span aria-hidden="true">&#8594;</span>
              </button>
            </div>
          </div>
        </section>
      </div>
    </section>

    <section class="bg-accent py-10 md:py-[76px]" id="benefits">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="w-full text-center">
          <h2 class="mb-4 text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-[#141922]">Benefits of Sponsored Brands</h2>
          <div class="mx-auto h-px w-full max-w-[260px] bg-black/10" aria-hidden="true"></div>
        </div>

        <div class="grid gap-[14px] md:grid-cols-2">
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-placement.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Prominent placement</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Show up in premium positions that attract attention early.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-targeting.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Reach relevant shoppers</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Use keyword and product targeting to find high-intent audiences.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-brand.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Showcase your brand</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Feature your logo, message, and product range in one ad unit.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-visuals.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Create custom visuals</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Use bold imagery that makes your campaign feel intentional.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-discovery.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Inspire product discovery</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Guide shoppers toward more products and deeper brand exploration.</p>
          </article>
          <article class="border border-black/10 bg-white px-5 py-6 text-center shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <img class="mx-auto mb-[14px] h-[38px] w-[38px]" src="images/icon-measure.svg" alt="">
            <h3 class="mb-2.5 text-base font-extrabold leading-[1.2]">Measure your brand-building efforts</h3>
            <p class="text-[0.9rem] leading-[1.55] text-muted">Track clicks, engagement, and campaign impact over time.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-white py-16 md:py-[72px]" id="case-studies">
      <div class="sb-case-studies mx-auto max-w-7xl px-6 lg:px-8">
        <div class="sb-case-studies-heading">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Case studies</p>
          <h2 class="max-w-[520px] text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Sponsored Brands case studies</h2>
          <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-ink px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#guides">View all case studies</a>
        </div>

        <div class="sb-case-studies-list">
          <article class="sb-case-study-row">
            <div class="sb-case-study-media">
              <img class="sb-case-study-image" src="images/case-study-one.svg" alt="Sample Sponsored Brands case study illustration with performance highlights">
            </div>

            <div class="sb-case-study-copy">
              <div class="grid content-start gap-4 text-left">
                <h3 class="sb-case-study-title">Brand in Japan stays top of mind using Sponsored Brands</h3>
                <p class="text-[0.98rem] leading-[1.7] text-muted">After launching a sponsored ads campaign in 2015, NF Imports has amplified their brand using Sponsored Brands. See how they&rsquo;re championing advertising best practices.</p>
                <a class="sb-case-study-link inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition" href="#benefits">
                  Learn more
                  <span aria-hidden="true">&#8594;</span>
                </a>
              </div>
            </div>

            <aside class="sb-case-study-metrics" aria-label="Key learnings">
              <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Key learnings</p>
              <div class="sb-case-study-stat">
                <strong class="sb-case-study-stat-value">80%</strong>
                <p class="mt-4 text-[0.9rem] leading-[1.55] text-muted">Observed that 80% of sales from new customers between March 2018 and December 2022.</p>
              </div>
              <div class="sb-case-study-stat">
                <strong class="sb-case-study-stat-value">30%</strong>
                <p class="mt-4 text-[0.9rem] leading-[1.55] text-muted">Steady growth of 30% in sales between December 2019 and November 2022.</p>
              </div>
            </aside>
          </article>

          <article class="sb-case-study-row">
            <div class="sb-case-study-media">
              <img class="sb-case-study-image" src="images/case-study-two.svg" alt="Sample Sponsored Brands video case study illustration with campaign growth highlights">
            </div>

            <div class="sb-case-study-copy">
              <div class="grid content-start gap-4 text-left">
                <h3 class="sb-case-study-title">HP finds success with Sponsored Brands video</h3>
                <p class="text-[0.98rem] leading-[1.7] text-muted">Using Sponsored Brands video, Sponsored Brands, Sponsored Products, and display ads, HP expands their reach globally.</p>
                <a class="sb-case-study-link inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition" href="#video-campaign">
                  Learn more
                  <span aria-hidden="true">&#8594;</span>
                </a>
              </div>
            </div>

            <aside class="sb-case-study-metrics" aria-label="Key learnings">
              <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Key learnings</p>
              <div class="sb-case-study-stat">
                <strong class="sb-case-study-stat-value">224%</strong>
                <p class="mt-4 text-[0.9rem] leading-[1.55] text-muted">Impressions grew 224% YoY, extending HP&rsquo;s reach across all product categories.</p>
              </div>
              <div class="sb-case-study-stat">
                <strong class="sb-case-study-stat-value">142%</strong>
                <p class="mt-4 text-[0.9rem] leading-[1.55] text-muted">142% YoY increase in clicks, yielding a 42% increase in clicks for Sponsored Brands video placements.</p>
              </div>
            </aside>
          </article>
        </div>
      </div>
    </section>

    <section class="border-t border-black/10 bg-ink py-16 md:py-[76px]" id="courses">
      <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
        <div class="w-full text-center">
          <p class="mb-4 text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Learning path</p>
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-white">Sponsored Brands courses</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 01</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Get started with Sponsored Brands</h3>
            <p class="text-[0.98rem] leading-[1.7] text-white">Build a foundational understanding of campaign setup, creative choices, and measurement.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-white transition" href="#courses">
              Start learning
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 02</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Drive discoverability with Sponsored Brands</h3>
            <p class="text-[0.98rem] leading-[1.7] text-white">Explore tactics that help more shoppers find your brand across key browsing and search moments.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-white transition" href="#courses">
              View course
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-panel p-7 shadow-soft">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Course 03</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-white">Adopt Sponsored Brands reporting</h3>
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
          <h2 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Sponsored Brands guides</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 01</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Your complete guide to Sponsored Brands with Amazon Ads</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">Understand campaign formats, placements, and how to structure a stronger branded discovery experience.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#guides">
              Read guide
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 02</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">How to get started with Sponsored Brands video ads</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">Use a simple framework to launch creative that is focused, easy to digest, and ready for mobile shoppers.</p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#video-campaign">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <span class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Guide 03</span>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">A guide to setting up Sponsored Brands video creative</h3>
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
            <img class="w-full rounded-xl bg-white" src="images/placement-mobile.svg" alt="Sponsored Brands mobile video placement">
          </div>
        </div>

        <div class="grid gap-5">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Creative formats</p>
          <h2 class="max-w-[560px] text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Use video in your Sponsored Brands campaign</h2>
          <p class="max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
            Sponsored Brands video helps visually highlight key product benefits directly in shopping results,
            giving your campaign a more dynamic and memorable presence.
          </p>
          <p class="max-w-[560px] text-[0.98rem] leading-[1.7] text-muted">
            Use your Sponsored Brands video asset to stand out from nearby placements, showcase product value quickly,
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
          <h2 class="text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em] text-copy">Get support from a <span class="text-accentDeep">partner that specializes in Sponsored Brands campaigns</span></h2>
          <p class="text-[0.98rem] leading-[1.7] text-muted">
            Amazon Ads partners are a global community of technology partners and agencies that offer a variety of
            services at different price points. Partners can help you launch, manage and optimize your ad campaigns,
            which can save you time and help you get the most from your advertising.
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
              Grow revenues and reduce work hours spent on Amazon ads management with automated keyword discovery and
              continuous bid modifications from AiHello.
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
          Sellers observed a <strong class="text-accentDeep">18% increase</strong> in gross merchandise sales 6 months after
          <span class="text-accentDeep">working with an Amazon Ads Partner</span>
        </p>
      </div>
    </section>

    <section class="border-t border-black/10 bg-[radial-gradient(circle_at_top_right,rgba(247,90,6,0.12),transparent_34%),linear-gradient(180deg,rgba(255,255,255,0.96),rgba(255,248,239,0.96))] py-16 md:py-[76px]" id="latest-news">
      <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:px-8">
        <div class="grid w-full gap-5">
          <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Product announcements</p>
          <h2 class="text-[clamp(3rem,8vw,4.7rem)] font-black leading-[0.94] tracking-[-0.07em] text-copy">What&apos;s new with Sponsored Brands</h2>
          <p class="max-w-[520px] text-[0.98rem] leading-[1.7] text-muted">
            Browse the latest Sponsored Brands feature releases and enhancements designed to help advertisers build
            stronger visibility, sharper measurement, and more relevant shopper journeys.
          </p>
          <div>
            <a class="inline-flex min-h-[46px] items-center justify-center rounded-[10px] bg-ink px-[22px] text-[0.94rem] font-bold text-white transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#latest-news">Browse the latest news</a>
          </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 01</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Secure branded visibility with Sponsored Brands reserve share of voice</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Advertisers can now reserve Sponsored Brands top-of-search placements for branded keywords at a fixed,
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
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">New audiences for bid adjustment for Sponsored Brands worldwide</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Sponsored Brands adds two new audiences, purchased brand products and clicked or added to cart, to help
              advertisers re-engage high-value shoppers and drive repeat purchases worldwide.
            </p>
            <a class="inline-flex items-center gap-3 text-[0.94rem] font-bold text-copy transition hover:text-copy focus-visible:text-copy" href="#latest-news">
              Learn more
              <span aria-hidden="true">&#8594;</span>
            </a>
          </article>

          <article class="grid min-h-[220px] gap-4 rounded-[22px] border border-black/10 bg-white p-7 shadow-[0_10px_20px_rgba(86,29,0,0.08)]">
            <p class="text-[0.75rem] font-black uppercase tracking-[0.08em] text-accentDeep">Update 04</p>
            <h3 class="text-[clamp(1.1rem,3vw,1.55rem)] font-extrabold leading-[1.1] tracking-[-0.04em] text-[#141922]">Sponsored Brands is now available for single-book authors</h3>
            <p class="text-[0.98rem] leading-[1.7] text-muted">
              Single-book authors can now create eye-catching video and custom image ads to showcase a single book to
              their audience in prominent Sponsored Brands placements.
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
            <h2>How do I create a Sponsored Brands campaign?</h2>
            <a class="sb-campaign-cta" href="#top">Register</a>
          </div>

          <ol class="sb-campaign-grid" aria-label="Steps to create a Sponsored Brands campaign">
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">1</span>
              <p>Register for <a href="#top">sponsored ads</a>.</p>
            </li>
            <li class="sb-campaign-step">
              <span class="sb-campaign-step-number">2</span>
              <p>Sign in to your account, click &ldquo;Create campaign,&rdquo; and choose Sponsored Brands. Give your campaign a name and choose your settings.</p>
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
                <span class="w-full">How much does Sponsored Brands cost?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-1" role="region" aria-labelledby="faq-trigger-1" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Sponsored Brands uses a cost-per-click model, so you decide how much to bid and set the budget that fits your goals. You only pay when shoppers click your ad.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-2" id="faq-trigger-2" data-faq-trigger>
                <span class="w-full">How can I measure results from my Sponsored Brands campaign?</span>
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
                <span class="w-full">Who can use Sponsored Brands?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-3" role="region" aria-labelledby="faq-trigger-3" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">Sponsored Brands is available to eligible sellers, vendors, book vendors, and agencies with enrolled brands and products that meet marketplace requirements.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-4" id="faq-trigger-4" data-faq-trigger>
                <span class="w-full">What categories are not eligible for Sponsored Brands?</span>
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
                <span class="w-full">What are the different goals I can achieve with Sponsored Brands?</span>
                <span class="inline-grid h-10 w-10 place-items-center rounded-full border border-black/10 bg-canvas text-base font-semibold text-copy" aria-hidden="true" data-faq-symbol>+</span>
              </button>
            </h3>
            <div class="px-5 py-4" id="faq-panel-6" role="region" aria-labelledby="faq-trigger-6" hidden data-faq-panel>
              <p class="text-[0.94rem] leading-[1.7] text-muted">You can use Sponsored Brands to build awareness, drive consideration, grow Store visits, promote product discovery, and support sales across a collection of products or a featured video creative.</p>
            </div>
          </article>

          <article class="overflow-hidden rounded-[22px] border border-black/10 bg-white shadow-[0_10px_20px_rgba(86,29,0,0.08)]" data-faq-item>
            <h3>
              <button class="flex w-full items-center gap-4 px-5 py-6 text-left text-[0.98rem] font-extrabold leading-[1.2] tracking-[-0.04em] text-copy transition" type="button" aria-expanded="false" aria-controls="faq-panel-7" id="faq-trigger-7" data-faq-trigger>
                <span class="w-full">What are the video specification requirements for Sponsored Brands video?</span>
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

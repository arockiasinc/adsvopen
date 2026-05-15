 </main>

  @php
    $scriptPath = public_path('js/script.js');
    $scriptVersion = file_exists($scriptPath) ? filemtime($scriptPath) : null;
  @endphp

  <footer class="bg-ink py-16 text-white md:py-[76px]" aria-label="Site footer">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="grid gap-9 md:grid-cols-2 xl:grid-cols-4" aria-label="Footer navigation">
        <div class="grid content-start gap-9">
          <section class="grid gap-3" aria-labelledby="footer-goals">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-goals">Goals</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#benefits">Build brand awareness</a></li>
              <li><a href="#placements">Reach more customers</a></li>
              <li><a href="#latest-news">Increase traffic</a></li>
              <li><a href="#case-studies">Increase sales and conversion</a></li>
              <li><a href="#campaign-setup">Improve customer loyalty</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-formats">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-formats">Ad products and formats</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#hero">Sponsored ads</a></li>
              <li><a href="#benefits">Sponsored Products</a></li>
              <li><a href="#hero">Banner Ads</a></li>
              <li><a href="#placements">Display ads</a></li>
              <li><a href="#video-campaign">Video ads</a></li>
              <li><a href="#creative-support">Audio ads</a></li>
              <li><a href="#partner-support">Out-of-home ads</a></li>
              <li><a href="#guides">View all</a></li>
            </ul>
          </section>
        </div>

        <div class="grid content-start gap-9">
          <section class="grid gap-3" aria-labelledby="footer-insights">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-insights">Insights and planning</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#latest-news">Audience insights</a></li>
              <li><a href="#guides">Media planning</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-creative">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-creative">Creative solutions</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#creative-support">Creative enhancements</a></li>
              <li><a href="#partner-support">Creative services</a></li>
              <li><a href="#video-campaign">Creative tools</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-analytics">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-analytics">Measurement and analytics</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#campaign-setup">Attribution reporting</a></li>
              <li><a href="#case-studies">Brand lift studies</a></li>
              <li><a href="#latest-news">Marketing insights stream</a></li>
              <li><a href="#guides">Campaign reporting</a></li>
              <li><a href="#benefits">Omnichannel Metrics</a></li>
              <li><a href="#partner-support">Rapid retail analytics</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-tech">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-tech">Technology and services</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#partner-support">Programmatic DSP</a></li>
              <li><a href="#latest-news">Marketing cloud</a></li>
              <li><a href="#campaign-setup">Ads API</a></li>
              <li><a href="#partner-support">Publisher services</a></li>
              <li><a href="#placements">Retail ad service</a></li>
              <li><a href="#latest-news">New Product Campaigns</a></li>
              <li><a href="#partner-support">Ads Agent</a></li>
            </ul>
          </section>
        </div>

        <div class="grid content-start gap-9">
          <section class="grid gap-3" aria-labelledby="footer-industries">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-industries">Industries</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#case-studies">Automotive</a></li>
              <li><a href="#benefits">Beauty</a></li>
              <li><a href="#guides">Consumer electronics</a></li>
              <li><a href="#video-campaign">Entertainment</a></li>
              <li><a href="#creative-support">Fashion</a></li>
              <li><a href="#campaign-setup">Financial services</a></li>
              <li><a href="#partner-support">Grocery</a></li>
              <li><a href="#benefits">Health and personal care</a></li>
              <li><a href="#hero">Home goods and furniture</a></li>
              <li><a href="#placements">Home improvement</a></li>
              <li><a href="#latest-news">Publishing</a></li>
              <li><a href="#partner-support">Telecom</a></li>
              <li><a href="#guides">Toys and games</a></li>
              <li><a href="#case-studies">Travel</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-channels">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-channels">Channels</h2>
          </section>
        </div>

        <div class="grid content-start gap-9">
          <section class="grid gap-3" aria-labelledby="footer-learn">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-learn">Learn</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#courses">Ads Academy</a></li>
              <li><a href="#latest-news">Product announcements</a></li>
              <li><a href="#guides">Resources</a></li>
              <li><a href="#faq">Ad specs and policies</a></li>
              <li><a href="#faq">FAQ</a></li>
            </ul>
          </section>

          <section class="grid gap-3" aria-labelledby="footer-partners">
            <h2 class="text-base font-extrabold leading-[1.2] tracking-[-0.04em]" id="footer-partners">Partners</h2>
            <ul class="grid gap-3 text-[0.9rem]">
              <li><a href="#partner-support">Find a partner</a></li>
              <li><a href="#partner-support">Become a partner</a></li>
            </ul>
          </section>
        </div>
      </div>

      <div class="grid gap-5 border-t border-white/15 pt-8">
        <nav class="flex flex-wrap items-center gap-3 text-[0.84rem]" aria-label="Legal">
          <a href="#top">About us</a>
          <a href="#faq">Conditions of use</a>
          <a href="#faq">Privacy Notice</a>
          <a href="#benefits">Interest-Based Ads</a>
          <a href="#faq">Cookie Notice</a>
          <a href="#latest-news">Ad platform status</a>
          <a href="#partner-support">Careers</a>
        </nav>

        <div class="flex flex-wrap items-center gap-3" aria-label="Social links">
          <a class="inline-grid h-10 w-10 place-items-center rounded-full border border-white/15 transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#top" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <path d="M6.75 8.25V18M6.75 5.25a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3Zm4.5 13.5v-5.25a3 3 0 0 1 6 0V18m-6-4.5v-2.25m0 2.25V18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/>
            </svg>
          </a>
          <a class="inline-grid h-10 w-10 place-items-center rounded-full border border-white/15 transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#top" aria-label="X">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <path d="M5 5l14 14M19 5L5 19" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/>
            </svg>
          </a>
          <a class="inline-grid h-10 w-10 place-items-center rounded-full border border-white/15 transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#top" aria-label="Instagram">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <rect x="4.5" y="4.5" width="15" height="15" rx="4" fill="none" stroke="currentColor" stroke-width="1.8"/>
              <circle cx="12" cy="12" r="3.6" fill="none" stroke="currentColor" stroke-width="1.8"/>
              <circle cx="17.15" cy="6.85" r="1" fill="currentColor"/>
            </svg>
          </a>
          <a class="inline-grid h-10 w-10 place-items-center rounded-full border border-white/15 transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#top" aria-label="YouTube">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <rect x="3.8" y="6.5" width="16.4" height="11" rx="3.2" fill="none" stroke="currentColor" stroke-width="1.8"/>
              <path d="M10.3 9.35l5.2 2.65-5.2 2.65V9.35Z" fill="currentColor"/>
            </svg>
          </a>
          <a class="inline-grid h-10 w-10 place-items-center rounded-full border border-white/15 transition hover:-translate-y-0.5 hover:bg-accent focus-visible:-translate-y-0.5 focus-visible:bg-accent" href="#top" aria-label="Facebook">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <path d="M13.2 19v-6.1h2.25l.35-2.65H13.2V8.55c0-.85.24-1.45 1.47-1.45H16V4.78c-.23-.03-1.02-.08-1.94-.08-1.92 0-3.23 1.17-3.23 3.33v1.91H8.65v2.65h2.18V19h2.37Z" fill="currentColor"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="flex flex-wrap items-center justify-center gap-5 border-t border-white/15 pt-6 text-center lg:justify-between">
        <a class="grid justify-items-center" href="#top" aria-label="Home">
          <img class="footer-logo-image rounded-lg bg-white/95 p-2 shadow-[0_12px_30px_rgba(0,0,0,0.16)]" src="{{ asset('images/logo.webp') }}" alt="Site logo">
        </a>

        <p class="text-[0.82rem] font-bold uppercase tracking-[0.08em]">&copy; Copyright 2015-2026. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}{{ $scriptVersion ? '?v='.$scriptVersion : '' }}"></script>
</body>
</html>

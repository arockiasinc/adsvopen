 </main>

  @php
    $scriptPath = public_path('js/script.js');
    $scriptVersion = file_exists($scriptPath) ? filemtime($scriptPath) : null;

    // Legal pages are DB-backed and editable from /admin. Guard the lookup so
    // the footer still renders on a database that has not been migrated yet.
    try {
      $footerLegalPages = \Illuminate\Support\Facades\Schema::hasTable('legal_pages')
        ? \App\Models\LegalPage::query()->published()->where('is_footer', true)->ordered()->get(['title', 'slug'])
        : collect();
    } catch (\Throwable $exception) {
      $footerLegalPages = collect();
    }
  @endphp

  <footer class="site-footer py-16 text-white md:py-[76px]" aria-label="Site footer">
    <div class="mx-auto grid max-w-7xl gap-9 px-6 lg:px-8">
      <div class="grid gap-5 pt-2">
        <nav class="flex flex-wrap items-center gap-3 text-[0.84rem]" aria-label="Legal">
          <a href="{{ route('home') }}#top">About us</a>
          @foreach ($footerLegalPages as $footerLegalPage)
            <a href="{{ route('legal.page', $footerLegalPage->slug) }}">{{ $footerLegalPage->title }}</a>
          @endforeach
          <a href="{{ route('home') }}#benefits">Interest-Based Ads</a>
          <a href="{{ route('home') }}#partner-support">Careers</a>
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

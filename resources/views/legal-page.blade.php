@include('partials.header')

  <section class="border-t border-black/10 py-16 md:py-[72px]" id="intro">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <nav class="mb-6 flex flex-wrap items-center gap-2 text-[0.82rem] text-muted" aria-label="Breadcrumb">
        <a class="font-semibold text-copy hover:text-accent" href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ $page->title }}</span>
      </nav>

      <div class="mx-auto grid max-w-[860px] gap-3">
        <h1 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">{{ $page->title }}</h1>
        <p class="text-[0.86rem] text-muted">Last updated {{ $page->updated_at?->format('F j, Y') }}</p>
      </div>

      <article class="legal-prose mx-auto mt-9 max-w-[860px] rounded-2xl border border-black/10 bg-white p-6 md:p-10">
        {!! $page->content !!}
      </article>

      @php
        $relatedPages = \App\Models\LegalPage::query()
          ->published()
          ->ordered()
          ->where('id', '!=', $page->id)
          ->get(['title', 'slug']);
      @endphp

      @if ($relatedPages->isNotEmpty())
        <nav class="mx-auto mt-8 flex max-w-[860px] flex-wrap items-center gap-3 text-[0.86rem]" aria-label="Other policies">
          <span class="font-semibold text-copy">See also:</span>
          @foreach ($relatedPages as $relatedPage)
            <a class="text-muted underline underline-offset-4 hover:text-accent" href="{{ route('legal.page', $relatedPage->slug) }}">{{ $relatedPage->title }}</a>
          @endforeach
        </nav>
      @endif
    </div>
  </section>

@include('partials.footer')

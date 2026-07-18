@include('partials.header')

@php
    use App\Support\AdTargeting;

    $industries = config('advertising.industries');
    $companySizes = config('advertising.company_sizes');
    $durations = config('advertising.durations');
    $adAbout = config('advertising.ad_about');
    $schedules = config('advertising.display_schedules');
    $bands = config('advertising.daily_budget_bands');
    $sizeHints = [
        'micro' => 'Recommended: Business listing page.',
        'small' => 'Recommended: Business listing page + ads on that page + ads on the home page (except slider ads).',
        'medium' => 'Recommended: Home page slider + other home page ads.',
        'large' => 'Recommended: Home page sliders, other home page ads and the business listing page ad.',
    ];

    // Provinces and locations come from the database — the same lists customers
    // pick from when they register on the marketplace.
    $provinces = AdTargeting::provinceOptions();
    $provinceNames = array_values($provinces);
    $adTypes = \App\Models\AdType::options();
    $scopes = AdTargeting::scopeOptions();
    $scopeHints = AdTargeting::scopeDescriptions();

    $oldScope = old('target_scope');
    $oldProvinceId = old('target_province_id');
    $oldProvinceIds = array_map('strval', (array) old('target_province_ids', []));
    $oldCityIds = array_map('intval', (array) old('target_city_ids', []));
@endphp

<style>
  .sa-wrap{--sa-accent:var(--color-accent,#ff6507);--sa-blue:var(--color-ink,#ff6507);--sa-accent-deep:var(--color-accentDeep,#ff6507);--sa-copy:var(--color-copy,#141922);--sa-muted:var(--color-muted,#6b7280);--sa-canvas:var(--color-canvas,#ffffff);--sa-line:rgba(0,0,0,.1);background:var(--sa-canvas);padding:2.5rem 1.5rem 4rem}
  .sa-shell{max-width:60rem;margin:0 auto;counter-reset:sa-step}
  .sa-intro{position:relative;margin:0 0 2.5rem;padding:2rem 2rem 2.1rem;border-radius:1.1rem;background:#ff6507;color:#fff;overflow:hidden;box-shadow:0 18px 40px rgba(255,101,7,.25)}
  .sa-intro::after{content:"";position:absolute;right:-3.5rem;top:-3.5rem;width:12rem;height:12rem;border-radius:50%;background:rgba(255,255,255,.16)}
  .sa-intro>*{position:relative}
  .sa-kicker{display:inline-block;font-size:.72rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase;color:#ff6507;background:#fff;padding:.3rem .7rem;border-radius:999px;margin-bottom:.9rem}
  .sa-title{font-size:clamp(2.1rem,5.5vw,3.1rem);font-weight:900;letter-spacing:-.04em;line-height:1;color:#fff;margin-bottom:.85rem}
  .sa-lead p{font-size:1rem;line-height:1.65;color:rgba(255,255,255,.92);margin:0 0 .6rem}
  .sa-card{position:relative;background:#fff;border:1px solid var(--sa-line);border-radius:.9rem;padding:1.6rem;box-shadow:0 8px 22px rgba(0,0,0,.05);margin-bottom:1.4rem}
  .sa-card h2{display:flex;align-items:center;gap:.7rem;font-size:1.2rem;font-weight:900;letter-spacing:-.02em;color:var(--sa-copy);margin:0 0 1.1rem;padding-bottom:.9rem;border-bottom:1px solid var(--sa-line)}
  .sa-card h2::before{counter-increment:sa-step;content:counter(sa-step);flex:none;display:grid;place-items:center;width:1.9rem;height:1.9rem;border-radius:.55rem;background:var(--sa-accent);color:#fff;font-size:.95rem;font-weight:900}
  .sa-q{display:block;font-size:.97rem;font-weight:800;color:var(--sa-copy);margin-bottom:.6rem}
  .sa-field{display:block;width:100%;border:1px solid var(--sa-line);background:#fff;border-radius:.6rem;padding:.7rem .9rem;font-size:.95rem;color:var(--sa-copy);font-family:inherit}
  .sa-field:focus{outline:none;border-color:var(--sa-accent);box-shadow:0 0 0 3px rgba(255,101,7,.18)}
  .sa-row{display:grid;gap:1rem;margin-bottom:1rem}
  @media(min-width:640px){.sa-row.sa-2{grid-template-columns:1fr 1fr}.sa-row.sa-3{grid-template-columns:1fr 1fr 1fr}}
  .sa-group{display:grid;gap:.4rem}
  .sa-opts{display:flex;flex-wrap:wrap;gap:.6rem 1.5rem}
  .sa-opt{display:flex;align-items:flex-start;gap:.55rem;font-size:.95rem;color:var(--sa-copy);cursor:pointer}
  .sa-opt input{margin-top:.15rem;flex:none}
  .sa-opt-card{border:1px solid var(--sa-line);border-radius:.7rem;padding:.9rem 1rem;transition:border-color .15s}
  .sa-opt-card:hover{border-color:rgba(255,101,7,.5)}
  .sa-opt-card .sa-opt-title{font-weight:800}
  .sa-opt-card .sa-opt-sub{display:block;font-size:.85rem;color:var(--sa-muted);margin-top:.15rem}
  .sa-grid-checks{display:grid;gap:.5rem}
  @media(min-width:640px){.sa-grid-checks{grid-template-columns:1fr 1fr}}
  .sa-region-block{border:1px solid var(--sa-line);background:var(--sa-canvas);border-radius:.7rem;padding:1rem;margin-top:.75rem}
  /* Location picker: search + tickable list + chips for what is already chosen.
     A province can hold 700+ locations, so the list scrolls instead of growing. */
  .sa-picker{border:1px solid var(--sa-line);border-radius:.7rem;background:#fff;overflow:hidden}
  .sa-picker-top{display:flex;gap:.5rem;padding:.6rem;border-bottom:1px solid var(--sa-line)}
  .sa-search{flex:1;min-width:0;border:1px solid var(--sa-line);border-radius:.5rem;padding:.55rem .8rem;font-family:inherit;font-size:.92rem;color:var(--sa-copy)}
  .sa-search:focus{outline:none;border-color:var(--sa-accent);box-shadow:0 0 0 3px rgba(255,101,7,.18)}
  .sa-clear{flex:none;border:1px solid var(--sa-line);background:#fff;border-radius:.5rem;padding:0 .85rem;font-family:inherit;font-size:.83rem;font-weight:700;color:var(--sa-muted);cursor:pointer}
  .sa-clear:hover{color:var(--sa-accent-deep);border-color:var(--sa-accent)}
  .sa-chips{display:flex;flex-wrap:wrap;gap:.4rem;padding:.6rem;border-bottom:1px solid var(--sa-line);background:var(--sa-canvas)}
  .sa-chip{display:inline-flex;align-items:center;gap:.15rem;background:#fff;border:1px solid rgba(255,101,7,.4);border-radius:999px;padding:.22rem .25rem .22rem .65rem;font-size:.82rem;font-weight:700;color:var(--sa-copy)}
  .sa-chip button{border:0;background:transparent;color:var(--sa-muted);font-size:1rem;line-height:1;padding:0 .3rem;cursor:pointer}
  .sa-chip button:hover{color:#ff6507}
  .sa-picker-list{display:grid;gap:.1rem;padding:.35rem;max-height:17rem;overflow-y:auto}
  @media(min-width:640px){.sa-picker-list{grid-template-columns:1fr 1fr}}
  .sa-picker-empty{grid-column:1/-1;margin:0;padding:1.1rem;font-size:.88rem;color:var(--sa-muted);text-align:center}
  .sa-picker-meta{margin:0;padding:.55rem .75rem;border-top:1px solid var(--sa-line);font-size:.8rem;color:var(--sa-muted)}
  .sa-checkgrid{display:grid;gap:.1rem;border:1px solid var(--sa-line);border-radius:.7rem;background:#fff;padding:.35rem}
  @media(min-width:640px){.sa-checkgrid{grid-template-columns:1fr 1fr 1fr}}
  .sa-pick{display:flex;align-items:center;gap:.55rem;min-width:0;padding:.45rem .55rem;border-radius:.45rem;font-size:.9rem;color:var(--sa-copy);cursor:pointer}
  .sa-pick:hover{background:var(--sa-canvas)}
  .sa-pick input{flex:none;accent-color:var(--sa-accent)}
  .sa-pick span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
  .sa-pick.sa-filtered{display:none}
  /* The quote panel is rendered server-side with utility classes; map the few it uses. */
  #sa-quote .text-sm{font-size:.92rem}
  #sa-quote .space-y-2>*+*{margin-top:.5rem}
  #sa-quote .flex{display:flex}
  #sa-quote .justify-between{justify-content:space-between}
  #sa-quote .gap-4{gap:1rem}
  #sa-quote .font-medium{font-weight:600}
  #sa-quote .font-semibold{font-weight:800}
  #sa-quote .border-t{border-top:1px solid var(--sa-line)}
  #sa-quote .pt-2{padding-top:.5rem}
  #sa-quote .whitespace-nowrap{white-space:nowrap}
  #sa-quote .text-gray-500{color:var(--sa-muted)}
  #sa-quote .text-primary-600{color:var(--sa-accent-deep)}
  #sa-quote .text-warning-600{color:#ff6507}
  .sa-region-list{display:grid;gap:.6rem}
  .sa-region-category{border:1px solid var(--sa-line);background:#fff;border-radius:.65rem;padding:.85rem}
  .sa-region-head{display:flex;align-items:center;gap:.55rem;font-size:.93rem;font-weight:800;color:var(--sa-copy);cursor:pointer}
  .sa-place-panel{margin:.75rem 0 0 1.55rem;border-top:1px solid var(--sa-line);padding-top:.75rem}
  .sa-place-grid{display:grid;gap:.45rem}
  @media(min-width:640px){.sa-place-grid{grid-template-columns:1fr 1fr}}
  .sa-help{font-size:.8rem;color:var(--sa-muted)}
  .sa-btn{display:inline-flex;align-items:center;justify-content:center;min-height:3.2rem;padding:0 2rem;border:0;border-radius:.6rem;background:var(--sa-accent);color:#fff;font-size:1rem;font-weight:800;cursor:pointer;transition:background .15s,transform .15s}
  .sa-btn:hover{background:var(--sa-accent-deep);transform:translateY(-1px)}
  .sa-note{border-radius:.7rem;padding:1rem 1.25rem;font-size:.92rem;margin-bottom:1.5rem}
  .sa-note-info{border:1px solid var(--sa-line);background:#fff;color:var(--sa-muted)}
  .sa-note-bad{border:1px solid rgba(255,101,7,.4);background:#ffffff;color:#ff6507;font-weight:600}
  .sa-note-good{border:1px solid rgba(255,101,7,.35);background:#fff;color:var(--sa-copy)}
  .sa-note-good h2{font-size:clamp(1.4rem,3.2vw,2rem);font-weight:900;letter-spacing:-.03em;margin:0 0 .5rem;color:var(--sa-copy)}
  .sa-note-good ul{margin:.75rem 0 0;padding-left:1.25rem;display:grid;gap:.4rem;color:var(--sa-muted);line-height:1.7}
  .sa-link{color:var(--sa-accent-deep);font-weight:800;text-decoration:underline}
  .sa-actions{display:flex;flex-wrap:wrap;align-items:center;gap:1rem;margin-top:.5rem}
  .sa-decline{margin-top:1rem;border-radius:.5rem;background:#ffffff;color:#ff6507;font-weight:700;padding:.75rem 1rem;font-size:.92rem}
  .sa-hidden{display:none !important}
</style>

  <section class="border-t border-black/10 py-16 md:py-[72px]" id="intro">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto grid max-w-[820px] gap-5 text-center">
        <div>
          <span class="lb-chip">
            <span class="lb-chip-dot" aria-hidden="true"></span>
            Start Advertising
          </span>
        </div>
        <h1 class="text-[clamp(2rem,4.3vw,3rem)] font-black leading-none tracking-[-0.05em] text-copy">Find the right way to advertise your brand</h1>
        <p class="text-[0.98rem] leading-[1.7] text-muted">Our AI-driven platform helps you choose the best option available for your brand and your message to reach the target market &mdash; let it be local or coast-to-coast. Advertising with the VOpen Market is as simple as that, everything is automated.</p>
        <p class="text-[0.98rem] leading-[1.7] text-muted">Thousands of people visit our website from each province across Canada every day. Our platform will help you with the recommended placement of your message, brand, link or business on our website.</p>
        <p class="text-[0.98rem] leading-[1.7] text-muted">Answer a few quick questions to get custom recommendations for your business&rsquo;s advertising needs. <b>Advertisements with VOpen Market start from a minimum of one month commitment.</b></p>
      </div>
    </div>
  </section>

<div class="sa-wrap">
  <div class="sa-shell">

    @if (!empty($recommendations))
      <div class="sa-note sa-note-good">
        <h2>Based on the information you provided, here are the options for your company to advertise</h2>
        @if (count($recommendations))
          <ul>
            @foreach ($recommendations as $rec)
              <li>{{ $rec }}</li>
            @endforeach
          </ul>
        @endif
        <p class="sa-help" style="margin-top:1rem">Your request has been saved and our team has been notified. We&rsquo;ll be in touch with package details and pricing for the placements above.</p>
      </div>
    @endif

    @if (session('advertising_declined'))
      <div class="sa-note sa-note-bad">{{ session('advertising_declined') }}</div>
    @endif

    @guest
      <div class="sa-note sa-note-info">
        You can fill out the questionnaire below. To submit it you&rsquo;ll need to
        <a class="sa-link" href="{{ route('filament.advertiser.auth.login') }}">log in</a> or
        <a class="sa-link" href="{{ route('filament.advertiser.auth.register') }}">register</a>
        for an advertiser account.
      </div>
    @endguest

    @if ($errors->any())
      <div class="sa-note sa-note-bad">
        <p style="margin:0 0 .5rem;font-weight:800">Please correct the following:</p>
        <ul style="margin:0;padding-left:1.25rem">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('start.advertising.store') }}" enctype="multipart/form-data" id="advertising-form">
      @csrf

      {{-- Acceptance gate --}}
      <div class="sa-card">
        <p class="sa-q">Advertisements with VOpen Market start from a minimum of one month commitment. Do you accept?</p>
        <div class="sa-opts">
          <label class="sa-opt"><input type="radio" name="accepts_terms" value="yes" data-gate @checked(old('accepts_terms') === 'yes')> Yes</label>
          <label class="sa-opt"><input type="radio" name="accepts_terms" value="no" data-gate @checked(old('accepts_terms') === 'no')> No</label>
        </div>
        <p class="sa-decline {{ old('accepts_terms') === 'no' ? '' : 'sa-hidden' }}" data-decline-notice>{{ config('advertising.min_commitment_notice') }}</p>
      </div>

      <div class="{{ old('accepts_terms') === 'yes' ? '' : 'sa-hidden' }}" data-gated>

        <div class="sa-card">
          <h2>Your business</h2>
          <div class="sa-group" style="margin-bottom:1rem">
            <label class="sa-q" for="business_name">Business name</label>
            <input class="sa-field" type="text" id="business_name" name="business_name" value="{{ $prefill['business_name'] }}" required>
          </div>
          <div class="sa-row sa-2">
            <div class="sa-group">
              <label class="sa-q" for="industry">Choose your industry</label>
              <select class="sa-field" id="industry" name="industry" required>
                <option value="">Select an industry…</option>
                @foreach ($industries as $industry)
                  <option value="{{ $industry }}" @selected(old('industry') === $industry)>{{ $industry }}</option>
                @endforeach
              </select>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="business_province">Business location (province)</label>
              <select class="sa-field" id="business_province" name="business_province" required>
                <option value="">Select a province…</option>
                @foreach ($provinceNames as $province)
                  <option value="{{ $province }}" @selected(old('business_province') === $province)>{{ $province }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Company size</h2>
          <div class="sa-group" style="gap:.6rem">
            @foreach ($companySizes as $key => $label)
              <label class="sa-opt sa-opt-card">
                <input type="radio" name="company_size" value="{{ $key }}" required @checked(old('company_size') === $key)>
                <span><span class="sa-opt-title">{{ $label }}</span><span class="sa-opt-sub">{{ $sizeHints[$key] }}</span></span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="sa-card">
          <h2>Where do you want to advertise?</h2>

          <div class="sa-group" style="margin-bottom:1.5rem">
            <label class="sa-q" for="ad_type_id">Which type of advertisement?</label>
            <select class="sa-field" id="ad_type_id" name="ad_type_id" required>
              <option value="">Select an ad type…</option>
              @foreach ($adTypes as $id => $name)
                <option value="{{ $id }}" @selected((string) old('ad_type_id') === (string) $id)>{{ $name }}</option>
              @endforeach
            </select>
            <p class="sa-help">Pricing depends on the ad type and where you advertise.</p>
          </div>

          <div class="sa-group" style="gap:.6rem">
            <p class="sa-q">How far do you want your ad to reach?</p>
            @foreach ($scopes as $key => $label)
              <label class="sa-opt sa-opt-card">
                <input type="radio" name="target_scope" value="{{ $key }}" required data-scope-toggle @checked($oldScope === $key)>
                <span><span class="sa-opt-title">{{ $label }}</span><span class="sa-opt-sub">{{ $scopeHints[$key] }}</span></span>
              </label>
            @endforeach
          </div>

          <div class="sa-region-block {{ $oldScope === 'multi_province' ? '' : 'sa-hidden' }}" data-scope-block="multi_province">
            <p class="sa-q">Which provinces?</p>
            <div class="sa-checkgrid" id="target_province_ids">
              @foreach ($provinces as $id => $name)
                <label class="sa-pick">
                  <input type="checkbox" name="target_province_ids[]" value="{{ $id }}" @checked(in_array((string) $id, $oldProvinceIds, true))>
                  <span>{{ $name }}</span>
                </label>
              @endforeach
            </div>
            <p class="sa-help" style="margin-top:.6rem">Tick at least two.</p>
          </div>

          <div class="sa-region-block {{ in_array($oldScope, ['province', 'city'], true) ? '' : 'sa-hidden' }}" data-scope-block="province city">
            <label class="sa-q" for="target_province_id">Province</label>
            <select class="sa-field" id="target_province_id" name="target_province_id">
              <option value="">Select a province…</option>
              @foreach ($provinces as $id => $name)
                <option value="{{ $id }}" @selected((string) $oldProvinceId === (string) $id)>{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="sa-region-block {{ $oldScope === 'city' ? '' : 'sa-hidden' }}" data-scope-block="city">
            <label class="sa-q" for="sa-city-search">Select nearest location(s)</label>
            <p class="sa-help" style="margin-bottom:.65rem">Search or scroll, then tick every location you want to cover — the same list customers pick from when they register.</p>

            <div class="sa-picker">
              <div class="sa-picker-top">
                <input type="search" class="sa-search" id="sa-city-search" placeholder="Search locations…" autocomplete="off">
                <button type="button" class="sa-clear" id="sa-city-clear" hidden>Clear all</button>
              </div>
              <div class="sa-chips" id="sa-city-chips" hidden></div>
              <div class="sa-picker-list" id="target_city_ids">
                <p class="sa-picker-empty">Choose a province above to see its locations.</p>
              </div>
              <p class="sa-picker-meta" id="sa-city-meta">No locations selected yet.</p>
            </div>
          </div>

          <div class="sa-region-block" id="sa-quote">
            <p class="sa-q" style="margin-bottom:.6rem">Estimated price</p>
            <div id="sa-quote-body">
              <span class="sa-help">Choose an ad type and where you want to advertise to see pricing.</span>
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Selling &amp; duration</h2>
          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">Do you sell any of your products on VOpen Market?</p>
            <div class="sa-opts">
              <label class="sa-opt"><input type="radio" name="sells_on_vopen" value="1" data-toggle="seller_id_wrap" required @checked(old('sells_on_vopen') === '1')> Yes</label>
              <label class="sa-opt"><input type="radio" name="sells_on_vopen" value="0" data-toggle="seller_id_wrap" @checked(old('sells_on_vopen') === '0')> No</label>
            </div>
            <div class="sa-group {{ old('sells_on_vopen') === '1' ? '' : 'sa-hidden' }}" id="seller_id_wrap" data-show-when="1" style="margin-top:.6rem">
              <label class="sa-q" for="seller_id">Enter Seller ID</label>
              <input class="sa-field" type="text" id="seller_id" name="seller_id" value="{{ old('seller_id') }}">
            </div>
          </div>

          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">How many months are you planning to advertise in your targeted location?</p>
            <div class="sa-opts">
              @foreach ($durations as $key => $label)
                <label class="sa-opt"><input type="radio" name="duration" value="{{ $key }}" required @checked(old('duration') === $key)> {{ $label }}</label>
              @endforeach
            </div>
          </div>

          <div class="sa-group">
            <p class="sa-q">Do you want to get the most views and link customers to your website?</p>
            <div class="sa-opts">
              <label class="sa-opt"><input type="radio" name="wants_website_link" value="1" data-toggle="website_link_wrap" required @checked(old('wants_website_link') === '1')> Yes</label>
              <label class="sa-opt"><input type="radio" name="wants_website_link" value="0" data-toggle="website_link_wrap" @checked(old('wants_website_link') === '0')> No</label>
            </div>
            <div class="sa-group {{ old('wants_website_link') === '1' ? '' : 'sa-hidden' }}" id="website_link_wrap" data-show-when="1" style="margin-top:.6rem">
              <label class="sa-q" for="website_link">Enter link</label>
              <input class="sa-field" type="url" id="website_link" name="website_link" value="{{ old('website_link') }}" placeholder="https://">
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Your advertisement</h2>
          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">What is your advertisement about?</p>
            <div class="sa-grid-checks">
              @foreach ($adAbout as $key => $label)
                <label class="sa-opt"><input type="radio" name="ad_about" value="{{ $key }}" data-toggle="ad_about_other_wrap" required @checked(old('ad_about') === $key)> {{ $label }}</label>
              @endforeach
            </div>
            <div class="sa-group {{ old('ad_about') === 'others' ? '' : 'sa-hidden' }}" id="ad_about_other_wrap" data-show-when="others" style="margin-top:.6rem">
              <label class="sa-q" for="ad_about_other">Enter message type</label>
              <input class="sa-field" type="text" id="ad_about_other" name="ad_about_other" value="{{ old('ad_about_other') }}">
            </div>
          </div>
          <div class="sa-group">
            <p class="sa-q">Do you want your advertisement displayed during regular business hours or 24 hrs?</p>
            <div class="sa-group" style="gap:.5rem">
              @foreach ($schedules as $key => $label)
                <label class="sa-opt"><input type="radio" name="display_schedule" value="{{ $key }}" required @checked(old('display_schedule') === $key)> {{ $label }}</label>
              @endforeach
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Budget</h2>
          <div class="sa-group" style="margin-bottom:1rem">
            <label class="sa-q" for="daily_budget_band">What is your allocated daily budget for advertising?</label>
            <select class="sa-field" id="daily_budget_band" name="daily_budget_band" data-toggle="daily_budget_other_wrap" required>
              <option value="">Select a range…</option>
              @foreach ($bands as $key => $label)
                <option value="{{ $key }}" @selected(old('daily_budget_band') === $key)>{{ $label }}</option>
              @endforeach
            </select>
            <div class="sa-group {{ old('daily_budget_band') === 'other' ? '' : 'sa-hidden' }}" id="daily_budget_other_wrap" data-show-when="other" style="margin-top:.6rem">
              <label class="sa-q" for="daily_budget_other">Enter other amount ($)</label>
              <input class="sa-field" type="number" min="0" id="daily_budget_other" name="daily_budget_other" value="{{ old('daily_budget_other') }}">
            </div>
          </div>
          <div class="sa-group">
            <label class="sa-q" for="yearly_marketing_budget">What is your yearly marketing budget for your brand? (dollar value)</label>
            <input class="sa-field" type="number" min="0" id="yearly_marketing_budget" name="yearly_marketing_budget" value="{{ old('yearly_marketing_budget') }}">
          </div>
        </div>

        <div class="sa-card">
          <h2>A few more questions</h2>
          @php
            $yesNo = [
              'advertising_apps' => 'Are you advertising any apps to be downloaded?',
              'special_promotion' => 'Is the advertisement related to any special promotion?',
              'generic_social_message' => 'Is it a generic social message that you want displayed?',
              'is_government_agency' => 'Are you a government agency?',
            ];
          @endphp
          @foreach ($yesNo as $name => $question)
            <div class="sa-group" style="margin-bottom:1rem">
              <p class="sa-q">{{ $question }}</p>
              <div class="sa-opts">
                <label class="sa-opt"><input type="radio" name="{{ $name }}" value="1" required @checked(old($name) === '1')> Yes</label>
                <label class="sa-opt"><input type="radio" name="{{ $name }}" value="0" @checked(old($name) === '0')> No</label>
              </div>
            </div>
          @endforeach
          <div class="sa-group">
            <label class="sa-q" for="digital_file">Do you have the digital file ready to start advertising? If so, upload it here.</label>
            <input class="sa-field" type="file" id="digital_file" name="digital_file" accept="image/*,video/*,application/pdf">
            <span class="sa-help">Images, video or PDF, up to 20 MB.</span>
          </div>
        </div>

        <div class="sa-card">
          <h2>Your contact info</h2>
          <p class="sa-help" style="margin:-.4rem 0 1rem">Pre-filled from your account where available &mdash; edit if needed.</p>
          <div class="sa-row sa-3">
            <div class="sa-group">
              <label class="sa-q" for="contact_name">Contact name</label>
              <input class="sa-field" type="text" id="contact_name" name="contact_name" value="{{ $prefill['contact_name'] }}" required>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="contact_email">Contact email</label>
              <input class="sa-field" type="email" id="contact_email" name="contact_email" value="{{ $prefill['contact_email'] }}" required>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="contact_phone">Contact phone</label>
              <input class="sa-field" type="tel" id="contact_phone" name="contact_phone" value="{{ $prefill['contact_phone'] }}">
            </div>
          </div>
        </div>

        <div class="sa-actions">
          <button type="submit" class="sa-btn">Submit &amp; get my recommendations</button>
          @guest
            <span class="sa-help">You&rsquo;ll be asked to log in before your request is submitted.</span>
          @endguest
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  (function () {
    var form = document.getElementById('advertising-form');
    if (!form) return;
    var H = 'sa-hidden';

    var gated = form.querySelector('[data-gated]');
    var notice = form.querySelector('[data-decline-notice]');
    form.querySelectorAll('[data-gate]').forEach(function (el) {
      el.addEventListener('change', function () {
        gated.classList.toggle(H, !(this.value === 'yes' && this.checked));
        notice.classList.toggle(H, !(this.value === 'no' && this.checked));
      });
    });

    form.querySelectorAll('[data-toggle]').forEach(function (el) {
      el.addEventListener('change', function () {
        var wrap = document.getElementById(this.getAttribute('data-toggle'));
        if (!wrap) return;
        var want = wrap.getAttribute('data-show-when');
        var on = el.tagName === 'SELECT' ? el.value === want : (el.checked && el.value === want);
        wrap.classList.toggle(H, !on);
      });
    });

    // ---- Targeting: scope -> province -> nearest location, and the live price ----

    var adType = document.getElementById('ad_type_id');
    var provinceOne = document.getElementById('target_province_id');
    var provinceMany = document.getElementById('target_province_ids');
    var cities = document.getElementById('target_city_ids');
    var citySearch = document.getElementById('sa-city-search');
    var cityChips = document.getElementById('sa-city-chips');
    var cityClear = document.getElementById('sa-city-clear');
    var cityMeta = document.getElementById('sa-city-meta');
    var quoteBody = document.getElementById('sa-quote-body');

    var endpoints = {
      cities: @json(route('advertising.cities')),
      quote: @json(route('advertising.quote')),
    };

    // Re-select what the advertiser had chosen if the form came back with errors.
    var preselect = {
      cities: @json($oldCityIds),
    };

    var currentScope = function () {
      var checked = form.querySelector('[data-scope-toggle]:checked');
      return checked ? checked.value : '';
    };

    // Only the fields for the chosen scope are shown, and only those are
    // submitted — a disabled field is left out of the POST.
    var syncScope = function () {
      var scope = currentScope();

      form.querySelectorAll('[data-scope-block]').forEach(function (block) {
        var applies = block.getAttribute('data-scope-block').split(' ').indexOf(scope) !== -1;
        block.classList.toggle(H, !applies);
        block.querySelectorAll('select, input').forEach(function (field) {
          field.disabled = !applies;
        });
      });
    };

    var ticked = function (container) {
      return Array.prototype.slice.call(container.querySelectorAll('input[type="checkbox"]:checked'));
    };

    var placeholder = function (message) {
      cities.innerHTML = '';
      var note = document.createElement('p');
      note.className = 'sa-picker-empty';
      note.textContent = message;
      cities.appendChild(note);
    };

    // A chip per chosen location, so a long list never hides what is selected.
    var syncCities = function () {
      var chosen = ticked(cities);
      var total = cities.querySelectorAll('input[type="checkbox"]').length;

      cityChips.innerHTML = '';
      cityChips.hidden = chosen.length === 0;
      cityClear.hidden = chosen.length === 0;

      chosen.forEach(function (box) {
        var chip = document.createElement('span');
        chip.className = 'sa-chip';
        chip.appendChild(document.createTextNode(box.parentNode.textContent.trim()));

        var remove = document.createElement('button');
        remove.type = 'button';
        remove.innerHTML = '&times;';
        remove.setAttribute('aria-label', 'Remove ' + box.parentNode.textContent.trim());
        remove.addEventListener('click', function () {
          box.checked = false;
          syncCities();
          refreshQuote();
        });

        chip.appendChild(remove);
        cityChips.appendChild(chip);
      });

      cityMeta.textContent = total
        ? chosen.length + ' of ' + total + ' locations selected'
        : 'No locations selected yet.';
    };

    // Every location in the province, exactly as customer registration lists them.
    var loadPlaces = function () {
      var provinceId = provinceOne.value;

      if (currentScope() !== 'city') {
        return Promise.resolve();
      }

      if (!provinceId) {
        placeholder('Choose a province above to see its locations.');
        syncCities();

        return Promise.resolve();
      }

      var url = endpoints.cities + '?province_id=' + encodeURIComponent(provinceId);

      return fetch(url, { headers: { Accept: 'application/json' } })
        .then(function (response) { return response.json(); })
        .then(function (options) {
          if (!options.length) {
            placeholder('No locations are listed for this province yet.');

            return;
          }

          var list = document.createDocumentFragment();

          options.forEach(function (option) {
            var row = document.createElement('label');
            row.className = 'sa-pick';
            row.setAttribute('data-name', option.name.toLowerCase());

            var box = document.createElement('input');
            box.type = 'checkbox';
            box.name = 'target_city_ids[]';
            box.value = option.id;
            box.checked = preselect.cities.indexOf(option.id) !== -1;

            var name = document.createElement('span');
            name.textContent = option.name;
            name.title = option.name;

            row.appendChild(box);
            row.appendChild(name);
            list.appendChild(row);
          });

          cities.innerHTML = '';
          cities.appendChild(list);
          citySearch.value = '';
          // Old selections only apply to the first render.
          preselect.cities = [];
        })
        .catch(function () {
          placeholder('Locations could not be loaded. Please try again.');
        })
        .then(syncCities);
    };

    var selectedValues = function (container) {
      return ticked(container).map(function (box) {
        return box.value;
      });
    };

    var refreshQuote = function () {
      var scope = currentScope();

      if (!adType.value || !scope) {
        quoteBody.innerHTML = '<span class="sa-help">Choose an ad type and where you want to advertise to see pricing.</span>';
        return;
      }

      var params = new URLSearchParams();
      params.append('ad_type_id', adType.value);
      params.append('target_scope', scope);

      if (provinceOne.value) {
        params.append('target_province_id', provinceOne.value);
      }

      selectedValues(provinceMany).forEach(function (id) { params.append('target_province_ids[]', id); });
      selectedValues(cities).forEach(function (id) { params.append('target_city_ids[]', id); });

      fetch(endpoints.quote + '?' + params.toString(), { headers: { Accept: 'application/json' } })
        .then(function (response) { return response.json(); })
        .then(function (data) { quoteBody.innerHTML = data.html; })
        .catch(function () {
          quoteBody.innerHTML = '<span class="sa-help">Pricing is unavailable right now — we will quote you directly.</span>';
        });
    };

    form.querySelectorAll('[data-scope-toggle]').forEach(function (el) {
      el.addEventListener('change', function () {
        syncScope();
        loadPlaces().then(refreshQuote);
      });
    });

    provinceOne.addEventListener('change', function () {
      // A location only belongs to one province, so start the list over.
      placeholder('Loading locations…');
      loadPlaces().then(refreshQuote);
    });

    citySearch.addEventListener('input', function () {
      var needle = this.value.trim().toLowerCase();

      cities.querySelectorAll('.sa-pick').forEach(function (row) {
        var hit = !needle || row.getAttribute('data-name').indexOf(needle) !== -1;
        row.classList.toggle('sa-filtered', !hit);
      });
    });

    // A filtered-out location stays ticked and still submits — searching only
    // narrows what is on screen.
    cities.addEventListener('change', function () {
      syncCities();
      refreshQuote();
    });

    cityClear.addEventListener('click', function () {
      ticked(cities).forEach(function (box) { box.checked = false; });
      syncCities();
      refreshQuote();
    });

    [adType, provinceMany].forEach(function (el) {
      el.addEventListener('change', refreshQuote);
    });

    syncScope();
    loadPlaces().then(refreshQuote);
  })();
</script>

@include('partials.footer')

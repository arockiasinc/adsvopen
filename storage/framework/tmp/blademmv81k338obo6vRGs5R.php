<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $industries = config('advertising.industries');
    $provinces = config('advertising.provinces');
    $countryWide = config('advertising.country_wide_label');
    $companySizes = config('advertising.company_sizes');
    $durations = config('advertising.durations');
    $adAbout = config('advertising.ad_about');
    $schedules = config('advertising.display_schedules');
    $bands = config('advertising.daily_budget_bands');
    $regionCategories = config('advertising.region_categories');
    $provinceRegionCategories = config('advertising.province_region_categories', []);
    $sizeHints = [
        'micro' => 'Recommended: Business listing page.',
        'small' => 'Recommended: Business listing page + ads on that page + ads on the home page (except slider ads).',
        'medium' => 'Recommended: Home page slider + other home page ads.',
        'large' => 'Recommended: Home page sliders, other home page ads and the business listing page ad.',
    ];
    $oldProvinces = old('target_provinces', []);
    $oldRegions = old('target_regions', []);
?>

<style>
  .sa-wrap{--sa-accent:var(--color-accent,#f75a06);--sa-accent-deep:var(--color-accentDeep,#c8470a);--sa-copy:var(--color-copy,#1f2430);--sa-muted:var(--color-muted,#6b7280);--sa-canvas:var(--color-canvas,#fff8ef);--sa-line:rgba(0,0,0,.12);background:var(--sa-canvas);padding:3rem 1.5rem 4rem}
  .sa-shell{max-width:60rem;margin:0 auto}
  .sa-intro{margin-bottom:2.5rem}
  .sa-kicker{font-size:.75rem;font-weight:900;letter-spacing:.08em;text-transform:uppercase;color:var(--sa-accent-deep);margin-bottom:.6rem}
  .sa-title{font-size:clamp(2.2rem,5.5vw,3.3rem);font-weight:900;letter-spacing:-.04em;line-height:.98;color:var(--sa-copy);margin-bottom:1rem}
  .sa-lead p{font-size:1rem;line-height:1.7;color:var(--sa-muted);margin:0 0 .85rem}
  .sa-card{background:#fff;border:1px solid var(--sa-line);border-radius:1rem;padding:1.6rem;box-shadow:0 10px 22px rgba(86,29,0,.06);margin-bottom:1.5rem}
  .sa-card h2{font-size:1.25rem;font-weight:900;letter-spacing:-.03em;color:var(--sa-copy);margin:0 0 1rem}
  .sa-q{display:block;font-size:.97rem;font-weight:800;color:var(--sa-copy);margin-bottom:.6rem}
  .sa-field{display:block;width:100%;border:1px solid var(--sa-line);background:#fff;border-radius:.6rem;padding:.7rem .9rem;font-size:.95rem;color:var(--sa-copy);font-family:inherit}
  .sa-field:focus{outline:none;border-color:var(--sa-accent);box-shadow:0 0 0 3px rgba(247,90,6,.18)}
  select.sa-field[multiple]{padding:.4rem;min-height:6.5rem}
  .sa-row{display:grid;gap:1rem;margin-bottom:1rem}
  @media(min-width:640px){.sa-row.sa-2{grid-template-columns:1fr 1fr}.sa-row.sa-3{grid-template-columns:1fr 1fr 1fr}}
  .sa-group{display:grid;gap:.4rem}
  .sa-opts{display:flex;flex-wrap:wrap;gap:.6rem 1.5rem}
  .sa-opt{display:flex;align-items:flex-start;gap:.55rem;font-size:.95rem;color:var(--sa-copy);cursor:pointer}
  .sa-opt input{margin-top:.15rem;flex:none}
  .sa-opt-card{border:1px solid var(--sa-line);border-radius:.7rem;padding:.9rem 1rem;transition:border-color .15s}
  .sa-opt-card:hover{border-color:rgba(247,90,6,.5)}
  .sa-opt-card .sa-opt-title{font-weight:800}
  .sa-opt-card .sa-opt-sub{display:block;font-size:.85rem;color:var(--sa-muted);margin-top:.15rem}
  .sa-grid-checks{display:grid;gap:.5rem}
  @media(min-width:640px){.sa-grid-checks{grid-template-columns:1fr 1fr}}
  .sa-region-block{border:1px solid var(--sa-line);background:var(--sa-canvas);border-radius:.7rem;padding:1rem;margin-top:.75rem}
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
  .sa-note-bad{border:1px solid #fca5a5;background:#fef2f2;color:#b91c1c;font-weight:600}
  .sa-note-good{border:1px solid rgba(247,90,6,.35);background:#fff;color:var(--sa-copy)}
  .sa-note-good h2{font-size:clamp(1.4rem,3.2vw,2rem);font-weight:900;letter-spacing:-.03em;margin:0 0 .5rem;color:var(--sa-copy)}
  .sa-note-good ul{margin:.75rem 0 0;padding-left:1.25rem;display:grid;gap:.4rem;color:var(--sa-muted);line-height:1.7}
  .sa-link{color:var(--sa-accent-deep);font-weight:800;text-decoration:underline}
  .sa-actions{display:flex;flex-wrap:wrap;align-items:center;gap:1rem;margin-top:.5rem}
  .sa-decline{margin-top:1rem;border-radius:.5rem;background:#fef2f2;color:#b91c1c;font-weight:700;padding:.75rem 1rem;font-size:.92rem}
  .sa-hidden{display:none !important}
</style>

<div class="sa-wrap">
  <div class="sa-shell">

    <div class="sa-intro">
      <p class="sa-kicker">Start Advertising</p>
      <h1 class="sa-title">Find the right way to advertise your brand</h1>
      <div class="sa-lead">
        <p>Our AI-driven platform helps you choose the best option available for your brand and your message to reach the target market &mdash; let it be local or coast-to-coast. Advertising with the VOpen Market is as simple as that, everything is automated.</p>
        <p>Thousands of people visit our website from each province across Canada every day. Our platform will help you with the recommended placement of your message, brand, link or business on our website.</p>
        <p>Answer a few quick questions to get custom recommendations for your business&rsquo;s advertising needs. <strong style="color:var(--sa-copy)">Advertisements with VOpen Market start from a minimum of one month commitment.</strong></p>
      </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($recommendations)): ?>
      <div class="sa-note sa-note-good">
        <h2>Based on the information you provided, here are the options for your company to advertise</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($recommendations)): ?>
          <ul>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($rec); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </ul>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p class="sa-help" style="margin-top:1rem">Your request has been saved and our team has been notified. We&rsquo;ll be in touch with package details and pricing for the placements above.</p>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('advertising_declined')): ?>
      <div class="sa-note sa-note-bad"><?php echo e(session('advertising_declined')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
      <div class="sa-note sa-note-info">
        You can fill out the questionnaire below. To submit it you&rsquo;ll need to
        <a class="sa-link" href="<?php echo e(route('filament.advertiser.auth.login')); ?>">log in</a> or
        <a class="sa-link" href="<?php echo e(route('filament.advertiser.auth.register')); ?>">register</a>
        for an advertiser account.
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
      <div class="sa-note sa-note-bad">
        <p style="margin:0 0 .5rem;font-weight:800">Please correct the following:</p>
        <ul style="margin:0;padding-left:1.25rem">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('start.advertising.store')); ?>" enctype="multipart/form-data" id="advertising-form">
      <?php echo csrf_field(); ?>

      
      <div class="sa-card">
        <p class="sa-q">Advertisements with VOpen Market start from a minimum of one month commitment. Do you accept?</p>
        <div class="sa-opts">
          <label class="sa-opt"><input type="radio" name="accepts_terms" value="yes" data-gate <?php if(old('accepts_terms') === 'yes'): echo 'checked'; endif; ?>> Yes</label>
          <label class="sa-opt"><input type="radio" name="accepts_terms" value="no" data-gate <?php if(old('accepts_terms') === 'no'): echo 'checked'; endif; ?>> No</label>
        </div>
        <p class="sa-decline <?php echo e(old('accepts_terms') === 'no' ? '' : 'sa-hidden'); ?>" data-decline-notice><?php echo e(config('advertising.min_commitment_notice')); ?></p>
      </div>

      <div class="<?php echo e(old('accepts_terms') === 'yes' ? '' : 'sa-hidden'); ?>" data-gated>

        <div class="sa-card">
          <h2>Your business</h2>
          <div class="sa-group" style="margin-bottom:1rem">
            <label class="sa-q" for="business_name">Business name</label>
            <input class="sa-field" type="text" id="business_name" name="business_name" value="<?php echo e($prefill['business_name']); ?>" required>
          </div>
          <div class="sa-row sa-2">
            <div class="sa-group">
              <label class="sa-q" for="industry">Choose your industry</label>
              <select class="sa-field" id="industry" name="industry" required>
                <option value="">Select an industry…</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($industry); ?>" <?php if(old('industry') === $industry): echo 'selected'; endif; ?>><?php echo e($industry); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </select>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="business_province">Business location (province)</label>
              <select class="sa-field" id="business_province" name="business_province" required>
                <option value="">Select a province…</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($province); ?>" <?php if(old('business_province') === $province): echo 'selected'; endif; ?>><?php echo e($province); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Company size</h2>
          <div class="sa-group" style="gap:.6rem">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $companySizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <label class="sa-opt sa-opt-card">
                <input type="radio" name="company_size" value="<?php echo e($key); ?>" required <?php if(old('company_size') === $key): echo 'checked'; endif; ?>>
                <span><span class="sa-opt-title"><?php echo e($label); ?></span><span class="sa-opt-sub"><?php echo e($sizeHints[$key]); ?></span></span>
              </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>

        <div class="sa-card">
          <h2>Where do you want to advertise?</h2>
          <p class="sa-help" style="margin:-.4rem 0 1rem">Select all that apply. When a province is selected, refine its regions using the sections that appear below it.</p>
          <div class="sa-grid-checks">
            <label class="sa-opt"><input type="checkbox" name="target_provinces[]" value="<?php echo e($countryWide); ?>" <?php if(in_array($countryWide, $oldProvinces, true)): echo 'checked'; endif; ?>> <?php echo e($countryWide); ?></label>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <label class="sa-opt"><input type="checkbox" name="target_provinces[]" value="<?php echo e($province); ?>" data-province-toggle="<?php echo e(\Illuminate\Support\Str::slug($province)); ?>" <?php if(in_array($province, $oldProvinces, true)): echo 'checked'; endif; ?>> <?php echo e($province); ?></label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $slug = \Illuminate\Support\Str::slug($province);
              $provinceRegions = array_replace_recursive($regionCategories, $provinceRegionCategories[$province] ?? []);
            ?>
            <div class="sa-region-block <?php echo e(in_array($province, $oldProvinces, true) ? '' : 'sa-hidden'); ?>" data-province-block="<?php echo e($slug); ?>">
              <p class="sa-q" style="margin-bottom:.75rem">Select the region(s) you would like to advertise in <?php echo e($province); ?></p>
              <div class="sa-region-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $provinceRegions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catKey => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php $places = $cat['places'] ?? []; ?>
                  
                  <?php if($catKey !== 'across_province' && ($cat['display_count'] ?? count($places)) < 1) continue; ?>
                  <?php
                    $selectedRegions = $oldRegions[$province][$catKey] ?? [];
                    $categoryChecked = in_array('__category', $selectedRegions, true) || count(array_intersect($places, $selectedRegions)) > 0;
                    $count = $cat['display_count'] ?? count($places);
                    $label = $cat['label'] . ($count ? ' (' . $count . ')' : '');
                  ?>
                  <div class="sa-region-category">
                    <label class="sa-region-head">
                      <input type="checkbox" name="target_regions[<?php echo e($province); ?>][<?php echo e($catKey); ?>][]" value="__category" data-region-category <?php if($categoryChecked): echo 'checked'; endif; ?>>
                      <span><?php echo e($label); ?></span>
                    </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($places)): ?>
                      <div class="sa-place-panel <?php echo e($categoryChecked ? '' : 'sa-hidden'); ?>">
                        <div class="sa-place-grid">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="sa-opt">
                              <input type="checkbox" name="target_regions[<?php echo e($province); ?>][<?php echo e($catKey); ?>][]" value="<?php echo e($place); ?>" <?php if(in_array($place, $selectedRegions, true)): echo 'checked'; endif; ?>>
                              <?php echo e($place); ?>

                            </label>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                      </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="sa-card">
          <h2>Selling &amp; duration</h2>
          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">Do you sell any of your products on VOpen Market?</p>
            <div class="sa-opts">
              <label class="sa-opt"><input type="radio" name="sells_on_vopen" value="1" data-toggle="seller_id_wrap" required <?php if(old('sells_on_vopen') === '1'): echo 'checked'; endif; ?>> Yes</label>
              <label class="sa-opt"><input type="radio" name="sells_on_vopen" value="0" data-toggle="seller_id_wrap" <?php if(old('sells_on_vopen') === '0'): echo 'checked'; endif; ?>> No</label>
            </div>
            <div class="sa-group <?php echo e(old('sells_on_vopen') === '1' ? '' : 'sa-hidden'); ?>" id="seller_id_wrap" data-show-when="1" style="margin-top:.6rem">
              <label class="sa-q" for="seller_id">Enter Seller ID</label>
              <input class="sa-field" type="text" id="seller_id" name="seller_id" value="<?php echo e(old('seller_id')); ?>">
            </div>
          </div>

          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">How many months are you planning to advertise in your targeted location?</p>
            <div class="sa-opts">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="sa-opt"><input type="radio" name="duration" value="<?php echo e($key); ?>" required <?php if(old('duration') === $key): echo 'checked'; endif; ?>> <?php echo e($label); ?></label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          </div>

          <div class="sa-group">
            <p class="sa-q">Do you want to get the most views and link customers to your website?</p>
            <div class="sa-opts">
              <label class="sa-opt"><input type="radio" name="wants_website_link" value="1" data-toggle="website_link_wrap" required <?php if(old('wants_website_link') === '1'): echo 'checked'; endif; ?>> Yes</label>
              <label class="sa-opt"><input type="radio" name="wants_website_link" value="0" data-toggle="website_link_wrap" <?php if(old('wants_website_link') === '0'): echo 'checked'; endif; ?>> No</label>
            </div>
            <div class="sa-group <?php echo e(old('wants_website_link') === '1' ? '' : 'sa-hidden'); ?>" id="website_link_wrap" data-show-when="1" style="margin-top:.6rem">
              <label class="sa-q" for="website_link">Enter link</label>
              <input class="sa-field" type="url" id="website_link" name="website_link" value="<?php echo e(old('website_link')); ?>" placeholder="https://">
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Your advertisement</h2>
          <div class="sa-group" style="margin-bottom:1.25rem">
            <p class="sa-q">What is your advertisement about?</p>
            <div class="sa-grid-checks">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $adAbout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="sa-opt"><input type="radio" name="ad_about" value="<?php echo e($key); ?>" data-toggle="ad_about_other_wrap" required <?php if(old('ad_about') === $key): echo 'checked'; endif; ?>> <?php echo e($label); ?></label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="sa-group <?php echo e(old('ad_about') === 'others' ? '' : 'sa-hidden'); ?>" id="ad_about_other_wrap" data-show-when="others" style="margin-top:.6rem">
              <label class="sa-q" for="ad_about_other">Enter message type</label>
              <input class="sa-field" type="text" id="ad_about_other" name="ad_about_other" value="<?php echo e(old('ad_about_other')); ?>">
            </div>
          </div>
          <div class="sa-group">
            <p class="sa-q">Do you want your advertisement displayed during regular business hours or 24 hrs?</p>
            <div class="sa-group" style="gap:.5rem">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="sa-opt"><input type="radio" name="display_schedule" value="<?php echo e($key); ?>" required <?php if(old('display_schedule') === $key): echo 'checked'; endif; ?>> <?php echo e($label); ?></label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          </div>
        </div>

        <div class="sa-card">
          <h2>Budget</h2>
          <div class="sa-group" style="margin-bottom:1rem">
            <label class="sa-q" for="daily_budget_band">What is your allocated daily budget for advertising?</label>
            <select class="sa-field" id="daily_budget_band" name="daily_budget_band" data-toggle="daily_budget_other_wrap" required>
              <option value="">Select a range…</option>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(old('daily_budget_band') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
            <div class="sa-group <?php echo e(old('daily_budget_band') === 'other' ? '' : 'sa-hidden'); ?>" id="daily_budget_other_wrap" data-show-when="other" style="margin-top:.6rem">
              <label class="sa-q" for="daily_budget_other">Enter other amount ($)</label>
              <input class="sa-field" type="number" min="0" id="daily_budget_other" name="daily_budget_other" value="<?php echo e(old('daily_budget_other')); ?>">
            </div>
          </div>
          <div class="sa-group">
            <label class="sa-q" for="yearly_marketing_budget">What is your yearly marketing budget for your brand? (dollar value)</label>
            <input class="sa-field" type="number" min="0" id="yearly_marketing_budget" name="yearly_marketing_budget" value="<?php echo e(old('yearly_marketing_budget')); ?>">
          </div>
        </div>

        <div class="sa-card">
          <h2>A few more questions</h2>
          <?php
            $yesNo = [
              'advertising_apps' => 'Are you advertising any apps to be downloaded?',
              'special_promotion' => 'Is the advertisement related to any special promotion?',
              'generic_social_message' => 'Is it a generic social message that you want displayed?',
              'is_government_agency' => 'Are you a government agency?',
            ];
          ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $yesNo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="sa-group" style="margin-bottom:1rem">
              <p class="sa-q"><?php echo e($question); ?></p>
              <div class="sa-opts">
                <label class="sa-opt"><input type="radio" name="<?php echo e($name); ?>" value="1" required <?php if(old($name) === '1'): echo 'checked'; endif; ?>> Yes</label>
                <label class="sa-opt"><input type="radio" name="<?php echo e($name); ?>" value="0" <?php if(old($name) === '0'): echo 'checked'; endif; ?>> No</label>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
              <input class="sa-field" type="text" id="contact_name" name="contact_name" value="<?php echo e($prefill['contact_name']); ?>" required>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="contact_email">Contact email</label>
              <input class="sa-field" type="email" id="contact_email" name="contact_email" value="<?php echo e($prefill['contact_email']); ?>" required>
            </div>
            <div class="sa-group">
              <label class="sa-q" for="contact_phone">Contact phone</label>
              <input class="sa-field" type="tel" id="contact_phone" name="contact_phone" value="<?php echo e($prefill['contact_phone']); ?>">
            </div>
          </div>
        </div>

        <div class="sa-actions">
          <button type="submit" class="sa-btn">Submit &amp; get my recommendations</button>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
            <span class="sa-help">You&rsquo;ll be asked to log in before your request is submitted.</span>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

    var syncRegionCategory = function (checkbox) {
      var panel = checkbox.closest('.sa-region-category').querySelector('.sa-place-panel');
      if (!panel) return;
      panel.classList.toggle(H, !checkbox.checked);
      panel.querySelectorAll('input').forEach(function (field) {
        field.disabled = !checkbox.checked || checkbox.disabled;
      });
    };

    var syncProvinceBlock = function (checkbox) {
      var block = form.querySelector('[data-province-block="' + checkbox.getAttribute('data-province-toggle') + '"]');
      if (!block) return;
      block.classList.toggle(H, !checkbox.checked);
      block.querySelectorAll('input, select, textarea').forEach(function (field) {
        field.disabled = !checkbox.checked;
      });
      block.querySelectorAll('[data-region-category]').forEach(syncRegionCategory);
    };

    form.querySelectorAll('[data-province-toggle]').forEach(function (el) {
      syncProvinceBlock(el);

      el.addEventListener('change', function () {
        syncProvinceBlock(this);
      });
    });

    form.querySelectorAll('[data-region-category]').forEach(function (el) {
      syncRegionCategory(el);

      el.addEventListener('change', function () {
        syncRegionCategory(this);
      });
    });
  })();
</script>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

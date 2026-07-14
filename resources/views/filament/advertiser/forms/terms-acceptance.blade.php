@php
    use App\Models\LegalPage;
    use Illuminate\Support\Facades\Schema;

    $statePath = $getStatePath();

    // Mirrors the VOpen Market customer sign-up: ticking the box opens the
    // Terms & Conditions and the "I Agree" button only unlocks once the
    // advertiser has scrolled to the bottom of the document.
    $termsUrl = route('legal.content', 'terms-conditions');

    $policySlugs = [
        'privacy-policy' => 'Privacy Policy',
        'cookies-policy' => 'Cookies Policy',
        'terms-of-use' => 'Terms of Use',
        'terms-conditions' => 'Terms & Conditions',
    ];

    // Only link policies that actually exist and are published, so the
    // registration form never points at a 404.
    try {
        $publishedSlugs = Schema::hasTable('legal_pages')
            ? LegalPage::query()->published()->whereIn('slug', array_keys($policySlugs))->pluck('title', 'slug')->all()
            : [];
    } catch (\Throwable $exception) {
        $publishedSlugs = [];
    }

    $links = [];
    foreach ($policySlugs as $slug => $fallbackTitle) {
        if (array_key_exists($slug, $publishedSlugs)) {
            $links[] = [
                'title' => $publishedSlugs[$slug] ?: $fallbackTitle,
                'url' => route('legal.page', $slug),
            ];
        }
    }
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-data="{
            accepted: $wire.get(@js($statePath)) === true,
            open: false,
            loading: false,
            error: null,
            title: 'Terms & Conditions',
            body: '',
            reachedBottom: false,

            toggle() {
                if (this.accepted) {
                    // Unticking resets the read-receipt, so the document must be
                    // re-read before the box can be ticked again.
                    this.accepted = false;
                    this.reachedBottom = false;
                    this.sync();

                    return;
                }

                this.openModal();
            },

            async openModal() {
                this.open = true;
                this.reachedBottom = false;
                this.error = null;
                document.body.style.overflow = 'hidden';

                if (this.body === '') {
                    this.loading = true;

                    try {
                        const response = await fetch(@js($termsUrl), {
                            headers: { 'Accept': 'application/json' },
                        });

                        if (! response.ok) {
                            throw new Error('Unable to load the Terms & Conditions.');
                        }

                        const payload = await response.json();
                        this.title = payload.data.title;
                        this.body = payload.data.content;
                    } catch (failure) {
                        this.error = 'We could not load the Terms & Conditions right now. Please open them in a new tab and try again.';
                    } finally {
                        this.loading = false;
                    }
                }

                this.$nextTick(() => this.checkScroll());
            },

            closeModal() {
                this.open = false;
                document.body.style.overflow = '';
            },

            // The content box may be shorter than its container (short document
            // or a load error), in which case there is nothing to scroll and we
            // unlock immediately.
            checkScroll() {
                const content = this.$refs.content;

                if (! content) {
                    return;
                }

                if (content.scrollHeight <= content.clientHeight + 5) {
                    this.reachedBottom = true;

                    return;
                }

                this.reachedBottom = content.scrollTop + content.clientHeight >= content.scrollHeight - 5;
            },

            agree() {
                if (! this.reachedBottom) {
                    return;
                }

                this.accepted = true;
                this.sync();
                this.closeModal();
            },

            sync() {
                $wire.set(@js($statePath), this.accepted);
            },
        }"
    >
        <label class="tc-consent">
            <input
                type="checkbox"
                class="tc-consent-box"
                :checked="accepted"
                @click.prevent="toggle()"
            />

            <span class="tc-consent-text">
                I have read and accept the
                @foreach ($links as $index => $link)
                    <a
                        href="{{ $link['url'] }}"
                        target="_blank"
                        rel="noopener"
                        @click.stop
                    >{{ $link['title'] }}</a>@if ($index === count($links) - 2) and @elseif ($index < count($links) - 1), @endif
                @endforeach
                @if ($links === [])
                    Terms &amp; Conditions
                @endif
            </span>
        </label>

        {{-- Forced-scroll acceptance modal, matching the VOpen Market sign-up. --}}
        <template x-teleport="body">
            <div x-show="open" x-cloak class="tc-overlay" role="dialog" aria-modal="true" aria-labelledby="tc-title">
                <div class="tc-modal">
                    <h2 class="tc-modal-title" id="tc-title" x-text="title"></h2>

                    <p
                        class="tc-banner"
                        :class="reachedBottom ? 'is-ready' : ''"
                        x-text="reachedBottom ? 'You have reached the bottom. You can now accept.' : 'Scroll to the bottom to enable acceptance.'"
                    ></p>

                    <div x-ref="content" @scroll="checkScroll()" class="tc-content">
                        <p x-show="loading" class="tc-status">Loading…</p>
                        <p x-show="error" x-text="error" class="tc-status tc-status-error"></p>
                        <div x-show="! loading && ! error" x-html="body"></div>
                    </div>

                    <div class="tc-actions">
                        <button type="button" class="tc-agree" @click="agree()" :disabled="! reachedBottom">
                            I Agree
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Filament ships a precompiled stylesheet, so utility classes used only in
         this view would never be generated. The modal carries its own CSS, and
         it is inlined rather than pushed to a stack the panel layout may not render. --}}
    <style>
                [x-cloak] { display: none !important; }

                .tc-consent { display: flex; align-items: flex-start; gap: .625rem; cursor: pointer; }
                .tc-consent-box { margin-top: .15rem; width: 1.1rem; height: 1.1rem; flex: none; cursor: pointer; accent-color: #216e83; }
                .tc-consent-text { font-size: .875rem; line-height: 1.5rem; color: rgb(55 65 81); }
                .dark .tc-consent-text { color: rgb(209 213 219); }
                .tc-consent-text a { color: #2f7f97; font-weight: 600; text-decoration: underline; text-underline-offset: 2px; }
                .tc-consent-text a:hover { color: #216e83; }

                .tc-overlay {
                    position: fixed; inset: 0; z-index: 60;
                    display: flex; align-items: center; justify-content: center;
                    padding: 1rem; background: rgba(0, 0, 0, .4);
                }

                .tc-modal {
                    display: flex; flex-direction: column;
                    width: 100%; max-width: 800px; max-height: 88vh;
                    padding: 1.5rem;
                    background: #fff; border-radius: 5px;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
                    text-align: center;
                }

                .tc-modal-title {
                    margin: .5rem 0 1.75rem;
                    font-size: 1.6rem; font-weight: 600; line-height: 1.3;
                    color: #595959;
                }

                .tc-banner {
                    margin: 0 0 1rem;
                    padding: .7rem 1rem;
                    border: 1px solid #f0dca8; border-radius: 4px;
                    background: #fdf8ec;
                    font-size: .9rem; font-weight: 500; color: #8a6d3b;
                }
                .tc-banner.is-ready { border-color: #bfe3c8; background: #f2faf4; color: #1f7a3d; }

                .tc-content {
                    flex: 1 1 auto; min-height: 0;
                    overflow-y: auto;
                    padding: 1rem 1.1rem;
                    border: 1px solid #ddd; border-radius: 6px;
                    background: #fff;
                    text-align: left;
                    font-size: .95rem; line-height: 1.6; color: #4a4a4a;
                }

                .tc-status { text-align: center; color: #777; }
                .tc-status-error { color: #b42318; }

                .tc-content h2 { margin: 0 0 1rem; font-size: 1.15rem; font-weight: 700; color: #333; }
                .tc-content h3 { margin: 1.5rem 0 .5rem; font-size: 1rem; font-weight: 700; color: #333; }
                .tc-content p { margin: 0 0 1rem; }
                .tc-content strong { font-weight: 600; color: #333; }
                .tc-content ul, .tc-content ol { margin: 0 0 1rem; padding-left: 1.25rem; }
                .tc-content ul { list-style: disc; }
                .tc-content ol { list-style: decimal; }
                .tc-content li { margin-bottom: .3rem; }
                .tc-content a { color: #2f7f97; text-decoration: underline; }

                .tc-actions { display: flex; justify-content: center; padding-top: 1.5rem; }

                .tc-agree {
                    min-width: 90px;
                    padding: .65rem 1.4rem;
                    border: 0; border-radius: 4px;
                    background: #216e83; color: #fff;
                    font-size: .95rem; font-weight: 500;
                    cursor: pointer;
                    transition: background-color .15s ease, opacity .15s ease;
                }
                .tc-agree:hover:not(:disabled) { background: #1b5c6e; }
                .tc-agree:disabled { opacity: .5; cursor: not-allowed; }
    </style>
</x-dynamic-component>

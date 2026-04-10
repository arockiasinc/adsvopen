@extends('layouts.app')

@section('title', 'Banners - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Homepage Manager')
@section('page_heading', 'Banners')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Banners</h1>
            <p class="mb-0 text-muted">Manage the homepage slider content and images without changing the existing design.</p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex flex-wrap">
            <span class="badge badge-primary badge-pill px-3 py-2 mr-2 mb-2">{{ $banners->count() }} Banner Slides</span>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm mb-2">Back to Dashboard</a>
        </div>
    </div>
@endsection

@section('content')
    @if (empty($bannerTableReady) || ! $bannerTableReady)
        <div class="alert alert-warning shadow-sm" role="alert">
            Banner management is almost ready. Run <code>php artisan migrate</code> to create the <code>banners</code> table, then refresh this page.
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success shadow-sm" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Banner</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Upload a banner image and fill in the content fields you want to show on the homepage slide.</p>

                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <fieldset {{ empty($bannerTableReady) || ! $bannerTableReady ? 'disabled' : '' }}>

                        <div class="form-group">
                            <label for="banner-image">Banner Image</label>
                            <input id="banner-image" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.svg" required>
                        </div>

                        <div class="form-group">
                            <label for="banner-title">Title</label>
                            <input id="banner-title" name="title" type="text" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="banner-copy">Copy</label>
                            <textarea id="banner-copy" name="copy" class="form-control" rows="3">{{ old('copy') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="banner-detail">Detail</label>
                            <textarea id="banner-detail" name="detail" class="form-control" rows="2">{{ old('detail') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="banner-footer">Footer</label>
                            <textarea id="banner-footer" name="footer" class="form-control" rows="2">{{ old('footer') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="banner-highlights">Highlights</label>
                            <textarea id="banner-highlights" name="highlights" class="form-control" rows="4" placeholder="One item per line">{{ old('highlights') }}</textarea>
                            <small class="form-text text-muted">Each line becomes one pill in the banner.</small>
                        </div>

                        <div class="form-group">
                            <label for="banner-button-rows">Button Rows</label>
                            <textarea id="banner-button-rows" name="button_rows" class="form-control" rows="4" placeholder="Banner Ads | Contractor Listing Ads | Contractors Display Ads">{{ old('button_rows') }}</textarea>
                            <small class="form-text text-muted">Use one row per line and separate items with the <strong>|</strong> symbol.</small>
                        </div>

                        <div class="form-group">
                            <label for="banner-sort-order">Display Order</label>
                            <input id="banner-sort-order" name="sort_order" type="number" class="form-control" value="{{ old('sort_order', $banners->count() + 1) }}" min="0" max="999" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus mr-1"></i>
                            Add Banner
                        </button>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Content Guide</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 pl-3 text-muted small">
                        <li class="mb-2">Title is the only required content field besides the image.</li>
                        <li class="mb-2">Leave optional fields empty when a slide only needs part of the existing design.</li>
                        <li>Use display order to control which slide shows first on the homepage.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            @forelse ($banners as $banner)
                @php
                    $highlightText = implode("\n", $banner->highlights ?? []);
                    $buttonRowText = collect($banner->button_rows ?? [])
                        ->map(fn ($row) => implode(' | ', $row))
                        ->implode("\n");
                @endphp
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold text-primary">Slide #{{ $loop->iteration }}</h6>
                            <div class="small text-muted mt-1">Update text, replace the image, or remove this banner.</div>
                        </div>
                        <span class="badge badge-light border text-uppercase mt-3 mt-md-0">Order {{ $banner->sort_order }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="img-fluid rounded border">
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group">
                                        <label for="banner-image-{{ $banner->id }}">Replace Image</label>
                                        <input id="banner-image-{{ $banner->id }}" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.svg">
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-title-{{ $banner->id }}">Title</label>
                                        <input id="banner-title-{{ $banner->id }}" name="title" type="text" class="form-control" value="{{ $banner->title }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-copy-{{ $banner->id }}">Copy</label>
                                        <textarea id="banner-copy-{{ $banner->id }}" name="copy" class="form-control" rows="3">{{ $banner->copy }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-detail-{{ $banner->id }}">Detail</label>
                                        <textarea id="banner-detail-{{ $banner->id }}" name="detail" class="form-control" rows="2">{{ $banner->detail }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-footer-{{ $banner->id }}">Footer</label>
                                        <textarea id="banner-footer-{{ $banner->id }}" name="footer" class="form-control" rows="2">{{ $banner->footer }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-highlights-{{ $banner->id }}">Highlights</label>
                                        <textarea id="banner-highlights-{{ $banner->id }}" name="highlights" class="form-control" rows="4">{{ $highlightText }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-button-rows-{{ $banner->id }}">Button Rows</label>
                                        <textarea id="banner-button-rows-{{ $banner->id }}" name="button_rows" class="form-control" rows="4">{{ $buttonRowText }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner-order-{{ $banner->id }}">Display Order</label>
                                        <input id="banner-order-{{ $banner->id }}" name="sort_order" type="number" class="form-control" value="{{ $banner->sort_order }}" min="0" max="999" required>
                                    </div>

                                    <div class="d-flex flex-wrap">
                                        <button type="submit" class="btn btn-primary mr-2 mb-2 mb-sm-0">Save</button>
                                </form>
                                <form action="{{ route('banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow mb-4">
                    <div class="card-body text-center text-muted py-5">No banners found yet. Add your first slide from the panel on the left.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

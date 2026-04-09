@extends('layouts.app')

@section('title', 'Edit Ads - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'Edit Ads')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Edit Ads</h1>
            <p class="mb-0 text-muted">Update campaign settings, placements, messaging, and budget.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('campaigns.show', $campaign['id']) }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                <i class="fas fa-eye fa-sm mr-1"></i>
                View My Ad
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow mb-4" id="edit-ads">
        <div class="card-body">
            <form method="POST" action="{{ route('campaigns.update', $campaign['id']) }}">
                @csrf
                @method('PATCH')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="title">Campaign Title</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $campaign['title']) }}"
                            required
                        >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="objective">Objective</label>
                        <input
                            id="objective"
                            name="objective"
                            type="text"
                            class="form-control @error('objective') is-invalid @enderror"
                            value="{{ old('objective', $campaign['objective']) }}"
                            required
                        >
                        @error('objective')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="format">Ad Format</label>
                        <input
                            id="format"
                            name="format"
                            type="text"
                            class="form-control @error('format') is-invalid @enderror"
                            value="{{ old('format', $campaign['format']) }}"
                            required
                        >
                        @error('format')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="daily_budget">Daily Budget</label>
                        <input
                            id="daily_budget"
                            name="daily_budget"
                            type="number"
                            min="25"
                            class="form-control @error('daily_budget') is-invalid @enderror"
                            value="{{ old('daily_budget', $campaign['daily_budget']) }}"
                            required
                        >
                        @error('daily_budget')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="headline">Ad Headline</label>
                    <input
                        id="headline"
                        name="headline"
                        type="text"
                        class="form-control @error('headline') is-invalid @enderror"
                        value="{{ old('headline', $campaign['headline']) }}"
                        required
                    >
                    @error('headline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="copy">Ad Copy</label>
                    <textarea
                        id="copy"
                        name="copy"
                        rows="4"
                        class="form-control @error('copy') is-invalid @enderror"
                        required
                    >{{ old('copy', $campaign['copy']) }}</textarea>
                    @error('copy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cta">Call To Action</label>
                        <input
                            id="cta"
                            name="cta"
                            type="text"
                            class="form-control @error('cta') is-invalid @enderror"
                            value="{{ old('cta', $campaign['cta']) }}"
                            required
                        >
                        @error('cta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="start_date">Start Date</label>
                        <input
                            id="start_date"
                            name="start_date"
                            type="date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $campaign['start_date']) }}"
                            required
                        >
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="end_date">End Date</label>
                        <input
                            id="end_date"
                            name="end_date"
                            type="date"
                            class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', $campaign['end_date']) }}"
                            required
                        >
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-block">Placements</label>
                    <div class="form-row">
                        @foreach ($availablePlacements as $placement)
                            <div class="col-md-6 mb-2">
                                <div class="custom-control custom-checkbox border rounded p-3">
                                    <input
                                        id="placement_{{ \Illuminate\Support\Str::slug($placement) }}"
                                        name="placements[]"
                                        type="checkbox"
                                        value="{{ $placement }}"
                                        class="custom-control-input"
                                        @checked(in_array($placement, old('placements', $campaign['placements']), true))
                                    >
                                    <label class="custom-control-label" for="placement_{{ \Illuminate\Support\Str::slug($placement) }}">{{ $placement }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('placements')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Campaign Changes</button>
            </form>
        </div>
    </div>
@endsection

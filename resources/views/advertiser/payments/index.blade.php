@extends('layouts.app')

@section('title', 'Payment History - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Advertiser Workspace')
@section('page_heading', 'Payment History')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Payment History</h1>
            <p class="mb-0 text-muted">Track recent advertising charges and download receipts.</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Receipts</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $receiptCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paid Total</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">${{ number_format($paidTotal, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Last Payment</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \Illuminate\Support\Carbon::parse($lastPaymentDate)->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4" id="download-receipts">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Download Receipts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Campaign</th>
                            <th>Issued On</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td class="font-weight-bold text-gray-800">{{ $receipt['invoice_number'] }}</td>
                                <td>{{ $receipt['campaign_title'] }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($receipt['issued_on'])->format('M d, Y') }}</td>
                                <td>${{ number_format($receipt['amount'], 2) }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $receipt['status'] }}</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('payments.receipts.download', $receipt['id']) }}" class="btn btn-primary btn-sm">Download Receipt</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

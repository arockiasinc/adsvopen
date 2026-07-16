<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt {{ $payment->invoice_number }}</title>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Public Sans', Arial, sans-serif; color: #141922; margin: 0; padding: 40px; background: #f4f4f5; }
    .receipt { max-width: 720px; margin: 0 auto; background: #fff; padding: 48px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    .receipt-head { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #ff6507; padding-bottom: 24px; margin-bottom: 32px; }
    .brand { font-size: 22px; font-weight: 800; }
    .brand small { display: block; font-weight: 500; color: #6b7280; font-size: 13px; }
    h1 { font-size: 28px; margin: 0 0 4px; }
    .muted { color: #6b7280; font-size: 14px; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin: 32px 0; }
    .grid h2 { font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: #6b7280; margin: 0 0 8px; }
    table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    th, td { text-align: left; padding: 12px 0; border-bottom: 1px solid #e5e7eb; font-size: 15px; }
    th { color: #6b7280; font-weight: 600; }
    .total-row td { border-bottom: none; font-size: 18px; font-weight: 800; padding-top: 20px; }
    .status { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 700;
      background: {{ $payment->status === 'Paid' ? '#ffe3d0' : '#ffffff' }};
      color: {{ $payment->status === 'Paid' ? '#ff6507' : '#ff6507' }}; }
    .actions { max-width: 720px; margin: 0 auto 16px; text-align: right; }
    .btn { display: inline-block; background: #ff6507; color: #141922; font-weight: 700; padding: 10px 20px;
      border-radius: 8px; border: 0; cursor: pointer; text-decoration: none; font-size: 14px; }
    @media print { body { background: #fff; padding: 0; } .actions { display: none; } .receipt { box-shadow: none; } }
  </style>
</head>
<body>
  <div class="actions">
    <button class="btn" onclick="window.print()">Print / Save as PDF</button>
  </div>

  <div class="receipt">
    <div class="receipt-head">
      <div>
        <h1>Receipt</h1>
        <div class="muted">{{ $payment->invoice_number }}</div>
      </div>
      <div class="brand">
        Adsvopen
        <small>Advertising receipt</small>
      </div>
    </div>

    <div class="grid">
      <div>
        <h2>Billed to</h2>
        <div>{{ $payment->user->name }}</div>
        <div class="muted">{{ $payment->user->email }}</div>
      </div>
      <div>
        <h2>Details</h2>
        <div class="muted">Issued: {{ optional($payment->issued_on)->format('F j, Y') }}</div>
        <div class="muted">Status: <span class="status">{{ $payment->status }}</span></div>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Description</th>
          <th style="text-align:right;">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ $payment->campaign_title ?: 'Advertising services' }}
            @if ($payment->campaign)
              <div class="muted">Campaign: {{ $payment->campaign->title }}</div>
            @endif
          </td>
          <td style="text-align:right;">${{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr class="total-row">
          <td>Total</td>
          <td style="text-align:right;">${{ number_format($payment->amount, 2) }}</td>
        </tr>
      </tbody>
    </table>

    <p class="muted" style="margin-top:40px;">Thank you for advertising with Adsvopen.</p>
  </div>
</body>
</html>

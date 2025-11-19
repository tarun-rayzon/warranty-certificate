<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .header { text-align:center; margin-bottom: 16px; }
    .badge { border:1px solid #000; padding:4px 8px; display:inline-block; }
    table { width:100%; border-collapse: collapse; margin-top:12px; }
    th, td { border:1px solid #000; padding:6px; text-align:left; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Warranty Certificate</h2>
    <div class="badge">{{ $certificateNo }}</div>
    <div>Issued: {{ $issuedAt }}</div>
  </div>
  <p><strong>Customer:</strong> {{ $req->customer->name }} ({{ $req->customer->email }})</p>
  <p><strong>Address:</strong> {{ $req->customer->address }}, {{ $req->customer->city }}, {{ $req->customer->state }} - {{ $req->customer->pincode }}</p>
  <p><strong>Invoice No:</strong> {{ $req->invoice_no }} | <strong>Purchase Date:</strong> {{ \Illuminate\Support\Carbon::parse($req->purchase_date)->toDateString() }}</p>

  <table>
    <thead><tr><th>#</th><th>Serial</th><th>Status</th></tr></thead>
    <tbody>
      @foreach($req->items as $i => $item)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $item->serial }}</td>
          <td>Covered</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <p style="margin-top:12px;">This certificate confirms coverage as per company’s warranty terms and conditions.</p>
</body>
</html>

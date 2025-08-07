<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: sans-serif; }
        h2{
            font-size: 20px;
        }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .footer { margin-top: 30px; font-size: 20px; text-align: center; justify-self: center;}
    </style>
</head>
<body>
    <div class="header">
        <h1>Talent Bridge</h1>

        <h2>Payment Receipt</h2>
    </div>

    <div class="info">
        <strong>Receipt No:</strong> #{{ $payment->id }} <br>
        <strong>Date:</strong> {{ $payment->created_at->format('d M Y') }} <br>
        <strong>Amount:</strong> KES {{ number_format($payment->amount, 2) }} <br>
        <strong>Status:</strong> {{ ucfirst($payment->status->name) }} <br>
    </div>

    <div class="info">
        <strong>Paid By:</strong> {{  $payment->client->first_name}}  {{ $payment->client->surname }} <br>
        <strong>Email:</strong> {{ $payment->client->email }} <br>
    </div>

    <div class="footer">
        Thank you for your payment.
    </div>
</body>
</html>

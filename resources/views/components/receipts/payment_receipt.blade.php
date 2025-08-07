<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $application->application_code }}</title>
    <style>
        @page {
            size: 80mm 200mm;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            width: 76mm;
            margin: 2mm;
            padding: 0;
            color: #000;
            background: #fff;
        }
        
        .receipt {
            width: 100%;
            border-collapse: collapse;
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .receipt-info {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .receipt-info td {
            padding: 2px 0;
        }
        
        .receipt-info td.label {
            font-weight: bold;
            width: 40%;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .items th {
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-align: left;
        }
        
        .items td {
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
        }
        
        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 10px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 10px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .barcode {
            margin: 10px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Talent Bridge</div>
        <!-- <div>123 Business Street</div>
        <div>City, Country</div>
        <div>Tel: +123 456 7890</div> -->
    </div>
    
    <div class="receipt-title">PAYMENT RECEIPT</div>
    
    <table class="receipt-info">
        <tr>
            <td class="label">Receipt No:</td>
            <td>{{ $application->application_code }}</td>
        </tr>
        <tr>
            <td class="label">Date:</td>
            <td>{{ now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">Client:</td>
            <td>{{ $client->first_name }} {{ $client->surname }}</td>
        </tr>
        <tr>
            <td class="label">ID/Passport:</td>
            <td>{{ $client->id_number ?? $client->passport_number }}</td>
        </tr>
        <tr>
            <td class="label">Position Applied:</td>
            <td>{{ $application->career->name }}</td>
        </tr>
    </table>
    
    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Application Fee</td>
                <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <td>Balance</td>
                <td class="text-right">{{ number_format($payment->balance, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="total text-right">
        Total Paid: {{ number_format($payment->amount, 2) }}
    </div>
    
    <div class="barcode">
        <!-- You can add a barcode here if needed -->
        *{{ $application->application_code }}*
    </div>
    
    <div class="footer">
        Thank you for your payment!<br>
        This is an official receipt<br>
        {{ now()->format('d F Y H:i') }}<br>
        Powered by Talent Bridge
    </div>
</body>
</html>
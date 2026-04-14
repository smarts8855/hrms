<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPO #{{ $lpo->lpo_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #00a65a;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #00a65a;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
        }
        .section-title {
            background: #f5f5f5;
            padding: 8px 15px;
            margin: -15px -15px 15px -15px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .amount {
            font-weight: bold;
            color: #00a65a;
        }
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 30%;
            float: left;
            margin-right: 3%;
            border: 1px solid #ddd;
            padding: 10px;
            min-height: 100px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LOCAL PURCHASE ORDER</h1>
        <h2>LPO Number: {{ $lpo->lpo_number }}</h2>
        <p>Date: {{ date('d M, Y', strtotime($lpo->order_date)) }}</p>
    </div>

    <!-- Supplier Information -->
    <div class="section">
        <div class="section-title">SUPPLIER INFORMATION</div>
        <table>
            <tr>
                <td width="20%"><strong>Supplier Name:</strong></td>
                <td width="80%">{{ $lpo->supplier_name }}</td>
            </tr>
            @if($lpo->supplier_address)
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $lpo->supplier_address }}</td>
            </tr>
            @endif
            <tr>
                <td><strong>Delivery Date:</strong></td>
                <td>{{ $lpo->delivery_date ? date('d M, Y', strtotime($lpo->delivery_date)) : 'Not specified' }}</td>
            </tr>
        </table>
    </div>

    <!-- Items Table -->
    <div class="section">
        <div class="section-title">ITEMS TO PURCHASE</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Item Description</th>
                    <th width="10%">Quantity</th>
                    <th width="10%">Unit</th>
                    <th width="15%">Unit Price (₦)</th>
                    <th width="15%">Total (₦)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = is_string($lpo->items) ? json_decode($lpo->items, true) : $lpo->items;
                    $total = 0;
                @endphp
                @foreach($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-center">{{ $item['unit'] ?? 'pcs' }}</td>
                    <td class="text-right">₦{{ number_format($item['unit_price'], 2) }}</td>
                    <td class="text-right amount">₦{{ number_format($item['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">GRAND TOTAL:</th>
                    <th class="text-right amount">₦{{ number_format($lpo->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Authority Section -->
    <div class="section">
        <div class="section-title">AUTHORITY FOR LOCAL PURCHASE</div>
        <p>Please supply for the use of this Department: (Articles not supplied should be deleted and the form should be returned if no supply is made).</p>
    </div>

    <!-- Signature Sections - 3 in a row -->
    <div class="signature-section" style="display: flex; gap: 20px; margin-top: 30px; page-break-inside: avoid;">
        <!-- Section A: Head of Department -->
        <div style="flex: 1; border: 1px solid #ddd; padding: 15px; min-height: 200px; background: #fff;">
            <h4 style="margin-top: 0; color: #00a65a; border-bottom: 1px solid #00a65a; padding-bottom: 5px;">Section A - Head of Department</h4>
            <p style="font-style: italic; font-size: 11px; color: #555;"><em>I certify that the stores mentioned above have been received and have been applied to the purpose for which they were bought.</em></p>
            <p><strong>Allocation Head:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->allocation_head ?? '________________' }}</span></p>
            <p><strong>Sub-head:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->sub_head ?? '________________' }}</span></p>
            <p><strong>Head of Department:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->head_of_department_name ?? '________________' }}</span></p>
            <p><strong>Date:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->hod_date ? date('d M, Y', strtotime($lpo->hod_date)) : '________________' }}</span></p>
        </div>

        <!-- Section B: Store Keeper -->
        <div style="flex: 1; border: 1px solid #ddd; padding: 15px; min-height: 200px; background: #fff;">
            <h4 style="margin-top: 0; color: #00a65a; border-bottom: 1px solid #00a65a; padding-bottom: 5px;">Section B - Store Keeper</h4>
            <p style="font-style: italic; font-size: 11px; color: #555;"><em>TO THE STORE KEEPER: The Stores listed above should be taken on Charge in your stores ledger.</em></p>
            <p><strong>Head of Department:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->head_of_department_name ?? '________________' }}</span></p>
            <hr style="margin: 10px 0; border-top: 1px dashed #ccc;">
            <p><strong>Store Keeper:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->store_keeper_name ?? '________________' }}</span></p>
            <p><strong>Date:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->store_keeper_date ? date('d M, Y', strtotime($lpo->store_keeper_date)) : '________________' }}</span></p>
        </div>

        <!-- Section C: Receiving Officer -->
        <div style="flex: 1; border: 1px solid #ddd; padding: 15px; min-height: 200px; background: #fff;">
            <h4 style="margin-top: 0; color: #00a65a; border-bottom: 1px solid #00a65a; padding-bottom: 5px;">Section C - Receiving Officer</h4>
            <p style="font-style: italic; font-size: 11px; color: #555;"><em>I certify that the above-mentioned stores have been received and taken on store-ware under SERV. NO.</em></p>
            <p><strong>SERV. NO.:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->store_serv_no ?? '________________' }}</span></p>
            <hr style="margin: 10px 0; border-top: 1px dashed #ccc;">
            <p><strong>Receiving Officer:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->receiving_officer_name ?? '________________' }}</span></p>
            <p><strong>Date:</strong> <span style="border-bottom: 1px dotted #999;">{{ $lpo->receiving_date ? date('d M, Y', strtotime($lpo->receiving_date)) : '________________' }}</span></p>
        </div>
    </div>

    <!-- Notes -->
    <div style="margin-top: 20px; font-size: 10px; color: #666;">
        <p><strong>Note 1:</strong> Where (b) is applicable "by" should be deleted and free words inserted.</p>
        <p><strong>Note 2:</strong> Delete portion not applicable in (c).</p>
    </div>

    <!-- Status -->
    <div style="margin-top: 20px; text-align: right;">
        <strong>Status:</strong> {{ strtoupper($lpo->status) }}
    </div>

    <div class="footer">
        <p>This is a computer generated document. No signature is required.</p>
        <p>Generated on: {{ date('d M, Y h:i A') }}</p>
    </div>

    <!-- Print Button -->
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #00a65a; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
            <i class="fa fa-print"></i> Print / Save as PDF
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Nota Dinas {{ $document_number }}</title>
    <style>
        @page {
            margin: 2cm 2.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 10pt;
            margin-bottom: 10px;
        }
        .document-title {
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 30px 0;
        }
        .document-info {
            margin-bottom: 30px;
        }
        .document-info table {
            width: 100%;
        }
        .document-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .label {
            width: 120px;
            font-weight: normal;
        }
        .content {
            text-align: justify;
            margin: 30px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .items-table td.center {
            text-align: center;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 20px;
        }
        .signature-space {
            height: 80px;
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">PT. INVENTORY MANAGEMENT SYSTEM</div>
        <div class="company-address">
            Jl. Sudirman No. 123, Jakarta Pusat 10110<br>
            Telp: (021) 555-1234 | Email: info@inventoryms.com
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title" style="text-align: center;">
        NOTA DINAS INTERNAL
    </div>

    <!-- Document Information -->
    <div class="document-info">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td>: {{ $document_number }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $date }}</td>
            </tr>
            <tr>
                <td class="label">Kepada</td>
                <td>: {{ $recipient }}</td>
            </tr>
            <tr>
                <td class="label">Dari</td>
                <td>: Bagian Inventori</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td>: {{ $subject }}</td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <div class="content">
        <p>Dengan hormat,</p>

        @if($content)
            <p>{{ $content }}</p>
        @else
            <p>
                Bersama ini kami sampaikan bahwa permintaan barang dengan nomor
                <strong>{{ $request->request_number }}</strong>
                yang diajukan oleh <strong>{{ $request->requestor_name }}</strong>
                dari bagian <strong>{{ $request->department }}</strong>
                pada tanggal {{ $request->request_date->format('d F Y') }}
                telah selesai diproses.
            </p>
        @endif

        <p>Adapun rincian barang yang telah diserahkan adalah sebagai berikut:</p>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kode Barang</th>
                    <th style="width: 40%;">Nama Barang</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th style="width: 10%;">Satuan</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($request->requestItems as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $item->itemType->code }}</td>
                    <td>{{ $item->itemType->name }}</td>
                    <td class="center">{{ $item->qty_fulfilled }}</td>
                    <td class="center">{{ $item->itemType->unit }}</td>
                    <td class="center">
                        @switch($item->status)
                            @case('fulfilled')
                                Terpenuhi
                                @break
                            @case('partial')
                                Sebagian
                                @break
                            @case('vendor_needed')
                                Perlu Vendor
                                @break
                            @default
                                Pending
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            Demikian nota dinas ini kami sampaikan. Atas perhatian dan kerjasamanya,
            kami ucapkan terima kasih.
        </p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div>Jakarta, {{ $date }}</div>
                    <div style="margin-top: 10px;">Mengetahui,</div>
                    <div style="margin-top: 5px;"><strong>Kepala Bagian Inventori</strong></div>
                    <div class="signature-space"></div>
                    <div><strong>_________________________</strong></div>
                </td>
                <td class="signature-cell">
                    <div>&nbsp;</div>
                    <div style="margin-top: 10px;">Dibuat oleh,</div>
                    <div style="margin-top: 5px;"><strong>Staff Inventori</strong></div>
                    <div class="signature-space"></div>
                    <div><strong>{{ $request->user->username }}</strong></div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>BAPBJ {{ $document_number }}</title>
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
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 20px;
        }
        .signature-space {
            height: 80px;
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }
        .vendor-info {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            margin: 20px 0;
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
        BERITA ACARA PENERIMAAN BARANG JASA<br>
        (BAPBJ)
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
                <td class="label">No. Purchase Order</td>
                <td>: {{ $purchase_order->po_number }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal PO</td>
                <td>: {{ $purchase_order->po_date->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Vendor Information -->
    <div class="vendor-info">
        <strong>INFORMASI VENDOR:</strong><br>
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td class="label">Nama Vendor</td>
                <td>: {{ $purchase_order->vendor->name }}</td>
            </tr>
            <tr>
                <td class="label">Contact Person</td>
                <td>: {{ $purchase_order->vendor->contact_person }}</td>
            </tr>
            <tr>
                <td class="label">Telepon</td>
                <td>: {{ $purchase_order->vendor->phone }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: {{ $purchase_order->vendor->address }}</td>
            </tr>
        </table>
    </div>

    <!-- Content -->
    <div class="content">
        <p>
            Pada hari ini, {{ $date }}, telah diterima barang-barang sesuai dengan
            Purchase Order Nomor <strong>{{ $purchase_order->po_number }}</strong>
            dari vendor <strong>{{ $purchase_order->vendor->name }}</strong>
            oleh <strong>{{ $received_by }}</strong>.
        </p>

        <p>Adapun rincian barang yang diterima adalah sebagai berikut:</p>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kode Barang</th>
                    <th style="width: 40%;">Nama Barang</th>
                    <th style="width: 15%;">Jumlah Diterima</th>
                    <th style="width: 10%;">Satuan</th>
                    <th style="width: 15%;">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase_order->purchaseOrderItems as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $item->itemType->code }}</td>
                    <td>{{ $item->itemType->name }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="center">{{ $item->itemType->unit }}</td>
                    <td class="center">Baik</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($condition_notes)
        <p><strong>Catatan Kondisi Barang:</strong><br>
        {{ $condition_notes }}</p>
        @endif

        <p>
            Barang-barang tersebut telah diperiksa dan dinyatakan sesuai dengan
            spesifikasi yang tercantum dalam Purchase Order. Barang dalam kondisi baik
            dan layak untuk digunakan.
        </p>

        <p>
            Demikian Berita Acara Penerimaan Barang ini dibuat dengan sebenarnya
            dan dapat digunakan sebagaimana mestinya.
        </p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div>Yang Menyerahkan,</div>
                    <div style="margin-top: 5px;"><strong>{{ $purchase_order->vendor->name }}</strong></div>
                    <div class="signature-space"></div>
                    <div><strong>{{ $purchase_order->vendor->contact_person }}</strong></div>
                    <div style="font-size: 10pt;">Contact Person</div>
                </td>
                <td class="signature-cell">
                    <div>Yang Menerima,</div>
                    <div style="margin-top: 5px;"><strong>Staff Inventori</strong></div>
                    <div class="signature-space"></div>
                    <div><strong>{{ $received_by }}</strong></div>
                    <div style="font-size: 10pt;">Penerima Barang</div>
                </td>
                <td class="signature-cell">
                    <div>Mengetahui,</div>
                    <div style="margin-top: 5px;"><strong>Kepala Bagian</strong></div>
                    <div class="signature-space"></div>
                    <div><strong>_________________________</strong></div>
                    <div style="font-size: 10pt;">Kepala Bagian Inventori</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer Note -->
    <div style="margin-top: 30px; font-size: 10pt; font-style: italic; text-align: center; color: #666;">
        Dokumen ini dibuat secara otomatis oleh Sistem Manajemen Inventori<br>
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
    </div>
</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\GeneratedDocument;
use App\Models\Request as RequestModel;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = GeneratedDocument::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('documents.index', compact('documents'));
    }

    public function generateNotaDinas()
    {
        $requests = RequestModel::where('status', 'completed')
            ->with(['requestItems.itemType', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('documents.nota-dinas-form', compact('requests'));
    }

    public function createNotaDinas(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|exists:requests,id',
            'recipient' => 'required|string|max:100',
            'subject' => 'required|string|max:200',
            'content' => 'nullable|string',
        ]);

        $requestModel = RequestModel::with(['requestItems.itemType', 'user'])
            ->findOrFail($validated['request_id']);

        $documentNumber = $this->generateDocumentNumber('nota_dinas');

        $data = [
            'document_number' => $documentNumber,
            'date' => Carbon::now()->format('d F Y'),
            'recipient' => $validated['recipient'],
            'subject' => $validated['subject'],
            'content' => $validated['content'],
            'request' => $requestModel,
        ];

        $pdf = PDF::loadView('documents.templates.nota-dinas', $data);

        $filename = "nota-dinas-{$documentNumber}.pdf";
        $filepath = storage_path("app/documents/nota-dinas/{$filename}");

        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $pdf->save($filepath);

        GeneratedDocument::create([
            'document_type' => 'nota_dinas',
            'document_number' => $documentNumber,
            'file_path' => "documents/nota-dinas/{$filename}",
            'generated_by' => 1,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function generateBapbj()
    {
        $purchaseOrders = PurchaseOrder::where('status', 'completed')
            ->with(['vendor', 'purchaseOrderItems.itemType', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('documents.bapbj-form', compact('purchaseOrders'));
    }

    public function createBapbj(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_by' => 'required|string|max:100',
            'received_date' => 'required|date',
            'condition_notes' => 'nullable|string',
        ]);

        $purchaseOrder = PurchaseOrder::with(['vendor', 'purchaseOrderItems.itemType', 'user'])
            ->findOrFail($validated['purchase_order_id']);

        $documentNumber = $this->generateDocumentNumber('bapbj');

        $data = [
            'document_number' => $documentNumber,
            'date' => Carbon::parse($validated['received_date'])->format('d F Y'),
            'received_by' => $validated['received_by'],
            'condition_notes' => $validated['condition_notes'],
            'purchase_order' => $purchaseOrder,
        ];

        $pdf = PDF::loadView('documents.templates.bapbj', $data);

        $filename = "bapbj-{$documentNumber}.pdf";
        $filepath = storage_path("app/documents/bapbj/{$filename}");

        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $pdf->save($filepath);

        GeneratedDocument::create([
            'document_type' => 'bapbj',
            'document_number' => $documentNumber,
            'file_path' => "documents/bapbj/{$filename}",
            'generated_by' => 1,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function download(GeneratedDocument $document)
    {
        $filepath = storage_path("app/{$document->file_path}");

        if (!file_exists($filepath)) {
            return redirect()->route('documents.index')
                ->with('error', 'Document file not found.');
        }

        return response()->download($filepath);
    }

    public function destroy(GeneratedDocument $document)
    {
        $filepath = storage_path("app/{$document->file_path}");

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    private function generateDocumentNumber($type)
    {
        $prefix = strtoupper($type);
        $date = Carbon::now()->format('Ymd');
        $sequence = GeneratedDocument::where('document_type', $type)
            ->whereDate('created_at', Carbon::today())
            ->count() + 1;

        return "{$prefix}-{$date}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}
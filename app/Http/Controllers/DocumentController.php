<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultPaginationRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Resources\DocumentIndexResource;
use App\Http\Services\DocumentService;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DocumentController extends Controller
{
    public function __construct(private DocumentService $documentService)
    {
    }

    public function index(DefaultPaginationRequest $request): JsonResponse
    {
        [$data, $total] = $this->documentService->scopedPagination($request->get('page', 1), $request->get('page_size', 10));

        return response()->json(['documents' => DocumentIndexResource::collection($data)->additional(['page' => $request->get('page', 1), 'page_size' => $request->get('page_size', 10), 'total' => $total,])]);
    }

    public function store(): JsonResponse
    {
        return response()->json(['document' => new DocumentIndexResource($this->documentService->create())]);
    }

    public function update(UpdateDocumentRequest $request, $id): JsonResponse
    {
        return response()->json(['document' => new DocumentIndexResource($this->documentService->update($id, $request->get('document'))),]);
    }

    public function publish($id): JsonResponse
    {
        return response()->json(['document' => new DocumentIndexResource($this->documentService->publish($id))]);
    }
}

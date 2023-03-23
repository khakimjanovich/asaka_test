<?php

namespace App\Http\Services;

use App\Models\Document;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentService
{

    public function scopedPagination(int $page, int $page_size): array
    {
        $count = Document::all()->count();
        $data = Document::take($page_size)->skip($page_size * ($page - 1))->get();

        return [$data, $count];
    }

    public function create(): Document
    {
        return Document::create(['status' => Document::DRAFT]);
    }

    public function publish($id): Document
    {
        $document = $this->findOneById($id);
        $document->fill(['status' => Document::PUBLISHED])->save();
        return $document;
    }

    public function findOneById($id): Document
    {
        $document = Document::find($id);
        if (!$document) {
            throw new NotFoundHttpException('Model not found!');
        }

        return $document;
    }

    public function update($id, array $data): Document
    {
        $document = $this->findOneById($id);
        if ($document->status === Document::PUBLISHED) {
            throw new HttpException(400, 'Model cannot be updated');
        }

        if ($data['payload']) $document->payload = $this->removeNullValues(array_merge($document->payload ?? [], $data['payload']));

        $document->save();

        return $document;
    }

    private function removeNullValues(array $data): array
    {
        $filtered_data = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (sizeof($value) > 0)
                    $filtered_data[$key] = $this->removeNullValues($value);
            } else if ($value != null) {
                $filtered_data[$key] = $value;
            }
        }

        return $filtered_data;
    }
}

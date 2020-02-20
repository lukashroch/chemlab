<?php

namespace ChemLab\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as BaseResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BaseEntryResource extends BaseResource
{
    use AuditableTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return Str::endsWith($request->route()->getName(), 'audit') ?
            ['audit' => $this->withAudit()] : [];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        if ($request->method() == 'POST')
            $response->setStatusCode(201);
    }
}

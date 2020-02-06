<?php

namespace ChemLab\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as BaseResource;
use Illuminate\Http\Response;

class JsonResource extends BaseResource
{
    use ExportableTrait;

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

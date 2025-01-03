<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseJsonResource extends JsonResource
{
    private $message;
    private $status;

    public function __construct($resource, $message = 'Success', $status = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->status = $status;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->resource,
            'message' => $this->message,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->status);
    }
}

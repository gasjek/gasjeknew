<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct($status, $message, $resource = null)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    /**
     * Customize the response for a request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request), $this->status);
    }
}

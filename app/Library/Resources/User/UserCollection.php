<?php namespace Velent\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return [
            'users' => UserResource::collection($this->collection),
            'count' => $this->total(),
            'currentPage' => $this->currentPage(),
            'perPage' => $this->perPage(),
            'firstPageUrl' => $this->url(1),
            'previousPageUrl' => $this->previousPageUrl(),
            'nextPageUrl' => $this->nextPageUrl(),
            'lastPageUrl' => $this->url($this->lastPage()),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $stateId = $request->get('state_id');

        $cities = City::query()
            ->when($stateId, fn (Builder $builder) => $builder->whereStateId($stateId))
            ->get();

        return CityResource::collection($cities);
    }
}

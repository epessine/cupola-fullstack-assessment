<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $stateId = $request->get('state_id');
        $cityId = $request->get('city_id');
        $limit = $request->get('limit');
        $search = $request->get('search');

        $companies = Company::query()
            ->when($stateId, fn (Builder $builder) => $builder->whereRelation('city', 'state_id', $stateId))
            ->when($cityId, fn (Builder $builder) => $builder->whereCityId($cityId))
            ->when($search, fn (Builder $builder) => $builder->where('name', 'LIKE', "%$search%"))
            ->paginate(perPage: $limit);

        return CompanyResource::collection($companies);
    }
}

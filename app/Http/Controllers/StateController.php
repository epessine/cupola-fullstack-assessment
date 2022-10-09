<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StateController extends Controller
{
    public function index(): ResourceCollection
    {
        return StateResource::collection(State::all());
    }
}

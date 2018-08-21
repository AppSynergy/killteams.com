<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialismCollection as SpecialismCollectionResource;
use App\Models\Specialism;

class SpecialismController extends Controller
{
    public function index()
    {
        $specialisms = Specialism::with('abilities')->get();
        return new SpecialismCollectionResource($specialisms);
    }
}

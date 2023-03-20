<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'items' => Item::query()->when($request->input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->oldest()->limit(10)->get(),
            'filters' => $request->only(['search'])
        ]);
    }
}

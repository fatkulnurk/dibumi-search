<?php

namespace App\Http\Controllers;

use App\Scraps\GoogleSearch\GoogleSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $keyword = $request->query('q');
        $st = new GoogleSearch($keyword);
        $results = collect($st->result())->toArray();

        return $results;
        return view('search', compact('results', 'keyword'));
    }
}

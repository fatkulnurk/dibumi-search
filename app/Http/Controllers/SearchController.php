<?php

namespace App\Http\Controllers;

use App\Scraps\DuckDuckGo\DuckDuckGo;
use App\Scraps\GoogleSearch\GoogleSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $keyword = $request->query('q');
        $st = new GoogleSearch($keyword);
        $results = collect($st->result())->toArray();

        $results = [];
        $duckduckgo = new DuckDuckGo($keyword);
        $answer = collect($duckduckgo->result())->toArray();

        if ($request->query('type', '') == 'json') {
            return $results;
        }

        return view('search', compact('results', 'keyword', 'answer'));
    }
}

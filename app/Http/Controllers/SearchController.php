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
        $results = $st->result();

        return view('search', compact('results', 'keyword'));
    }
}

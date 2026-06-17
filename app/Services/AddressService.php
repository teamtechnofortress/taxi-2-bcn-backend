<?php

namespace App\Services;

use App\Models\AutocompleteSearch;
use App\Models\AutocompleteResult;

class AddressService
{
    public function search($keyword)
    {
        $keyword = strtolower(trim($keyword));

        return AutocompleteSearch::where(
            'keyword',
            $keyword
        )->first();
    }

    public function createSearch($keyword)
    {
        return AutocompleteSearch::create([
            'keyword' => strtolower(trim($keyword)),
            'status' => 'pending'
        ]);
    }

    public function getResults($searchId)
    {
        return AutocompleteResult::where(
            'search_id',
            $searchId
        )->get();
    }
}
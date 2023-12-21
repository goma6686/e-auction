<?php

namespace App\Repositories\Interfaces;

interface SearchRepositoryInterface
{
    public function searchAuctions($indexString, $q);
    public function getAlgoliaClient();
    public function getAlgoliaIndex($indexString);
    public function searchAuctionsByType($indexString, $type, $q);
    public function searchAuctionsByCategory($indexString, $category, $q);
    public function searchAuctionsByTypeAndCategory($indexString, $type, $category, $q);
    public function filterAuctionsByType($indexString, $type);
    public function filterAuctionsByCategory($indexString, $category);
    public function filterAuctionsByTypeAndCategory($indexString, $type, $category);
}
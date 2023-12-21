<?php

namespace App\Repositories;

use App\Models\Auction;
use App\Models\Category;
use Algolia\AlgoliaSearch\SearchClient;
use App\Repositories\Interfaces\SearchRepositoryInterface;

class SearchRepository implements SearchRepositoryInterface {

    public function getAlgoliaClient(){
        $client = SearchClient::create(
            config('scout.algolia.id'),
            config('scout.algolia.secret')
        );
        return $client;
    }

    public function getAlgoliaIndex($indexString)
    {
        $client = $this->getAlgoliaClient();
        $index = $client->initIndex($indexString);
        $index->setSettings([
            'searchableAttributes' => [
                'title',
                'description',
                'category',
                'type',
                'user',
                'images',
            ],
            'attributesForFaceting' => [
                'category',
                'type',
                'user',
            ],
            'customRanking' => [
                'desc(bids_count)',
                'desc(items.item_price)',
            ],
            'replicas' => [
                'auctions_price_asc',
                'auctions_price_desc',
                'auctions_end_time_asc',
                'auctions_end_time_desc',
            ],
        ]);
        return $index;
    }

    public function filterAuctionsByType($indexString, $type){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search('', [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'type:' . $type
        ]);
        return $results;
    }

    public function filterAuctionsByCategory($indexString, $category){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search('', [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'category:' . $category
        ]);
        return $results;
    }

    public function filterAuctionsByTypeAndCategory($indexString, $type, $category){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search('', [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'category:' . $category . ' AND type:' . $type
        ]);
        return $results;
    }

    public function searchAuctions($indexString, $q){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search($q, [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
        ]);
        return $results;
    }

    public function searchAuctionsByType($indexString, $type, $q){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search($q, [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'type:' . $type
        ]);
        return $results;
    }

    public function searchAuctionsByCategory($indexString, $category, $q){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search($q, [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'category:' . $category
        ]);
        return $results;
    }

    public function searchAuctionsByTypeAndCategory($indexString, $type, $category, $q){
        $index = $this->getAlgoliaIndex($indexString);
        $results = $index->search($q, [
            'attributesToRetrieve' => ['*'],
            'hitsPerPage' => 12,
            'attributesToHighlight' => ['*'],
            'filters' => 'category:' . $category . ' AND type:' . $type
        ]);
        return $results;
    }

}
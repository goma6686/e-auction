<?php

namespace App\Repositories\Interfaces;

interface AuctionRepositoryInterface
{
    public function getAuctionsEndedWithNoBids(): array;
    public function getSecondChanceAuctions(): array;
}
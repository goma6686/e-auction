<?php

namespace App\Repositories\Interfaces;

interface AuctionRepositoryInterface
{
    public function getAuctionsEndedWithNoBids(): array;
    public function getSecondChanceAuctions(): array;
    public function getFavouriteAuctions(): array;
    public function getActiveBids(): array;
    public function AllUserAuctions(): array;
    public function getWonAuctions(): array;
    public function getWaitingForPaymentAuctions(): array;
    public function getActionRequiredAuctions(): array;
}
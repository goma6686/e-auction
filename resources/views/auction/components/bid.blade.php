<div class="d-grid gap-2 col-6 ">
    <button class="btn btn-dark text-right" type="button" data-id="0" data-bs-toggle="modal" data-bs-target="#bid">Bid</button>
</div>
<h6 class="row">
    <div class="col-lg-7 text-start">
       [{{ $auction->bids()->count() }}] bids
    </div>
</h6>
@include('auction.components.bidmodal')
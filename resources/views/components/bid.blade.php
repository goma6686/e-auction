<h6 class="row">
    <div class="col-7 text-start" id="p1">
       [{{ $auction->bids()->count() }}] bids
    </div>
</h6>
<div class="d-grid gap-2 col-6 ">
    <button class="btn btn-dark text-right" type="button" data-id="0" data-bs-toggle="modal" data-bs-target="#bid">Bid</button>
</div>
@include('components.bidmodal')
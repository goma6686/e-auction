<h5>Place a bid, €:</h5>
<input id="bid_amount"  type="number" name="bid_amount" placeholder="Amount" step="0.01" min="{{$auction->next_price}}">
<button id="bid" class="button btn-sm btn-dark text-right" type="submit">Place a bid</button>
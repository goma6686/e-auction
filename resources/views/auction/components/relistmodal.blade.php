<div class="modal fade" id="relistModal" tabindex="-1" aria-labelledby="relistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered secondary">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="relistModalLabel">Choose Auction Duration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                @foreach($durations as $duration)
                    <form method="post" action="{{route('relist-auction', ['uuid' => $auction->uuid, 'duration' => $duration])}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button id="duration" type="submit" name='action' class="btn btn-dark"> {{ $duration }} days </button>
                    </form>
                @endforeach
            </div>
        </div>
      </div>
    </div>
</div>
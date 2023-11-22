<div>
    <h5 class="row">
        <div class="text-start">
            <label for="selectedItem">Select an option:</label>
            <select class="form-control"
                wire:model="selectedItem"
                wire:change="itemSelected($event.target.value)"
                required>
                @foreach($items as $item)
                <option
                    value="{{ $item }}">
                        {{$item->title}}
                    </option>
               @endforeach
            </select>
        </div>
    </h5>
    <h5 class="row">
        <div class="col-3">Condition:</div>
        <div class="col-7 text-start">{{ $condition }}</div>
    </h5>
    <h5 class="row">
        <div class="col-3">Price, €:</div>
        <div class="col-7 text-start" id="price">{{ $price }}</div>
    </h5>
    @if ($auction->type_id === '1')
        <h5 class="row">
            <div class="col-3">Quantity:</div>
            <div class="col-7">
              <input id="quantity"  type="number" name="quantity" placeholder="1" step="1" min="1">
              <h6>Left: {{ $quantity }}</h6>
            </div>
          </h5>
    @endif
</div>

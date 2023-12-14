<div>
    <form enctype="multipart/form-data" method="POST" action="{{ route('store-auction', ['type' => $type]) }}">
        @csrf
        <div class="form-group">
            <label for="title">Auction title*</label>
            <input type="text" name="title" wire:model="title" class="form-control @error('title') is-invalid @enderror" required>
        </div>
        <div class="form-group pt-4">
            <label for="description">Auction description* </label>
            <textarea wire:model="description" name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
        </div>
        <div class="form-group pt-4">
            <div class="col-md-2">
            <label for="category">Category*</label>
            <select class="form-control"
                    wire:model="category"
                    name="category"
                    required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" selected> {{$category->category}} </option>
                    @endforeach
            </select>
            </div>
        </div>

        @if ($type === '2')
        <div class="form-group pt-4">
            <label for="buy_now_price">Buy now price:</label><br>

            <input id="buy_now_price"
            type="number"
            name="buy_now_price"
            wire:model="buy_now_price"
            placeholder="1.0" step="0.01" min="0.1">
        </div>
        <div class="form-group pt-4">
            <label for="price">Starting price:</label><br>

            <input id="price"
                type="number"
                name="price"
                wire:model="price"
                placeholder="1.0" step="0.01" min="0.1" class="@error('price') is-invalid @enderror" required>
        </div>
        <div class="form-group pt-4">
            <label for="reserve_price">Reserve price:</label><br>

            <input id="reserve_price"
            type="number"
            name="reserve_price"
            wire:model="reserve_price"
            placeholder="1.0" step="0.01" min="0.1">
        </div>
        @endif

        <div class="form-group pt-4">
            <div class="col-md-2">
                <label for="is_active">Status</label>
                <select class="form-control" name="is_active" wire:model="is_active">
                    <option value="0" selected>Inactive</option>
                    <option value="1">Active</option>
                </select>
            </div>
        </div>

        @if ($type === '2')
            <div class="form-group pt-4">
                <label for="end_time">End date and time*: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
                <input wire:model="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" required>
            </div>
        @endif

        <div class="pt-2">
            <div class="card">
                <div class="card-body">
                    @foreach ($items as $index => $item)
                        <hr>
                        <div class="form-group">
                            <label for="item_title">Item title*</label>
                            <input type="text"
                                    name="items[{{$index}}][item_title]"
                                    class="form-control"
                                    wire:model="items.{{$index}}.item_title" />
                        </div>
                        <div class="form-group pt-4">
                            <input type="file"
                                    name="items[{{$index}}][image]"
                                    placeholder="Choose image"
                                    id="image"
                                    wire:model="items.{{$index}}.image" />
                        </div>
                        <div class="form-group pt-4">
                            <div class="col-md-2">
                                <label>Condition*</label>
                                <select class="form-control"
                                        name="items[{{$index}}][condition]"
                                        wire:model="items.{{$index}}.condition"
                                        required>
                                        @foreach($conditions as $condition)
                                            <option value="{{ $condition->id }}" selected>
                                                {{$condition->condition}}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        @if ($type === '1')
                        <div class="form-group pt-4">
                            <label for="price">
                                    Price*:
                            </label><br>
                        </div>
                        <input id="price"
                                type="number"
                                name="items[{{$index}}][price]"
                                wire:model="items.{{$index}}.price"
                                placeholder="1.0" step="0.01" min="0.1" class="@error('price') is-invalid @enderror" required>

                            <div class="form-group pt-4">
                                <label for="quantity">Quantity*:</label><br>
                                <input id="quantity"
                                        type="number"
                                        name="items[{{$index}}][quantity]"
                                        wire:model="items.{{$index}}.quantity"
                                        placeholder="1" step="1" min="1" class="@error('quantity') is-invalid @enderror" required>
                            </div>
                        @endif
                        @if ($index > 0)
                        <div class="form-group pt-4">
                            <button class="btn btn-sm btn-danger"
                                wire:click.prevent="removeItem({{$index}})">- Remove Item</button>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-secondary"
                            wire:click.prevent="addItem">+ Add Item</button>
                    </div>
                </div>
            </div>
        </div>
        @include('components.sessionmessage')
        <div class="pt-4">
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>
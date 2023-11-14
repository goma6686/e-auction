<div>
    <form enctype="multipart/form-data" method="POST" action="{{ route('store-auction') }}">
        @csrf
        <div class="form-group">
            <label for="title">Auction title*</label>
            <input type="text" name="title" wire:model="title" class="form-control @error('title') is-invalid @enderror" required>
        </div>
        <div class="form-group pt-4">
            <label for="description">Auction description*</label>
            <textarea wire:model="description" name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
        </div>
        <div class="form-group pt-4">
            <label for="end_time">Enter auction end date and time*: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
            <input wire:model="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" required>
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
        <div class="form-check pt-4">
            <label for="is_active">Active?</label>
            <input class="form-check-input" type="checkbox" value="0" name="is_active" wire:model="is_active">
        </div>

        <div class="card">
            <div class="card-body">
                @foreach ($items as $index => $item)
                    <hr>
                    <div class="form-group">
                        <label for="item_title">Item title</label>
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
                    <div class="form-group pt-4">
                        <label for="price">Price*:</label><br>
                        <input id="price"
                                type="number"
                                name="items[{{$index}}][price]"
                                wire:model="items.{{$index}}.price"
                                placeholder="1.0" step="0.01" min="0.1" class="@error('price') is-invalid @enderror" required>
                    </div>
                    <div class="form-group pt-4">
                        <button class="btn btn-sm btn-danger"
                            wire:click.prevent="removeItem({{$index}})">- Remove Item</button>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-secondary"
                        wire:click.prevent="addItem">+ Add Item</button>
                </div>
            </div>
        </div>
        
        @error('title', 'price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="pt-4">
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>
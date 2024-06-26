@extends('layouts.form')

@section('content')
<div id="editing" class="p-5">
    <h1 class="latest text-center mb-2 mb-5">Editing: {{ $auction_item->title }}</h1>
        @if (isset($auction_item->image))
            <label for="image">Current image:</label><br>
            <img src="/images/items/{{ $auction_item->image }}" class="img-fluid" alt="{{ $auction_item->title }}" width="200">
            <form action="/delete-image/{{ $auction_item->uuid }}" method="POST">
                @csrf
                @method('delete')
                <button class="btn btn-sm btn-outline-danger"> Delete image
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </button>
            </form>
        @else
            <label for="image">No image uploaded</label><br>
            <form enctype="multipart/form-data" method="POST" action="/upload-image/{{ $auction_item->uuid }}">
                @csrf
                <div class="form-group py-2">
                    <input type="file" name="image" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @endif

        <form enctype="multipart/form-data" method="POST" action="{{ route('update-item', ['uuid' => $auction_item->uuid, 'route' => $route]) }}">
            @csrf
            <div class="form-group pt-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $auction_item->title }}" required>
            </div>
            @if ($auction_type->type_id === '1')
                <div class="form-group pt-4">
                    <label for="quantity">Quantity:</label><br>
                    <input id="quantity" type="number" name="quantity" step="1" min="1" class="@error('quantity') is-invalid @enderror" value="{{ $auction_item->quantity }}">
                </div>
                @if (($auction_item->canLowerPrice() && !Auth::user()->is_admin) || Auth::user()->is_admin)
                <div class="form-group pt-4">
                    <label for="price">Price:</label><br>
                    <input id="price" type="number" name="price" placeholder="1.0" step="0.01" min="0.1" class="@error('price') is-invalid @enderror" value="{{ $auction_item->price }}">
                </div>
                @endif
            @endif
            <div class="form-group py-4">
                <div class="col-md-2">
                <label for="condition">Condition</label>
                <select class="form-control" name="condition" type="condition" required>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}"  @if ($auction_item->condition_id == $condition->id) selected @endif> {{$condition->condition}} </option>
                        @endforeach
                </select>
                </div>
            </div>
            @include('components.sessionmessage')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

</div>
@endsection
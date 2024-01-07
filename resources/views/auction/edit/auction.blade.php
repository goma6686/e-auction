@extends('layouts.form')

@section('content')
<div id="editing" class="py-12">
    <h1 class="latest text-center mb-2">Editing: {{ $auction->title }}</h1>
        <form enctype="multipart/form-data" method="POST" action="{{ route('update-auction', ['uuid' => $auction->uuid, 'route' => $route]) }}">
            @csrf
            <div class="form-group pt-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $auction->title }}" required>
            </div>
            <div class="form-group pt-4">
                <label for="description">Description{{$auction->type_id}}</label>
                <textarea name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror">{{ $auction->description }}</textarea>
            </div>

            @if ($auction->type_id === '2')
                @if (Auth::user()->is_admin)
                    <div class="form-group pt-4">
                        <label for="buy_now_price">Buy Now Price:</label><br>
                        <input id="buy_now_price" type="number" name="buy_now_price" placeholder="1.0" step="0.01" class="@error('buy_now_price') is-invalid @enderror" value="{{ $auction->buy_now_price }}">
                    </div>
                @endif
                @if (($auction->canLowerPrice() && !Auth::user()->is_admin) || Auth::user()->is_admin)
                    <div class="form-group pt-4">
                        <label for="price">Price:</label><br>
                        <input id="price" type="number" name="price" step="0.01" max="{{$auction->price}}" class="@error('price') is-invalid @enderror" value="{{ $auction->price }}">
                    </div>
                @endif
                <div class="form-group pt-4">
                    <label for="reserve_price">Reserve Price:
                    </label><br>
                    <input id="reserve_price" type="number" name="reserve_price" placeholder="1.0" step="0.01" @if(!Auth::user()->is_admin) min="{{$auction->price+5}}" max="{{$auction->reserve_price}}" @endif class="@error('reserve_price') is-invalid @enderror" value="{{ $auction->reserve_price }}">
                </div>
                @auth
                    @if ($auction->canExtendTime() && !Auth::user()->is_admin)
                        <div class="form-group pt-4">
                            <label for="end_time">Enter auction end date and time: (after {{ $auction->end_time }})</label><br>
                            <input id="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" value="{{ $auction->end_time }}" required>
                        </div>
                    @endif
                
                    @if (Auth::user()->is_admin)
                        <div class="form-group pt-4">
                            <label for="end_time">Enter auction end date and time: (after {{ $auction->end_time }})</label><br>
                            <input id="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" value="{{ $auction->end_time }}" required>
                        </div>
                        <div class="form-group pt-4">
                            <label for="created_at">Enter auction created at: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
                            <input id="created_at" type="datetime-local" name="created_at" class=" @error('created_at') is-invalid @enderror" value="{{ $auction->created_at }}" required>
                        </div>
                    @endif
                @endauth
            @endif

            <div class="form-group pt-4">
                <div class="col-md-2">
                <label for="category">Category</label>
                <select class="form-control" name="category" type="category" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"  @if ($auction->category_id == $category->id) selected @endif> {{$category->category}} </option>
                        @endforeach
                </select>
                </div>
            </div>
            @if (Auth::user()->is_admin)
                <div class="form-check pt-4">
                    <label for="is_active">Active?</label>
                    <input class="form-check-input" type="checkbox"  @if ($auction->is_active == 1) @checked(true) @endif value="{{$auction->is_active}}" name="is_active">
                </div>
                <div class="form-check pt-4">
                    <label for="is_blocked">Blocked?</label>
                    <input class="form-check-input" type="checkbox"  @if ($auction->is_blocked == 1) @checked(true) @endif value="{{$auction->is_blocked}}" name="is_blocked">
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>
<script type="text/javascript">
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "\Carbon\Carbon::now()->toDateString()",
    }

    flatpickr("input[type=datetime-local]", config);
</script>
@endsection
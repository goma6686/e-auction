@extends('layouts.main')

@section('content')
<div class="py-12">
    <h1 class="latest text-center mb-2">Create Auction Post</h1>
    <div class="max-w-7xl sm:px-6 lg:px-8 p-5">
        <form enctype="multipart/form-data" method="POST" action="{{ route('store-item') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
            </div>
            <div class="form-group pt-4">
                <input type="file" name="image" placeholder="Choose image" id="image">
            </div>
            <div class="form-group pt-4">
                <label for="description">Description</label>
                <textarea id="description" name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
            </div>
            <div class="form-group pt-4">
                <label for="price">Price:</label><br>
                <input id="price" type="number" name="price" placeholder="1.0" step="0.01" min="0.1" class="@error('price') is-invalid @enderror">
            </div>
            <div class="form-group pt-4">
                <label for="end_time">Enter auction end date and time: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
                <input id="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" required>
            </div>
            <div class="form-group pt-4">
                <div class="col-md-2">
                <label for="condition">Category</label>
                <select class="form-control" name="category" type="category" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" selected > {{$category->category}} </option>
                        @endforeach
                </select>
                </div>
            </div>
            <div class="form-group pt-4">
                <div class="col-md-2">
                <label for="condition">Condition</label>
                <select class="form-control" name="condition" type="condition" required>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" selected > {{$condition->condition}} </option>
                        @endforeach
                </select>
                </div>
            </div>
            <div class="form-check pt-4">
                <label for="is_active">Active?</label>
                <input class="form-check-input" type="checkbox" value="0" name="is_active">
            </div>
            @error('title', 'description', 'price', 'end_time')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
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
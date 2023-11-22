@extends('layouts.main')

@section('content')
<div class="py-12">
    <h1 class="latest text-center mb-2">Editing: {{ $auction->title }}</h1>
    <div class="max-w-7xl sm:px-6 lg:px-8 p-5">
        <form enctype="multipart/form-data" method="POST" action="{{ route('update-auction', array($auction->uuid)) }}">
            @csrf
            <div class="form-group pt-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $auction->title }}" required>
            </div>
            <div class="form-group pt-4">
                <label for="description">Description</label>
                <textarea name="description" type="text" rows="5" class="form-control @error('description') is-invalid @enderror">{{ $auction->description }}</textarea>
            </div>

            @if ($auction->type_id === '2')
                <div class="form-group pt-4">
                    <label for="start_time">Enter auction end date and time: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
                    <input id="start_time" type="datetime-local" name="start_time" class=" @error('start_time') is-invalid @enderror" value="{{ $auction->start_time }}" required>
                </div>
                
                <div class="form-group pt-4">
                    <label for="end_time">Enter auction end date and time: (after {{ \Carbon\Carbon::now()->toDateString() }})</label><br>
                    <input id="end_time" type="datetime-local" name="end_time" class=" @error('end_time') is-invalid @enderror" value="{{ $auction->end_time }}" required>
                </div>
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
            <div class="form-check pt-4">
                <label for="is_active">Active?</label>
                <input class="form-check-input" type="checkbox"  @if ($auction->is_active == 1) @checked(true) @endif value="{{$auction->is_active}}" name="is_active">
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
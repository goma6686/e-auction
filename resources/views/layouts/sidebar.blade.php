<nav class="nav flex-column">
    <a class="nav-link active" aria-current="page" href="{{ route('items.categories', ['category' => 'all']) }}">ALL</a>
    @foreach ($categories as $category)
        <a class="nav-link" href="{{ route('items.categories', ['category' => $category->category]) }}">{{$category->category}}</a>
    @endforeach
</nav>
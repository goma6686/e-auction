<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link @if($category === 'all') active @endif"
        href="{{ route('items.categories', ['category' => 'all']) }}">ALL</a>
    </li>
    @foreach ($categories as $categ)
        <li class="nav-item">
            <a class="nav-link @if ($categ->category === $category ?? '') active @endif" href="{{ route('items.categories', ['category' => $categ->category]) }}">{{$categ->category}}</a>
        </li>
    @endforeach
</ul>
<div id="home">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">All</a>
        </li>
        @foreach ($categories as $category)
        <li class="nav-item">
            <a class="nav-link" href="#">{{$category->category}}</a>
        </li>
        @endforeach
      </ul>
</div>
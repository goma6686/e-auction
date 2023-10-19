<div id="home" class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">All</button>
    @foreach ($categories as $category)
    <button class="nav-link" id="{{$category->category}}-tab" data-bs-toggle="pill" data-bs-target="#{{$category->category}}" type="button" role="tab" aria-controls="{{$category->category}}" aria-selected="false">{{$category->category}}</button>
    @endforeach
</div>
<!-- resources/views/components/categorycard.blade.php -->
<div class="card position-relative" id="category-card">
    <img src="{{ asset('images/categories/'. $c->categoryImage) }}" class="card-img-top img-responsive img-fluid" alt="{{$c->category}}">
    <div class="card-body text-center">
        <h5 class="card-title">{{$c->category}}</h5>
        <a href="{{ route('home', ['category' => $category->category]) }}" class="stretched-link"></a>
    </div>
</div>
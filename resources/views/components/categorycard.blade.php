<!-- resources/views/components/categorycard.blade.php -->
<div class="card" id="category-card">
    <img src="{{ asset('images/categories/'. $c->categoryImage) }}" class="card-img-top img-responsive" alt="...">
    <div class="card-body text-center">
        <h5 class="card-title">{{$c->category}}</h5>
    </div>
</div>
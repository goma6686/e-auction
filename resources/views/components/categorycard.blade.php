<!-- resources/views/components/categorycard.blade.php -->
<div class="card" id="category-card">
    <img src="{{ asset('images/categories/'. $category->image) }}" class="card-img-top" alt="...">
    <div class="card-body text-center">
        <h5 class="card-title">{{$category->category}}</h5>
    </div>
</div>
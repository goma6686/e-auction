<!-- resources/views/components/categorycard.blade.php -->
<div class="card m-3" id="category-card">
    <img src="{{ asset('images/categories/'. $item->image) }}" class="card-img-top img-responsive" alt="...">
    <div class="card-body text-center">
        <h5 class="card-title">{{$item->category}}</h5>
    </div>
</div>
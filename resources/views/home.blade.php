@extends('layouts.main')

  @section('content')
  <div class="d-flex align-items-start">
    @section('sidebar')
      @include('layouts.sidebar')
    @endsection
    <div class="tab-content d-flex flex-grow-1" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="row">
            @foreach ($all_items as $item)
            <div class="col-6">
                @include('components.itemcard')
            </div>
            @endforeach
        </div>
      </div>

      @foreach ($categories as $category)
        <div class="tab-pane fade" id="{{$category->category}}" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <div class="row">
              @foreach ($all_items as $item)
                <div class="col-4">
                    @if ($item->category == $category->category)
                      @include('components.itemcard')
                      
                    @endif
                </div>
              @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
  {!! $all_items->links() !!}
  @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
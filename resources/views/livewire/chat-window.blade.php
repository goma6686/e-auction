<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card-body" x-ref="chatBox">
        @foreach ($messages as $message)
          <div><span class="text-blue-400">You:</span> {{ $message }}</div>
        @endforeach
        <div><span class="text-blue-400">{{$receiver_username}}:</span> {{ $gavo }}</div>
      </div>
</div>

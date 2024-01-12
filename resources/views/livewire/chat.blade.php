<div>
  <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <p class="mb-0 fw-bold">{{$receiver_username}}</p>
  </div>
  {{--@livewire('chat-window')--}}
  <div class="card-body" x-ref="chatBox">
    @foreach ($messages as $message)
      <div><span class="text-blue-400">You:</span> {{ $message }}</div>
    @endforeach
    <div><span class="text-blue-400">{{$receiver_username}}:</span> {{ $gavo }}</div>
  </div>
  <div class="card-footer">
    {{--@livewire('send-message')--}}
    <div class="form-outline">
      <form wire:submit="sendMessage">
        <textarea type="text"
        wire:model="message"
        x-ref="messageInput" 
        type="text"
        name="message"
        id="textArea" 
        rows="2" class="form-control">
      </textarea> 
        <button type="submit" class=" btn btn-dark">
          Send
        </button>
        </form>
    </div>
  </div>
</div>


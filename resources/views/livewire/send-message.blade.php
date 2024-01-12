<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
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

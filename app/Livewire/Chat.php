<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\MessageSent;
use Livewire\Attributes\On;
use App\Models\Auction;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Chat extends Component
{
    public $auction;

    public array $messages = [];

    public string $message = '';
    public $user;
    public $receiver_username;
    public $receiver;
    public $gavo;

    public function mount(Auction $auction, $receiver){
       $this->auction = $auction;
       $this->user = Auth::user();
       $this->receiver = $receiver;
       $this->receiver_username = User::findOrFail($receiver)->username;
    }

    #[On('message-sent.{receiver}')]
    public function messageSent(){
        $this->updated();
        //$this->messages[] =$this->message;
    }

    public function sendMessage(){
        //$message = $request->input('data');
        //$auction = $this->auction;

        $message = Conversation::create([
            'message' => $this->message,
            'user_uuid' => auth()->user()->uuid,
        ]);
        $this->messages[] = $message;
        $message->refresh();
       // $this->messages[] = $this->message;
        //broadcast (new MessageSent::dispatch($this->message, $this->user->uuid ,$this->receiver))->toOthers();
        MessageSent::dispatch($message, $this->receiver);
        $this->reset('message');
        return response()->json(['message' => $message]);
    }

    public function updated(){
        $this->messages[] =$this->message;
        $this->gavo = $this->message;
    }


    public function render()
    {
        return view('livewire.chat');
    }

    public function getListeners()
    {
        return [
            "echo-private:message-sent.{$this->user->uuid},MessageSent" => 'messageSent',
        ];
    }
}

<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('a0706e146a7f37674961', {
      cluster: 'eu'
    });
    var channel = pusher.subscribe('message-sent.{{{$user->uuid}}}');
    /*channel.bind('client-message.sent', function(data){
      console.log(data);
    });*/
</script>
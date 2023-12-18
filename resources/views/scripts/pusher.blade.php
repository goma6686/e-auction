<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a0706e146a7f37674961', {
      cluster: 'eu'
    });
    var channel = pusher.subscribe('auctions.{{{$auction->uuid}}}');
</script>
<script >
    // Update the count down every 1 second
    var countDownDate =  new Date($(".time-countdown").data('expire')).getTime();
    var now = new Date().getTime();
    var distance = countDownDate - now;

    setInterval(function() {
    
       // Get today's date and time
       var now = new Date().getTime();

       // Find the distance between now and the count down date
       var distance = countDownDate - now;

       // Output the result in an element with id="timer"
       var timer = document.getElementById("timer") ?? 0;

       if (distance < 0) {
         timer.innerHTML = 0 + "h " + 0 + "m " + 0 + "s ";
         clearInterval();
         location.reload();
       } else {
            // Time calculations
         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
         var seconds = Math.floor((distance % (1000 * 60)) / 1000);
         
         timer.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
       }
    }, 1000); //1000 = 1 sec    
</script>
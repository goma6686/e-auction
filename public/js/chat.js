$(document).ready(function () {

    $('.sendMessageBtn').on('click', function (e) {
        e.preventDefault();

        var message = $("#textArea").val();

        $.ajax({
            url: '/sendmessage',
            //url: '{{route("sendMessage")}}',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { data: message },
            /*contentType: false,
            processData: false,*/
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('cia tai response: ', response.message);
            },
            error: function(error) {
              console.log('Error:', error);
            }
        });
    });
});
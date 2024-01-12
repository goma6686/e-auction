
    $(document).ready(function () {
        $('.toggleFavourite').on('click', function (e) {
            e.preventDefault();

            var data = $(this).attr('data-item');

            if($(this).hasClass('icon-not-active')) {
                var method = 'POST';
            } else if($(this).hasClass('icon-active')) {
                var method = 'DELETE';
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/favourite',
                type: method,
                data: { data: $(this).attr('data-item') },
                success: function (response) {
                    console.log(response.data);
                    $("button[data-item='" + data + "']").toggleClass("icon-active icon-not-active")
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.remove-from-watchlist').on('click', function (e) {
            e.preventDefault();

            const data = $(this).attr('data-item');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/favourite',
                type: 'DELETE',
                data: { data: $(this).attr('data-item') },
                success: function (response) {
                    console.log(response.data);
                    $("#addfavourites" + data).show();
                    $("#deletefavourite" + data).hide();
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });
    });
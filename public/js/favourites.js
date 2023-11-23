$(document).on('click', '.toggleAuctioninFavourite', function (e) {

    e.preventDefault();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let auctionUuid = $(this).attr('data-auction-Uuid');

    $.ajax({
        type: 'GET',
        url: "/favourite/" + $(this).attr('data-auction-Uuid'),
        data: {
            'auctionUuid': $(this).attr('data-auction-Uuid'),
        },
        success: function (data) {
            $("div[data-auction-icon-id=" + auctionUuid + "]").toggleClass("favouriteNotActive favouriteActive");
            $("a[data-auction-Uuid=" + auctionUuid + "]").toggleClass("favouriteNotActive favouriteActive");
            /*if ((data.wished) && (data.status)) {
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }*/
        },
        error: function (jqXHR) {
            toastr.warning(jqXHR.responseJSON.message);
        }

    });
});

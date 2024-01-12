@component('mail::message', ['auction_title' => $auction_title, 'username' => $username, 'auction_title' => $auction_title])
# Hi {{$username}}!

Your offer for product **{{$auction_title}}** has been outbid!

@component('mail::button', ['url' => $url])
View Product
@endcomponent

@endcomponent
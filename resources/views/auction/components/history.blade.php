
<div class="table-responsive overflow-visible">
    <table class="table accordion accordion-flush table-light table-less">
        <thead>
            <tr>
              <th scope="col" class="col "></th>
              <th scope="col" class="col">Seller</th>
              <th scope="col"  class="col-6">Product details</th>
              <th scope="col" class="col-6">Items</th>
              <th scope="col" class="col ">Total</th>
              <th scope="col" class="col "></th>
              <th scope="col" class="col "></th>
            </tr>
        </thead>
        <tbody >
            @foreach ($unpaid_auctions as $index => $auction)
                <tr class="align-middle ">
                    <td >
                        {{$index+1}}
                    </td>
                    <td class=" border border">
                        <a href="/profile/{{$auction->getAuctionSeller()->uuid}}" class="link-dark">
                            <p>
                            {{$auction->getAuctionSeller()->username}}
                            {{$auction->getAuctionSeller()->email}}
                            </p>
                        </a>
                     </td>
                    <td>
                        <dl>
                            <dt>Auction:</dt>
                            <dd><h5>
                                {{$auction->title}}
                            </h5></dd>
                            <dt>Category:</dt>
                            <dd>{{$auction->category->category}}</dd>
                            <dt>Price:</dt>
                            <dd>{{$auction->price}}</dd>
                        </dl>
                    </td>
                    <td>
                        <ul class="btn-group-vertical list-group" role="group" >
                            @foreach ($auction->items as $index => $item)
                                <button class="btn text-start dropdown-toggle" type="button"   id="dropdownMenuButton{{$index}}" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$item->title}} [{{$item->condition->condition}}]
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$index}}">
                                    <li class="dropdown-item">
                                    <img class="img-responsive rounded d-block " id="list-image"  @if (isset($auction['items'][$index]['image'])) src="/images/items/{{ $auction['items'][$index]['image'] }}" @else src="/images/noimage.jpg" @endif>
                                    </li>
                                </ul>
                            @endforeach
                        </ul>
                    </td>
                    <td >
                        {{$auction->price}}
                    </td>
                    <td  class=" text-end ">
                        <a href="#" class="btn btn-dark" onclick="return confirm('Do you want to this anyway?')">Message</a>
                    </td>
                    <td  class=" text-end ">
                        <a href="#" class="btn btn-dark" onclick="return confirm('Do you want to this anyway?')">PAY</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
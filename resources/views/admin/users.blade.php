<thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Is Active</th>
        <th>Is Admin</th>
        <th>Balance</th>
        <th>Auctions count</th>
        <th>Active bids</th>
        <th>Won auctions</th>
        <th></th>
        <th></th>
    </tr>
</thead>
<tbody>
@foreach ($data as $user)
    <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->email}}</td>
        <td>
            @if ($user->is_active == 1) 
                @include('components.yes')
            @else 
                @include('components.no')
            @endif
        </td>
        <td>
            @if ($user->is_admin == 1) 
                @include('components.yes')
            @else 
                @include('components.no')
            @endif
        </td>
        <td>{{$user->balance}}</td>
        <td>{{$user->auctions->count()}}</td>
        <td>{{count($user->getActiveBids())}}</td>
        <td>{{count($user->getWonAuctions())}}</td>
        <td>    
            <a href="{{ route('profile', ['uuid' => $user->uuid]) }}"  class="btn btn-sm btn-dark " role="button">Profile</a>
        </td>
        <td>
            @if ($user->is_active)
                <a href="{{ route('admin.deactivate', ['uuid' => $user->uuid]) }}"  class="btn btn-sm btn-danger " role="button">Deactivate</a>
            @else
                <a href="{{ route('admin.activate', ['uuid' => $user->uuid]) }}"  class="btn btn-sm btn-success " role="button">Activate</a>
            @endif
        </td>
    </tr>
@endforeach
</tbody>
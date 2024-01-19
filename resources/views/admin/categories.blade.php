<thead  class="table-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($data as $index => $category)
    @if ($loop->first) @continue @endif
        <tr scope="row">
            <th>{{$index}}</th>
            <td>
                {{$category->category}}
            </td>
            <td>
                <form action="/back/category/delete/{{$category->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    <tr scope="row">
        <th>#</th>
            <form enctype="multipart/form-data" method="POST" action="/back/category/store">
                <td>
                    <input type="text" name="category" class="form-control" required="">
                </td>
                <td>
                    @csrf
                <button type="submit" class="btn btn-sm btn-dark">Add</button>
            </form>
        </td>
    </tr>
</tbody>
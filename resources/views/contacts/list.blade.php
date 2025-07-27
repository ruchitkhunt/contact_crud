<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Custom Fields</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->gender }}</td>
            <td>{{ $c->phone }}</td>
            <td>
                @foreach($c->customValues as $cv)
                {{ $cv->value }}<br>
                @endforeach

            </td>
            <td>
                <button class="btn btn-sm btn-info editBtn" data-id="{{$c->id}}">Edit</button>
                <button class="btn btn-sm btn-danger delBtn" data-id="{{$c->id}}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

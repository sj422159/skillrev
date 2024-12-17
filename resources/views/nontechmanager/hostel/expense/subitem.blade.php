@extends($layout)
@section('title','Items')
@section('container')
<div class="container">
    <h2>Expense Items</h2>

    <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('item.create') }}" class="btn btn-primary mb-3">Add Expense Item</a>  <!-- Add button for adding items -->
    </div>
    @if($items->isEmpty())
        <div class="alert alert-info">No expense items found.</div>
    @else
        <table class="table table-bordered">
            <thead style="background-color: black; color: white;">  <!-- Black background with white text -->
                <tr>
                    <th>ID</th>
                    <th>Group</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Item Name</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->Group }}</td>
                        <td>{{ $item->Category }}</td>
                        <td>{{ $item->subcategory }}</td>
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            <a href="{{ route('item.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('item.delete', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

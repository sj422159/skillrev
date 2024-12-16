@extends('nontechmanager/hostel/layout')

@section('container')
<div class="container">
    <h2>Expense Items</h2>
    <a href="{{ route('subcategory.index') }}" class="btn btn-secondary mb-3">Back to Subcategories</a>

    @if($items->isEmpty())
        <div class="alert alert-info">No expense items found.</div>
    @else
        <table class="table table-bordered">
            <thead>
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
                        <td>{{ $item->groupid }}</td>
                        <td>{{ $item->categoryid }}</td>
                        <td>{{ $item->subcategory }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->amount }}</td>
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

@extends($layout)

@section('container')
<div class="container">
    <h1>Raised Expenses</h1>
    <a href="{{ route('nontech.manager.raise.raise_expense') }}" class="btn btn-primary">Raise New Expense</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Group</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Actions</th> <!-- Added column for actions -->
            </tr>
        </thead>
        <tbody>
            @foreach($raisedExpenses as $expense)
            <tr>
                <td>{{ $expense->group->Group ?? 'N/A' }}</td>
                <td>{{ $expense->category->Category ?? 'N/A' }}</td>
                <td>{{ $expense->subcategory->subcategory ?? 'N/A' }}</td>
                <td>
                    @if($expense->itemid)
                        @php
                            // Check if itemid is a CSV string, then convert it to an array
                            $itemIds = is_array($expense->itemid) ? $expense->itemid : explode(',', $expense->itemid);
                            // Get the item names based on item ids
                            $items = \App\Models\ExpenseItem::whereIn('id', $itemIds)->pluck('item')->toArray();
                        @endphp
                        {{ implode(', ', $items) }}  <!-- Join the items with a comma -->
                    @else
                        {{ 'N/A' }}
                    @endif
                </td>
                <td>{{ $expense->quantity }}</td>

                <!-- Actions Column -->
                <td>
                    <a href="{{ route('nontech.manager.raise.editraise_expense', ['id' => $expense->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('nontech.manager.raise.delete_expense', $expense->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

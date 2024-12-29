@extends('controller.account.Alayout')

@section('container')
<div class="container">
    <h2>Expenses {{ ucfirst($type) }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Group</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Item</th>
                <th>Quantity</th>
                @if($type === 'validate')
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                <td>{{ $expense->group->Group }}</td>
                <td>{{ $expense->category->Category }}</td>
                <td>{{ $expense->subcategory->subcategory }}</td>
                <td>{{ $expense->item->item }}</td>
                <td>{{ $expense->quantity }}</td>
                @if($type === 'validate')
                <td>
                    <form action="{{ route('expenses.approveAction') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                    </form>
                    <form action="{{ route('expenses.rejectAction') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="6">No expenses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection

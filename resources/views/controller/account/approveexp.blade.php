@extends('controller.account.Alayout')

@section('container')
<div class="container">
    <h2>Expenses {{ ucfirst($type) }}</h2>
    <form method="GET" class="mb-4" id="filter-form">
        <div class="row">
            <div class="col-md-4">
                <select name="groupid" class="form-control" onchange="this.form.submit()">
                    <option value="">Select Group</option>
                    @foreach($groups as $id => $group)
                        <option value="{{ $id }}" {{ request('groupid') == $id ? 'selected' : '' }}>
                            {{ $group }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="categoryid" class="form-control" onchange="this.form.submit()">
                    <option value="">Select Category</option>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ request('categoryid') == $id ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="subcatid" class="form-control" onchange="this.form.submit()">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $id => $subcategory)
                        <option value="{{ $id }}" {{ request('subcatid') == $id ? 'selected' : '' }}>
                            {{ $subcategory }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Group</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Item</th>
                <th>Quantity</th>
                @if($type === 'validate' || $type === 'approve')
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
            <tr>
                    <td>{{ $expense->group->Group ?? 'N/A' }}</td>
                    <td>{{ $expense->category->Category ?? 'N/A' }}</td>
                    <td>{{ $expense->subcategory->subcategory ?? 'N/A' }}</td>
                <td>
                    @php
                        $items = json_decode($expense->item_names, true);
                        echo $items['item'] ?? 'N/A'; // If 'item' exists in JSON, show it; otherwise, show 'N/A'
                    @endphp
                </td>
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
                @elseif($type === 'approve')
                <td>
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

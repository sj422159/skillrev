@extends('nontechmanager/account/layout')
@section('container')
<div class="container">
    <h2>Expenses for {{ ucfirst($module) }}</h2>

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
                <th>Items</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->group->Group ?? 'N/A' }}</td>
                    <td>{{ $item->category->Category ?? 'N/A' }}</td>
                    <td>{{ $item->subcategory->subcategory ?? 'N/A' }}</td>
                    <td>
                        @php
                            $itemIds = explode(',', $item->itemid);
                            $itemNames = \App\Models\ExpenseItem::whereIn('id', $itemIds)
                                ->pluck('item')
                                ->implode(', ');
                        @endphp
                        {{ $itemNames }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <form action="{{ route('expense.updateStatus', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($item->status == 0)
                                <button type="submit" name="status" value="1" class="btn btn-success btn-sm">Validate</button>
                                <button type="submit" name="status" value="-1" class="btn btn-danger btn-sm">Reject</button>
                            @elseif($item->status == 1)
                                <button type="submit" name="status" value="-1" class="btn btn-danger btn-sm">Reject</button>
                            @elseif($item->status == -1)
                                <button type="submit" name="status" value="1" class="btn btn-success btn-sm">Validate</button>
                            @else
                                <span class="text-success">Approved</span>
                            @endif
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
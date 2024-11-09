@extends('controller.Alayout')
@section('title', 'Create Expense')
@section('Dashboard_select', 'active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Expense</h3>
            </div>
            <form action="{{ route('expenses.storecat') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="controller_id" value="{{ $controller_id }}">
                    <div class="form-row">
                        <div class="col-12 col-sm-6 mt-3">
                            <label for="expense_group">Expense Group</label>
                            <select class="form-control" id="expense_group" name="expense_group" required>
                                <option value="">Select Group</option>
                                @foreach($expenseGroups as $group)
                                <option value="{{ $group->Group }}">{{ $group->Group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 mt-3">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="expense_category" name="expense_category"
                                placeholder="Add Category" required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('controller.account.Alayout')
@section('title', 'Create Expense')
@section('Dashboard_select', 'active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Expense</h3>
            </div>

            <!-- form start -->
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Hidden input for controller_id -->
                    <input type="hidden" name="controller_id" value="{{ $controller_id }}">

                    <div class="form-row">
                        <!-- Expense Group Dropdown -->
                        <div class="col-12 col-sm-6 mt-3">
                            <label for="expense_group">Expense Group</label>
                            <input type="text" class="form-control" id="expense_group" placeholder="Add Group"
                            name="expense_group" required>
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
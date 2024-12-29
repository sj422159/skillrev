@extends($layout)
@section('container')
<div class="container">
    <div class="header" style="background-color: blue; color: white; padding: 10px;">
        <h1 style="color: white;"">Raise Expense</h1>
    </div>
    <div class="box" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
        <form action="{{ isset($expense) ? route('nontech.manager.raise.update_expense', ['id' => $expense->id]) : route('nontech.manager.raise.store_expense') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Group -->
                <div class="form-group col-md-6">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-control">
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" 
                                @if (isset($expense) && $expense->groupid == $group->id) selected @endif>
                                {{ $group->Group }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category -->
                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}" 
                                @if (isset($expense) && $expense->categoryid == $id) selected @endif>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Subcategory -->
                <div class="form-group col-md-6">
                    <label for="subcategory">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="form-control">
                        @foreach ($subcategories as $id => $subcategory)
                            <option value="{{ $id }}" 
                                @if (isset($expense) && $expense->subcatid == $id) selected @endif>
                                {{ $subcategory }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Item -->
                <div class="form-group col-md-6">
                    <label for="item">Item</label>
                    <select name="item" id="item" class="form-control">
                        @foreach ($items as $id => $item)
                            <option value="{{ $id }}" 
                                @if (isset($expense) && $expense->itemid == $id) selected @endif>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Quantity Measure -->
                <div class="form-group col-md-6">
                    <label for="quantity_measure">Quantity Measure</label>
                    <select name="quantity_measure" id="quantity_measure" class="form-control">
                        @foreach ($quantity_measures as $measure)
                            <option value="{{ $measure }}" 
                                @if (isset($expense) && $expense->quantity == $measure) selected @endif>
                                {{ $measure }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" 
                        value="{{ isset($expense) ? explode('_', $expense->quantity)[0] : '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection

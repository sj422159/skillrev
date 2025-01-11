@extends($layout)
@section('title', 'Edit Expense')
@section('container')
<div class="container">
    <div class="header" style="background-color: blue; color: white; padding: 10px;">
        <h1 style="color: white;">Edit Expense</h1>
    </div>
    <div class="box" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
        <form action="{{ route('nontech.manager.raise.update_edit_expense', ['id' => $expense->id]) }}" method="POST">
            @csrf

            <!-- Group -->
            <div class="form-group">
                <label for="group">Group</label>
                <select name="group" id="group" class="form-control" required>
                    <option value="">Select Group</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}" {{ $expense->groupid == $group->id ? 'selected' : '' }}>
                            {{ $group->Group }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $id => $category)
                        <option value="{{ $id }}" {{ $expense->categoryid == $id ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Subcategory -->
            <div class="form-group">
                <label for="subcategory">Subcategory</label>
                <select name="subcategory" id="subcategory" class="form-control" required>
                    <option value="">Select Subcategory</option>
                    @foreach ($subcategories as $id => $subcategory)
                        <option value="{{ $id }}" {{ $expense->subcatid == $id ? 'selected' : '' }}>
                            {{ $subcategory }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Items -->
            <div class="form-group">
                <label for="item">Item</label>
                <select name="item" id="item" class="form-control" required>
                    <option value="">Select Item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, $expenseItems) ? 'selected' : '' }}>
                            {{ $item->item }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" 
                       value="{{ $quantity_value }}" required min="1">
            </div>

            <!-- Quantity Measure -->
            <div class="form-group">
                <label for="quantity_measure">Quantity Measure</label>
                <select name="quantity_measure" id="quantity_measure" class="form-control" required>
                    <option value="">Select Measure</option>
                    @foreach ($quantity_measures as $measure)
                        <option value="{{ $measure }}" {{ $quantity_measure == $measure ? 'selected' : '' }}>
                            {{ $measure }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Update Expense</button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Inputs for Aid and NonTechManagerId -->
<input type="hidden" id="aid" value="{{ $aid }}">
<input type="hidden" id="nontechmanagerid" value="{{$nontechmanagerid }}">

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchItems() {
            const groupid = $('#group').val();
            const categoryid = $('#category').val();
            const subcatid = $('#subcategory').val();
            const aid = $('#aid').val();
            const nontechmanagerid = $('#nontechmanagerid').val();

            console.log('fetchItems called with:', {
                groupid, categoryid, subcatid, aid, nontechmanagerid
            });

            if (groupid && categoryid && subcatid) {
                console.log('Making AJAX call...');
                
                $.ajax({
                    url: '{{ route('items.fetch') }}',
                    method: 'POST',
                    data: {
                        groupid: groupid,
                        categoryid: categoryid,
                        subcatid: subcatid,
                        aid: aid,
                        nontechmanagerid: nontechmanagerid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('AJAX success:', response);
                        $('#item').empty();
                        $('#item').append('<option value="">Select Item</option>');
                        if (response.length > 0) {
                            response.forEach(item => {
                                const selected = {{ json_encode($expenseItems) }}.includes(item.id) ? 'selected' : '';
                                $('#item').append(`<option value="${item.id}" ${selected}>${item.item}</option>`);
                            });
                        } else {
                            $('#item').append('<option value="">No items available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', {xhr, status, error});
                        alert('Failed to load items. Please try again.');
                    }
                });
            } else {
                console.log('Required fields not filled:', {
                    groupid, categoryid, subcatid
                });
                $('#item').empty();
                $('#item').append('<option value="">Select Item</option>');
            }
        }

        // Debug initial values
        console.log('Initial values:', {
            group: $('#group').val(),
            category: $('#category').val(),
            subcategory: $('#subcategory').val(),
            aid: $('#aid').val(),
            nontechmanagerid: $('#nontechmanagerid').val()
        });

        // Attach change handlers with debug
        $('#group').change(function() {
            console.log('Group changed:', $(this).val());
            fetchItems();
        });

        $('#category').change(function() {
            console.log('Category changed:', $(this).val());
            fetchItems();
        });

        $('#subcategory').change(function() {
            console.log('Subcategory changed:', $(this).val());
            fetchItems();
        });

        // Initial fetch if all values are present
        if ($('#group').val() && $('#category').val() && $('#subcategory').val()) {
            console.log('Running initial fetch...');
            fetchItems();
        }
    });
</script>
@endsection

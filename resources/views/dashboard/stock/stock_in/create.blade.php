@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('stockin.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Stock In Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Supplier Information</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="tab-content">
                                    {{-- Existing Supplier Form --}}
                                    <div class="tab-pane show active" id="Home-new2">
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">supplier Name</label>
                                                    <div class="multiselect_div">
                                                        <select id="supplier" class="multiselect multiselect-custom" name="supplier_id" required>
                                                            <option value="0">- Choose supplier -</option>
                                                            @foreach($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Contact No</label>
                                                    <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="supplier_addrse" class="control-label">Address</label>
                                                    <textarea class="form-control @error('supplier_addrse') is-invalid @enderror" id="supplier_addrse" name="supplier_addrse" disabled rows="6"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Product Details</h2>
                    </div>

                    {{-- Enter Product --}}
                    <div id="product-form" class="body">
                        <form action="#" id="product_details">
                            <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Product Category</label>
                                        <div class="multiselect_div">
                                            <select id="product_category" class="multiselect multiselect-custom" name="product_category" required>
                                                <option value="0">- Choose Product Category-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Product</label>
                                        <div class="multiselect_div">
                                            <select id="product_list" class="multiselect multiselect-custom" name="product_list" required>
                                                <option value="0">- Choose Product -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Qty</label>
                                        <input type="number" min="1" value="1" name="product_qty" id="product_qty" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Unit Price</label>
                                        <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="addnew_product">Add</button>
                                    </div>
                                </div>
                            </div> -->
                            <input type="button" id="addRow" class="form-control btn btn-primary" value="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Product List --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Products List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Category</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="products">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Invoice Details</h2>
                    </div>
                    <div id="product-form" class="body">
                        <!-- <form method="POST" action="{{ route('stockin.store') }}" id="frm" enctype="multipart/form-data"> -->
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Invoice No</label>
                                        <input type="number" name="invoice" id="invoice" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Total</label>
                                        <input type="number" step="0.01" name="total" id="total" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <button type="button" id="create" class="btn btn-primary" id="addnew_product">Add</button>
                                    </div>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script><!-- Multi Select Plugin Js -->
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $('#product_list').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#supplier').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
        $('#product_category').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        jQuery(document).ready(function ($){

            //get selected supplier details
            $('#supplier').on('change', function() {
                var supplier_id = $(this).val();

                if (supplier_id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/supplier/get/all/" + supplier_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (!response.error) {
                                $('#supplier_name').val(response.data.contact_person);
                                $('#supplier_phone').val(response.data.phone);
                                $('#supplier_addrse').val(response.data.address);
                            }
                        },
                        error: function (error) {
                            swal('Failed', 'Unable to get supplier information', 'danger');
                        }
                    });
                }
            });

            //get selected supplier products categories
            $('#supplier').on('change', function() {
                var supplier_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ config('app.url') }}/supplier/get/stock-product-category/all/" + supplier_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        $('#product_category').empty();

                        $('#product_category').append(
                            '<option value="0">- Choose Product Catecory -</option>'
                        )

                        $.each(response.data, function(key, value) {
                            console.log(value);
                            $('#product_category').append(
                                '<option value="' + value.stock_product_category.id + '">' + value.stock_product_category.name + '</option>'
                            )
                        });

                        $('#product_category').multiselect('rebuild');
                    }
                });
            });

            $('#product_category').on('change', function() {
                var product_category_id = $(this).val();
                var supplier_id = $('#supplier').val();

                if (product_category_id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/supplier/get/product/all/" + product_category_id +"/"+supplier_id,
                        data: { data1 : supplier_id },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#product_list').empty();

                            $('#product_list').append(
                                '<option value="0">- Choose Product -</option>'
                            )

                            $.each(response.data, function(key, value) {
                                console.log(value);
                                $('#product_list').append(
                                    '<option value="' + value.id + '">' + value.name + '</option>'
                                )
                            });

                            $('#product_list').multiselect('rebuild');
                        },
                    });
                }
            });

            var i = 0;
            var netValue = 0
            $("#addRow").click(function(){
                var category = $("#product_category option:selected").text();
                var qty = Number($("#product_qty").val());
                var product_name = $("#product_list option:selected").text();
                var product_id = $('#product_list').val();
                var product_price = Number($("#product_price").val());
                var total = 0;
                total = (qty*product_price);
                netValue = netValue + total;
                var actions = '<button class="btn btn-xs btn-danger del-btn" id="' + i + '"><i class="fa fa-trash"></i></button>';
                var rowData = "<tr><td>"+ i +"<input type='hidden' value='" + product_id + "' class='product_id'></td><td>"+ category + "</td><td>" + product_name +"</td><td>"+ qty +"</td><td>"+ product_price +"</td><td>"+ total +"</td><td>"+ actions +"</td></tr>";
                //net value and ordering value
                if (!qty || qty == undefined || qty == 0) {
                    alert("Please Enter Quantity");
                    return;
                } else if ( !product_price || product_price == undefined || product_price == 0 ) {
                    alert("Please Enter Unit Price");
                    return;
                } else {
                    $("#products").append(rowData);
                    $("#total").val(netValue);
                    $("#product_price").val("");
                    $("#product_qty").val("");
                }
                $("#"+ i).click(function(e) {
                    e.preventDefault();
                    netValue = netValue - Number($(this).closest('tr').find('td:eq(4)').text());
                    $("#total").val(netValue);
                    $(this).closest('tr').remove();
                    var counter = 0;
                    $('#products tr').each(function(row, tr) {
                        if (counter > 0) {
                            $(tr).find('td:eq(0)').text(counter);
                        }
                        counter += 1;
                    });
                    i = counter;
                });
                i++;
            });

            //form submit
            $("#create").on('click', function(e) {
                e.preventDefault();
                var TableData;
                TableData = storeTblValues();
                console.log(TableData);
                if(TableData.length == 0)
                {
                    alert('Please add at least one item', 'error');
                    return;
                }
                TableData = JSON.stringify(TableData);
                function storeTblValues()
                {
                    console.log("inside table");
                    var TableData = new Array();
                    $('#products tr').each(function(row, tr){
                        TableData[row]={
                            "product_category" : $(tr).find('td:eq(1)').text(),
                            "product_name" : $(tr).find('td:eq(2)').text(),
                            "product_qty" :$(tr).find('td:eq(3)').text(),
                            "product_price" :$(tr).find('td:eq(4)').text(),
                            "product_total" :$(tr).find('td:eq(5)').text(),
                            "product_id" :$(tr).find('.product_id').val(),
                        }
                    });
                    console.log(TableData);
                    console.log("after");
                    console.log(TableData);
                    return TableData;
                }
                var supplier = $("#supplier option:selected").val();
                var total = $("#total").val();
                var invoice = $("#invoice").val();
                $.ajax({
                    data: {
                        "supplier": supplier,
                        "total": total,
                        "invoice": invoice,
                        "TableData": TableData,
                        "_token": "{{csrf_token()}}"
                    },
                    url: "{{ config('app.url') }}/stockin/create",
                    type: "POST",
                    success: function(data) {
                        if (!data.error) {
                            alert("Successefully Store !");
                            location.reload();
                        } else {
                            alert("Failed to made store !");
                        }
                    },
                    error: function(error) {
                        alert('Cannot proceed at this time');
                    }
                });
            });
        });
    </script>
@endsection

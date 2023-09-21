@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('invoice.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Invoice Management',
        ]])

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>New Invoice</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <form action="#" method="POST" id="invoice_details">
                                @csrf
                                <div class="form-group">
                                    <label for="phone" class="control-label">Client</label>
                                    <div class="multiselect_div">
                                        <select id="client" class="multiselect multiselect-custom" name="client" required>
                                            <option value="0">- Choose Client -</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }} ( {{ $client->contact_person }} | {{ $client->phone }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Product Category</label>
                                    <div class="multiselect_div">
                                        <select id="product_category" class="multiselect multiselect-custom" name="product_category" required>
                                            <option value="0">- Choose Category -</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Product</label>
                                    <div class="multiselect_div">
                                        <select id="product_list" class="multiselect multiselect-custom" name="product_list" required>
                                            <option value="0">- Choose Product -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Description</label>
                                    <input name="description" id="description" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Available Qty</label>
                                    <input name="available_qty" id="available_qty" class="form-control" disabled required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Rate</label>
                                    <input type="number" min="0.01" name="product_rate" id="product_rate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Qty</label>
                                    <input type="number" min="1" name="product_qty" id="product_qty" class="form-control" required>
                                </div>
                                <input type="button" id="addRow" class="form-control btn btn-primary" value="Add">
                            </form>
                        </div>
                    </div>
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
                                    <th>Description</th>
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
                                    <label for="phone" class="control-label">SubTotal</label>
                                    <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control" disabled required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Discount</label>
                                    <input type="number" step="0.01" name="discount" id="discount" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Total</label>
                                    <input type="number" step="0.01" name="total" id="total" class="form-control" disabled required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Paid Amount</label>
                                    <input type="number" step="0.01" name="paid_amount" id="paid_amount" value="0.00" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group">
                                    <button type="button" id="create" class="btn btn-primary" id="addnew_product">Create</button>
                                </div>
                            </div>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $('#product_category').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $('#client').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $('#product_list').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        jQuery(document).ready(function ($){
            $('#product_category').on('change', function() {
                var product_category_id = $(this).val();
                var supplier_id = $('#supplier').val();

                if (product_category_id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/supplier/get/product/all/" + product_category_id,
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
                                $('#product_list').append(
                                    '<option value="' + value.id + '">' + value.name + '</option>'
                                )
                            });

                            $('#product_list').multiselect('rebuild');
                        },
                    });
                }
            });

            $('#product_list').on('change', function() {
                var product_id = $(this).val();

                if (product_id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/supplier-product/get/product/" + product_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (!response.error) {

                                if(response.data[0] != null){
                                    $('#available_qty').val(response.data[0].qty);
                                }else{
                                    var qty = 0;
                                    $('#available_qty').val(qty);
                                }
                            }
                        },
                        error: function (error) {
                            swal('Failed', 'Unable to get product qty', 'danger');
                        },
                    });
                }
            });
            var i = 0;
            var netValue = 0;
            var subTotal = 0;
            var discount = 0;

            $("#addRow").click(function(){
                var category = $("#product_category option:selected").text();
                var qty = Number($("#product_qty").val());
                var available_qty = Number($('#available_qty').val());
                var product_name = $("#product_list option:selected").text();
                var product_id = $('#product_list').val();
                var product_price = Number($("#product_rate").val());
                var product_description = $("#description").val();
                var total = 0;
                total = (qty*product_price);
                netValue = netValue + total;
                subTotal = netValue;
                var actions = '<button class="btn btn-xs btn-danger del-btn" id="' + i + '"><i class="fa fa-trash"></i></button>';
                var rowData = "<tr><td>"+ i +"<input type='hidden' value='" + product_id + "' class='product_id'></td><td>"+ category + "</td><td>" +  product_name  + "</td><td>"+ product_description + "</td><td>" + qty +"</td><td>"+ product_price +"</td><td>"+ total +"</td><td>"+ actions +"</td></tr>";
                //net value and ordering value
                if (!qty || qty == undefined || qty == 0) {
                    alert("Please Enter Quantity");
                    return;
                } else if (available_qty < qty) {
                    alert("You don't have enough Quantity!");
                    return;
                }else if ( !product_price || product_price == undefined || product_price == 0 ) {
                    alert("Please Enter Unit Price");
                    return;
                } else {
                    $("#products").append(rowData);
                    $("#total").val(netValue);
                    $("#subtotal").val(subTotal);
                    $("#product_rate").val("");
                    $("#product_qty").val("");
                    $("#available_qty").val("");
                }
                $("#"+ i).click(function(e) {
                    e.preventDefault();
                    netValue = netValue - Number($(this).closest('tr').find('td:eq(5)').text());
                    subTotal = subTotal - Number($(this).closest('tr').find('td:eq(5)').text());
                    $("#total").val(netValue);
                    $("#subtotal").val(netValue);
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

            $('#discount').on('change', function(){
                subTotal = Number($('#subtotal').val());
                discount = Number($('#discount').val());
                var discount_amount = (subTotal * discount)/100 ;
                netValue = subTotal - discount_amount;
                $('#total').val(netValue);
            });

            //form submit
            $("#create").on('click', function(e) {
                e.preventDefault();
                var TableData;
                TableData = storeTblValues();
                if(TableData.length == 0)
                {
                    alert('Please add at least one item', 'error');
                    return;
                }
                TableData = JSON.stringify(TableData);
                function storeTblValues()
                {
                    var TableData = new Array();
                    $('#products tr').each(function(row, tr){
                        TableData[row]={
                            "product_category" : $(tr).find('td:eq(1)').text(),
                            "product_name" : $(tr).find('td:eq(2)').text(),
                            "product_description" :$(tr).find('td:eq(3)').text(),
                            "product_qty" :$(tr).find('td:eq(4)').text(),
                            "product_price" :$(tr).find('td:eq(5)').text(),
                            "product_total" :$(tr).find('td:eq(6)').text(),
                            "product_id" :$(tr).find('.product_id').val(),
                        }
                    });
                    return TableData;
                }
                var sub_total = $("#subtotal").val();
                console.log(sub_total);
                var discounts = $("#discount").val();
                console.log(discounts);
                var total = $("#total").val();
                console.log(total);
                var paid_amount = $("#paid_amount").val();
                console.log(paid_amount);
                var client = $("#client").val();
                $.ajax({
                    data: {
                        "total": total,
                        "subtotal": sub_total,
                        "discount": discounts,
                        "paid_amount": paid_amount,
                        "client": client,
                        "TableData": TableData,
                        "_token": "{{csrf_token()}}",
                    },
                    url: "{{ config('app.url') }}/invoice/quick/create",
                    type: "POST",
                    success: function(data) {
                        if (!data.error) {
                            alert("Successefully create !");
                            window.open("{{ route('invoice.index') }}/quick/print/" + data.invoice_id);
                            location.reload();
                        } else {
                            alert("Failed to made create !");
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

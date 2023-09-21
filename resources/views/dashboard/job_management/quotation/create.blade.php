@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('quotation.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Quotation Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Client Information</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">

                                <ul class="nav nav-tabs3">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home-new2">Existing Client</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile-new2">New Client</a></li>
                                </ul>
                                <div class="tab-content">
                                    {{-- Existing Client Form --}}
                                    <div class="tab-pane show active" id="Home-new2">
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Client Name</label>
                                                    <div class="multiselect_div">
                                                        <select id="client" class="multiselect multiselect-custom" name="client_id" required>
                                                            <option value="0">- Choose Client -</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Contact Person</label>
                                                    <input type="text" name="client_name" id="client_name" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Phone</label>
                                                    <input type="text" name="client_phone" id="client_phone" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-3 col-md-12 client-note-container">
                                                <div class="form-group client-note">
                                                    <label for="phone" class="control-label">Client Note</label>
                                                    <textarea class="form-control @error('client_note') is-invalid @enderror" name="client_note" value="{{ old('client_note') }}" rows="6"></textarea>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Pending Payments</label>
                                                    <input type="text" name="pending_payment" id="pending_payment" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Email</label>
                                                    <input type="text" name="client_email" id="client_email" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Fax</label>
                                                    <input type="text" name="client_fax" id="client_fax" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group">
                                                    <label for="client_addrse" class="control-label">Address</label>
                                                    <textarea class="form-control @error('client_addrse') is-invalid @enderror" id="client_addrse" name="client_addrse" disabled rows="6"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- New Client Form --}}
                                    <div class="tab-pane" id="Profile-new2">
                                        <form action="#" id="clientform">
                                            @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Client Name *</label>
                                                        <input type="text" name="name" id="newclient_name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span class="help-block">(Helium Solutions Pvt Ltd)</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Contact Person *</label>
                                                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" class="form-control @error('contact_person') is-invalid @enderror" required>
                                                        @error('contact_person')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span class="help-block">(Mr. Lakshan)</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Phone *</label>
                                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span class="help-block">(077 xxx xxxx)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Email *</label>
                                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span class="help-block">(info@helium.lk)</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Fax</label>
                                                        <input type="text" name="fax" id="fax" value="{{ old('fax') }}" class="form-control @error('fax') is-invalid @enderror">
                                                        @error('fax')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span class="help-block">(011 xxx xxxx)</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="client_addrs" class="control-label">Address</label>
                                                        <textarea class="form-control @error('client_addrs') is-invalid @enderror" id="client_addrs" name="client_addrs" value="{{ old('client_addrs') }}" rows="6"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary mb-2">
                                                <i class="fa fa-plus" id="add"></i> <i class="fa fa-spinner fa-spin" style="display: none;" id="loader"></i> <span>Add</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Quotation Details</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Heading</label>
                                                <input type="text" class="form-control @error('qutation_description') is-invalid @enderror" name="heading" id="heading" required/>
                                            </div>
                                        </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Description</label>
                                            <textarea class="form-control @error('qutation_description') is-invalid @enderror" id="quotation_description" name="quotation_description" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Quotation Items</h2>
                    </div>
                    <div class="body">
                        <form action="#" id="quote_items">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row clearfix">
                                        <div class="col-lg-3 col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Description</label>
                                                <input type="text" class="form-control" name="description" id="description"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Sub Description</label>
                                                <input type="text" class="form-control" name="sub_description" id="sub_description"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Unit Price</label>
                                                <input type="number" step="0.01" min="1" class="form-control" name="unit_price" id="unit_price" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="control-label">Qty</label>
                                                <input type="number" step="1" min="1" class="form-control" name="qty" id="qty" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="addnew">Add</button>
                                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quote Items --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Quote Items</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Sub Description</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_quote_items">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Quote Button --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" id="createquote">
                                        <span>Create Quotation</span>
                                        <div class="la-ball-fall">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

    <style>
        .client-note-container {
            position: relative;
        }

        .client-note {
            position: absolute;
            width: calc(100% - 30px);
        }

        .target {
            border: solid 1px #aaa;
            min-height: 200px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: 300ms all;
            position: relative;
            background-size: cover;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    {{-- Multi Select and Date Pickers Initilization --}}
    <script>
        $(document).ready(function() {
            $('#createquote > div').css('display', 'none');

            $('#save').css('display', 'none');
            $('#addnew').css('display', 'block');
            var rowId = 0;

            $('#client').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#clientform').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: "{{ route('client.store') }}",
                    data: JSON.stringify({
                        name: $('#newclient_name').val(),
                        contact_person: $('#contact_person').val(),
                        phone: $('#phone').val(),
                        email: $('#email').val(),
                        fax: $('#fax').val(),
                        address: $('textarea:input[name=client_addrs]').val(),
                    }),
                    beforeSend: function() {
                        $('#add').css('display', 'none');
                        $('#loader').css('display', 'inline-block');
                        $(':input[type="submit"]').prop('disabled', true);
                    },
                    dataType: 'json',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.error) {
                            swal("Error", "Something went wrong, please try again shortly!", "error");
                            return false;
                        }

                        swal("Success", "Client Added!", "success");
                        $('#clientform')[0].reset();
                        loadClients();
                    },
                    error: function (error) {
                        swal("Failed", "Internal Error, please try later!", "error");
                    },
                    complete: function() {
                        $('#add').css('display', 'inline-block');
                        $('#loader').css('display', 'none');
                        $(':input[type="submit"]').prop('disabled', false);
                    }
                });
            })

            loadClients();

            function loadClients() {
                $.ajax({
                    type: "get",
                    url: "{{ config('app.url') }}/client/get/all",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        $('#client').empty();

                        $('#client').append(
                            '<option value="0">- Choose Client -</option>'
                        )

                        $.each(response.data, function(key, value) {
                            $('#client').append(
                                '<option value="' + value.id + '">' + value.name + ' (' + value.contact_person + ' | ' + value.phone + ' )' +'</option>'
                            )
                        });

                        $('#client').multiselect('rebuild');
                    }
                });
            }

            $('#client').on('change', function() {
                var client_id = $(this).val();

                if (client_id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/client/get/all/" + client_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (!response.error) {
                                $('#client_name').val(response.data.contact_person);
                                $('#client_phone').val(response.data.phone);
                                $('#client_email').val(response.data.email);
                                $('#client_fax').val(response.data.fax);
                                $('#client_addrse').val(response.data.address);
                            }
                        },
                        error: function (error) {
                            swal('Failed', 'Unable to get client information', 'danger');
                        }
                    });
                }
            });

            $('#quote_items').on('submit', function(e) {
                e.preventDefault();

                // Assignign Input values to JQuery Variables
                var $description = $('#description').val();
                var $subDescription = $('#sub_description').val();
                var $unitPrice = $('#unit_price').val();
                var $qty = $('#qty').val();

                // Row Data-Id
                rowId = rowId + 1;

                // Hidden Field for POST to route
                var hidden_values = '';
                hidden_values += `<input type="hidden" class="description" name="quote_items[{0}]['description']" value="{1}"/>`.format(rowId, $description)
                hidden_values += `<input type="hidden" class="sub_description" name="quote_items[{0}]['sub_description']" value="{1}"/>`.format(rowId, $subDescription)
                hidden_values += `<input type="hidden" class="unit_price" name="quote_items[{0}]['unit_price']" value="{1}"/>`.format(rowId, $unitPrice)
                hidden_values += `<input type="hidden" class="qty" name="quote_items[{0}]['qty']" value="{1}"/>`.format(rowId, $qty)

                var item_row = '';

                item_row += '<tr data-id="{0}">'.format(rowId);
                item_row += '<td>{0}</td>'.format('');
                item_row += '<td>{0}</td>'.format($description);
                item_row += '<td>{0}</td>'.format($subDescription);
                item_row += '<td>{0}</td>'.format($unitPrice);
                item_row += '<td>{0}</td>'.format($qty);
                item_row += '<td>{0}</td>'.format((parseFloat($unitPrice) * parseFloat($qty)).toFixed(2));
                item_row += '<td>{0}{1}{2}</td>'.format('<a href="#" class="btn btn-xs btn-warning mr-1 edit"><i class="icon-note"></i></a>', '<a href="#" class="btn btn-xs btn-danger mr-1 delete"><i class="icon-trash"></i></a>', hidden_values)

                $('#tbl_quote_items').append(item_row);

                $('#save').css('display', 'none');
                $('#addnew').css('display', 'block');

                swal('Success', 'Quote Item Added to List', 'success');

                // Handling delete button click event on job list table
                $('.delete').on('click', function (e) {
                    e.preventDefault();

                    $(this).closest('tr').remove()
                });

                // Handling edit button click event on job list table
                $('.edit').on('click', function (e) {
                    e.preventDefault();

                    var $row = $(this).closest('tr');

                    // Setting values to inputs
                    $('#description').val($row.find('.description').val())
                    $('#sub_description').val($row.find('.sub_description').val())
                    $('#unit_price').val($row.find('.unit_price').val())
                    $('#qty').val($row.find('.qty').val())

                    $('#save').css('display', 'block');
                    $('#addnew').css('display', 'none');

                    $(this).closest('tr').remove()
                });

                $(this)[0].reset();
            });

            $('#createquote').on('click', function() {
                $('#createquote > div').css('display', 'block');
                $('#createquote > span').css('display', 'none');

                var $client = $('#client').val();
                if ($client == 0) {
                    swal('Failed', 'Please choose Client', 'warning')
                    return false;
                }

                var $quoteItemCount = $('#tbl_quote_items tr').length;
                if ($quoteItemCount == 0) {
                    swal('Failed', 'Please add at least one quote item to continue', 'warning')
                    return false;
                }

                var quotation_heading = $('#heading').val();
                var quotation_description = $('#quotation_description').val();

                // Get Quote Items List to JSON Object
                var quoteItemsList = $('input[name^="quote_items"]').map(function() {
                      return $(this).val();
                }).get();

                var counter = 0;
                var keys = [
                    'description',
                    'sub_description',
                    'unit_price',
                    'qty',
                ];

                var quoteItems = [];
                var quoteObject = {};

                $.each(quoteItemsList, function(key, value) {
                    var id = keys[counter]
                    quoteObject[id] = value

                    if (counter == 3) {
                        quoteItems.push(quoteObject)
                        quoteObject = {};
                        counter = -1;
                    }
                    counter++;
                });

                // Sending Ajax Request
                $.ajax({
                    type: "POST",
                    url: "{{ config('app.url') }}/quotation/new/quote",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'client_id': $client,
                        'quote_items': quoteItems,
                        'quotation_heading' : quotation_heading,
                        'quotation_description': quotation_description,

                    },
                    success: function (response) {
                        if (response.error) {
                            $.each(response.error, function (key, value) {
                                swal('Error', value[0], 'error');
                                return false;
                            });
                            return;
                        }

                        // window.open("{{ route('quotation.index') }}/to/pdf/" + response.quote_id);
                        location.reload();
                    },
                    error: function (error) {
                        swal('Error', 'Unable to create quotation, please try again later', 'error');
                    },
                    complete: function () {
                        $('#createquote > div').css('display', 'none');
                        $('#createquote > span').css('display', 'block');
                    }
                });
            });

            // String Format Helper
            String.prototype.format = function() {
                var s = this,
                    i = arguments.length;

                while (i--) {
                    s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
                }
                return s;
            };
        });
    </script>
@endsection

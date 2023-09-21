@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('other-payment.index'),
            'page' => 'Manage',
            'current_page' => 'Update',
            'heading' => 'Other Payment Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Update Other Payment</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('other-payment.update',$payment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select a Payment Category</label>
                                        <div class="multiselect_div">
                                            <select id="category" name="category" class="multiselect multiselect-custom @error('category') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($pay_categories as $pay_category)
                                                    <option value="{{ $pay_category->id }}">{{ $pay_category->category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Bank</label>
                                        <input type="text" name="bank" id="bank" value="{{ $payment->bank }}" class="form-control @error('bank') is-invalid @enderror">
                                        @error('bank')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(BOC)</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ $payment->description }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Cheque no</label>
                                        <input type="text" name="cheque_no" id="cheque_no" value="{{ $payment->cheque_no }}" class="form-control @error('cheque_no') is-invalid @enderror">
                                        @error('cheque_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                    <label for="phone" class="control-label">Banking Date</label>
                                        <input name="banking_date" id="banking_date" value="{{ $payment->banking_date }}" placeholder="Banking Date" class="form-control datepicker @error('banking_date') is-invalid @enderror">
                                        @error('banking_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Amount</label>
                                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> <span>Add</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script><!-- Multi Select Plugin Js -->
    <script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $('#category').val('{{ $payment->paymentCategory->id }}');

        $('#category').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '0d',
                daysOfWeekDisabled: [0],
                daysOfWeekHighlighted: [1,2,3,4,5,6]
        });

    </script>
@endsection
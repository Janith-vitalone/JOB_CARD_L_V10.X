@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('jobcard.index'),
            'page' => 'Manage',
            'current_page' => 'Edit',
            'heading' => 'Job Card Management',
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
                                            <div class="col-lg-3 col-md-12 client-note-container">
                                                <div class="form-group client-note">
                                                    <label for="phone" class="control-label">Client Note</label>
                                                    <textarea class="form-control @error('client_note') is-invalid @enderror" name="client_note" rows="6">{{ $job->client_note }}</textarea>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
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
                                        </div>
                                        <div class="row clearfix">
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

        {{-- Screen Shot and Assign To Desginer --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Job Note</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Screenshot</label>
                                            {{-- <div class="span4 target invoice_ss" style="background-image: url('data:image/png;base64,{{ $screenshot }}')"></div> --}}
                                            {{-- <div class="span4 target invoice_ss" style="background-image: url('{{ asset('{{ $screenshot }}')}}');"></div> --}}
                                            <img src="{{ url('/jobs') }}{{ $screenshot }}" id="avatar" class="img-fluid rounded">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Assign To *</label>
                                            <div class="multiselect_div">
                                                <select id="assigned" class="multiselect multiselect-custom" name="assgined_id" required>
                                                    <option value="0">- Choose Designer -</option>
                                                    @foreach ($designers as $designer)
                                                        <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group client-note">
                                            <label for="phone" class="control-label">Job Note</label>
                                            <textarea class="form-control @error('job_note') is-invalid @enderror" name="job_note" rows="5">{{ $job->job_note }}</textarea>
                                            @error('job_note')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label">PO No.</label>
                                    <input type="text" id="po_no" class="form-control @error('po_no') is-invalid @enderror" name="po_no" value="{{ $job->po_no }}" />
                                    @error('po_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job Details --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Job/Product Details</h2>
                    </div>

                    {{-- Job Type Selector --}}
                    <div class="row clearfix mb-5">
                        <div class="col-lg-12 col-md-12">
                            <label class="fancy-radio custom-color-green">
                                <input name="job_type" class="job_type" value="large_format" type="radio" checked><span><i></i>Large Format</span>
                            </label>
                            <label class="fancy-radio custom-color-green">
                                <input name="job_type" class="job_type" value="document" type="radio"><span><i></i>Document</span>
                            </label>
                            <label class="fancy-radio custom-color-green">
                                <input name="job_type" class="job_type" value="product" type="radio"><span><i></i>Product</span>
                            </label>
                        </div>
                    </div>

                    <div id="job-form" class="body">
                        <form action="#" id="job_details">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Description *</label>
                                        <input type="text" value="" name="description" id="description" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Width *</label>
                                        <input type="number" step="0.01" value="" name="width" id="pwidth" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Height *</label>
                                        <input type="number" step="0.01" value="" name="height" id="pheight" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Messure *</label>
                                        <div class="multiselect_div">
                                            <select id="messure" class="multiselect multiselect-custom" name="messure" required>
                                                <option value="0" selected>- Choose Messure -</option>
                                                @foreach ($messures as $messure)
                                                    <option value="{{ $messure->slug }}">{{ $messure->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Format</label>
                                        <div class="multiselect_div">
                                            <select id="format" class="multiselect multiselect-custom" name="format" required>
                                                <option value="0" selected>- Choose Format -</option>
                                                @foreach ($formats as $format)
                                                    <option value="{{ $format->id }}">{{ $format->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Printer</label>
                                        <div class="multiselect_div">
                                            <select id="printer" class="multiselect multiselect-custom" name="printer" required>
                                                <option value="0" selected>- Choose Printer -</option>
                                                @foreach ($printers as $printer)
                                                    <option value="{{ $printer->id }}">{{ $printer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Print Type</label>
                                        <div class="multiselect_div">
                                            <select id="print_type" class="multiselect multiselect-custom" name="print_type" required>
                                                <option value="0" selected>- Choose Print Type -</option>
                                                @foreach ($printTypes as $printType)
                                                    <option value="{{ $printType->slug }}">{{ $printType->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Sqft Rate</label>
                                        <input type="number" step="0.01" name="sqft_rate" value="" id="sqft_rate" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Copies</label>
                                        <input type="text" name="copies" value="" id="copies" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12" hidden>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Material</label>
                                        <div class="multiselect_div">
                                            <select id="material" class="multiselect multiselect-custom" name="material" required>
                                                <option value="0" selected>- Choose Material -</option>
                                                {{-- @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Lamination</label>
                                        <div class="multiselect_div">
                                            <select id="lamination" class="multiselect multiselect-custom" name="lamination" required>
                                                <option value="0" selected>- Choose Lamination -</option>
                                                {{-- @foreach ($laminations as $lamination)
                                                    <option value="{{ $lamination->id }}">{{ $lamination->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Lamination Rate</label>
                                        <input type="number" step="0.01" name="lamination_rate" value="0" id="lamination_rate" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Unit Price</label>
                                        <input type="number" step="0.01" name="unit_price" value="" id="unit_price" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Total</label>
                                        <input type="number" step="0.01" name="total" id="total" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Finishing</label>
                                        <div class="multiselect_div">
                                            <select id="finishing" class="multiselect multiselect-custom" name="finishing" required>
                                                <option value="0" selected>- Choose Finishing -</option>
                                                {{-- @foreach ($finishings as $finishing)
                                                    <option value="{{ $finishing->id }}">{{ $finishing->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Finishing Rate</label>
                                        <input type="number" step="0.01" name="finishing_rate" value="0" id="finishing_rate" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Stock Material Category *</label>
                                        <div class="multiselect_div">
                                            <select id="stock_product_category" class="multiselect multiselect-custom" name="stock_product_category">
                                                <option value="0" selected>- Choose Material Category -</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Stock Material *</label>
                                        <div class="multiselect_div">
                                            <select id="stock_product" class="multiselect multiselect-custom" name="stock_product">
                                                <option value="0" selected>- Choose Material -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12" hidden>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Screenshot</label>
                                        <div class="span4 target job-ss"></div>
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

                    <div id="product-form" class="body">
                        <form action="#" id="product_details">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Product</label>
                                        <div class="multiselect_div">
                                            <select id="product_list" class="multiselect multiselect-custom" name="product_list" required>
                                                <option value="0">- Choose Product -</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12" id="product_desc_container">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Description</label>
                                        <input type="text" name="product_description" id="product_description" class="form-control">
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
                                        <label for="phone" class="control-label">Price</label>
                                        <input type="number" step="0.01" min="1" value="0" name="product_price" id="product_price" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="addnew_product">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job List --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Job List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom spacing8">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Copies</th>
                                        <th>Description</th>
                                        <th>W x H u</th>
                                        <th>Format</th>
                                        <th>Printer | Mode</th>
                                        <th>Material</th>
                                        <th>Lam | Fin</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="job_list">
                                    @foreach ($job->jobHasTasks as $key => $item)
                                        <tr>
                                            @php
                                                $job_image = '1';

                                                if($item->job_ss != null)
                                                {
                                                    $job_image = base64_encode(file_get_contents(public_path('jobs/' . $item->job->job_no . '/tasks/' . $item->job_ss)));
                                                }
                                            @endphp

                                            <td>
                                                @if ($job_image != '1')
                                                    <img src="data:image/png;base64,{{ $job_image }}" class="w35 rounded avatar" alt="Job Screenshot" />
                                                @endif
                                            </td>
                                            <td>{{ $item->copies }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->width }} x {{ $item->height }} {{ $item->unit }}</td>
                                            <td>{{ $item->format }}</td>
                                            <td>{{ $item->printer }} | {{ $item->print_type }}</td>
                                            <td>{{ $item->materials }}</td>
                                            <td>{{ $item->lamination }} | {{ $item->finishing }}</td>
                                            <td>{{ $item->unit_price }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td>
                                                <a href="#" class="btn btn-xs btn-warning mr-1 edit"><i class="icon-note"></i></a>
                                                <a href="#" class="btn btn-xs btn-danger mr-1 delete"><i class="icon-trash"></i></a>

                                                <input type="hidden" class="description" name="job_list[{{ $key + 1 }}]['description']" value="{{ $item->description }}"/>
                                                <input type="hidden" class="width" name="job_list[{{ $key + 1 }}]['width']" value="{{ $item->width }}"/>
                                                <input type="hidden" class="height" name="job_list[{{ $key + 1 }}]['height']" value="{{ $item->height }}"/>
                                                <input type="hidden" class="messure" name="job_list[{{ $key + 1 }}]['messure']" value="{{ $item->unit }}"/>
                                                <input type="hidden" class="format" name="job_list[{{ $key + 1 }}]['format']" value="{{ $item->format_id }}"/>
                                                <input type="hidden" class="printer" name="job_list[{{ $key + 1 }}]['printer']" value="{{ $item->printer_id }}"/>
                                                <input type="hidden" class="print_type" name="job_list[{{ $key + 1 }}]['print_type']" value="{{ $item->print_type }}"/>
                                                <input type="hidden" class="sqft_rate" name="job_list[{{ $key + 1 }}]['sqft_rate']" value="{{ $item->sqft_rate }}"/>
                                                <input type="hidden" class="copies" name="job_list[{{ $key + 1 }}]['copies']" value="{{ $item->copies }}"/>
                                                <input type="hidden" class="material" name="job_list[{{ $key + 1 }}]['material']" value="{{ $item->material_id }}"/>
                                                <input type="hidden" class="lamination" name="job_list[{{ $key + 1 }}]['lamination']" value="{{ $item->lamination_id }}"/>
                                                <input type="hidden" class="unit_price" name="job_list[{{ $key + 1 }}]['unit_price']" value="{{ $item->unit_price }}"/>
                                                <input type="hidden" class="total" name="job_list[{{ $key + 1 }}]['total']" value="{{ $item->total }}"/>
                                                <input type="hidden" class="finishing" name="job_list[{{ $key + 1 }}]['finishing']" value="{{ $item->finishing_id }}"/>
                                                <input type="hidden" class="s_job_type" name="job_list[{{ $key + 1 }}]['job_type']" value="{{ $item->job_type }}"/>
                                                <input type="hidden" class="stock_product_category" name="job_list[{{ $key + 1 }}]['stock_product_category']" value="{{ $item->product_category_id }}"/>
                                                <input type="hidden" class="stock_product" name="job_list[{{ $key + 1 }}]['stock_product']" value="{{ $item->product_id }}"/>
                                                @if ($job_image != '1')
                                                    <input type="hidden" class="job_ss" name="job_list[{{ $key + 1 }}]['job_ss']" value="data:image/png;base64,{{ $job_image }}"/>
                                                @else
                                                    <input type="hidden" class="job_ss" name="job_list[{{ $key + 1 }}]['job_ss']" value="1"/>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="products">
                                    @foreach ($job->jobHasProducts as $key => $item)
                                        <tr>
                                            <td></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->total }}</td>
                                            <td>
                                                <a href="#" class="btn btn-xs btn-danger mr-1 delete-pr"><i class="icon-trash"></i></a>

                                                <input type="hidden" class="product" name="product_list_items[{{ $key + 1 }}]['product']" value="{{ $item->name }}"/>
                                                <input type="hidden" class="price" name="product_list_items[{{ $key + 1 }}]['price']" value="{{ $item->price }}"/>
                                                <input type="hidden" class="qty" name="product_list_items[{{ $key + 1 }}]['qty']" value="{{ $item->qty }}"/>
                                                <input type="hidden" class="description" name="product_list_items[{{ $key + 1 }}]['description']" value="{{ $item->description }}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Job Button --}}
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <input name="finish_date" id="finish_date" placeholder="Finish Date" class="form-control datepicker" value="{{ $job->finishing_date }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <div class="multiselect_div">
                                        <select class="multiselect multiselect-custom" id="finish_time" name="finish_time">
                                            <option value="0">- Select Time -</option>
                                            <option value="8.00">8.00</option>
                                            <option value="8.30">8.30</option>
                                            <option value="9.00">9.00</option>
                                            <option value="9.30">9.30</option>
                                            <option value="10.00">10.00</option>
                                            <option value="10.30">10.30</option>
                                            <option value="11.00">11.00</option>
                                            <option value="11.30">11.30</option>
                                            <option value="12.00">12.00</option>
                                            <option value="12.30">12.30</option>
                                            <option value="13.00">13.00</option>
                                            <option value="13.30">13.30</option>
                                            <option value="14.00">14.00</option>
                                            <option value="14.30">14.30</option>
                                            <option value="15.00">15.00</option>
                                            <option value="15.30">15.30</option>
                                            <option value="16.00">16.00</option>
                                            <option value="16.30">16.30</option>
                                            <option value="17.00">17.00</option>
                                            <option value="17.30">17.30</option>
                                            <option value="18.00">18.00</option>
                                            <option value="18.30">18.30</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" id="createjob">
                                        <span>Update Job</span>
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

        .avatar {
            object-fit: cover;
        }
        #avatar {
            max-width: 256px;
            max-height: 256px;
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
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '0d',
                daysOfWeekDisabled: [0],
                daysOfWeekHighlighted: [1,2,3,4,5,6]
            });

            $('#product_list').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#client').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#messure').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#printer').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#print_type').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#lamination').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#material').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#finishing').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#format').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#assigned').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#stock_product_category').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#stock_product').multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 200
            });

            $('#assigned').val('{{ $job->user_id }}');
            $('#assigned').multiselect('rebuild');

            $('#finish_time').multiselect({
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
        });

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
                            '<option value="' + value.id + '">' + value.name + '</option>'
                        )
                    });

                    $('#client').val('{{ $job->client->id }}');
                    $('#client').multiselect('rebuild');
                    $('#client').trigger('change');
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
                            $('#pending_payment').val(response.pending_payments.toFixed(2));
                        }
                    },
                    error: function (error) {
                        swal('Failed', 'Unable to get client information', 'danger');
                    }
                });
            }
        });
    </script>

    {{-- Copy clipboard Image --}}
    <script>
        // Created by STRd6
        // MIT License
        // jquery.paste_image_reader.js
        (function($) {
            var defaults;
            $.event.fix = (function(originalFix) {
                return function(event) {
                    event = originalFix.apply(this, arguments);
                    if (event.type.indexOf("copy") === 0 || event.type.indexOf("paste") === 0) {
                        event.clipboardData = event.originalEvent.clipboardData;
                    }
                    return event;
                };
            })($.event.fix);
            defaults = {
                callback: $.noop,
                matchType: /image.*/
            };
            return ($.fn.pasteImageReader = function(options) {
                if (typeof options === "function") {
                    options = {
                        callback: options
                    };
                }
                options = $.extend({}, defaults, options);
                return this.each(function() {
                    var $this, element;
                    element = this;
                    $this = $(this);
                    return $this.bind("paste", function(event) {
                        var clipboardData, found;
                        found = false;
                        clipboardData = event.clipboardData;
                        return Array.prototype.forEach.call(clipboardData.types, function(type, i) {
                            var file, reader;
                            if (found) {
                                return;
                            }
                            if (
                                type.match(options.matchType) ||
                                clipboardData.items[i].type.match(options.matchType)
                            ) {
                                file = clipboardData.items[i].getAsFile();
                                reader = new FileReader();
                                reader.onload = function(evt) {
                                    return options.callback.call(element, {
                                        dataURL: evt.target.result,
                                        event: evt,
                                        file: file,
                                        name: file.name
                                    });
                                };
                                reader.readAsDataURL(file);
                                snapshoot();
                                return (found = true);
                            }
                        });
                    });
                });
            });
        })(jQuery);

        var dataURL, filename;
        $("html").pasteImageReader(function(results) {
            filename = results.filename, dataURL = results.dataURL;
            $data.text(dataURL);
            $size.val(results.file.size);
            $type.val(results.file.type);
            var img = document.createElement("img");
            img.src = dataURL;
            var w = img.width;
            var h = img.height;
            $width.val(w);
            $height.val(h);
            return $(".activated")
                .css({
                    backgroundImage: "url(" + dataURL + ")"
                })
                .data({ width: w, height: h });
        });

        var $data, $size, $type, $width, $height;
        $(function() {
            $data = $(".data");
            $size = $(".size");
            $type = $(".type");
            $width = $("#width");
            $height = $("#height");
            $(".target").on("click", function() {
                var $this = $(this);
                var bi = $this.css("background-image");
                if (bi != "none") {
                    $data.text(bi.substr(4, bi.length - 6));
                }

                $(".activated").removeClass("activated");
                $this.addClass("activated");

                $this.toggleClass("contain");

                $width.val($this.data("width"));
                $height.val($this.data("height"));
                if ($this.hasClass("contain")) {
                    // $this.css({
                    //     width: $this.data("width"),
                    //     height: $this.data("height"),
                    //     "z-index": "10"
                    // });
                } else {
                    $this.css({ width: "", height: "", "z-index": "" });
                }
            });
        });

        function copy(text) {
            var t = document.getElementById("base64");
            t.select();
            try {
                var successful = document.execCommand("copy");
                var msg = successful ? "successfully" : "unsuccessfully";
                alert("Base64 data coppied " + msg + " to clipboard");
            } catch (err) {
                alert("Unable to copy text");
            }
        }

    </script>

    {{-- Add Job Info --}}
    <script>
        $(document).ready(function() {
            $('#save').css('display', 'none');
            $('#addnew').css('display', 'block');
            $('#product-form').css('display', 'none');
            $('#createjob > div').css('display', 'none');
            $('#product_desc_container').css('display', 'none');

            var rowId = {{ $job->jobHasTasks->count() + 1 }};
            var rowIdPr = {{ $job->jobHasProducts->count() + 1 }};
            var jobType = 'large_format';

            // Displaying relevant form
            $('.job_type').on('change', function(e) {
                loadDataByJobType(true);
            });

            function loadDataByJobType(isAsync)
            {
                jobType = $('input[name=job_type]:checked').val();

                // Get dependable data to Dropdowns
                $.ajax({
                    type: "get",
                    async: isAsync,
                    url: "{{ config('app.url') }}/jobcard/get/data/bytype/" + jobType,
                    success: function (response) {
                        if (!response.error) {
                            var formats = response.data.formats;
                            var print_types = response.data.print_types;
                            var printers = response.data.printers;

                            // Loading Formats
                            $('#format').empty();
                            $('#format').append("<option value='0'>- Choose Format -</option>");

                            $.each(formats, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.id, value.name);

                                $('#format').append(item);
                            });

                            $('#format').multiselect('destroy')
                            $('#format').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            // Loading Print Types
                            $('#print_type').empty();
                            $('#print_type').append("<option value='0'>- Choose Print Type -</option>");

                            $.each(print_types, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.slug, value.name);

                                $('#print_type').append(item);
                            });

                            $('#print_type').multiselect('destroy')
                            $('#print_type').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            // Loading Printers
                            $('#printer').empty();
                            $('#printer').append("<option value='0'>- Choose Printer -</option>");

                            $.each(printers, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.id, value.name);

                                $('#printer').append(item);
                            });

                            $('#printer').multiselect('destroy')
                            $('#printer').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            $('#format').trigger('change')

                            return false;
                        }

                        alert('Cannot get Formats, Print Types, Printers Data');
                    },
                    error: function (error) {
                        alert('Cannot get Formats, Print Types, Printers Data');
                    }
                });

                if (jobType === 'product') {
                    $('#job-form').css('display', 'none');
                    $('#product-form').css('display', 'block');
                    return;
                }

                if (jobType === 'document') {
                    $('#job-form').css('display', 'block');
                    $('#product-form').css('display', 'none');
                    $('#pwidth').val(1);
                    $('#pheight').val(1);
                    return;
                }

                $('#pwidth').val('');
                $('#pheight').val('');
                $('#job-form').css('display', 'block');
                $('#product-form').css('display', 'none');
            }

            // Get Products Price
            $('#product_list').on('change', function() {
                var id = $(this).val();

                if (id != 0) {
                    if (id == 1) {
                        $('#product_desc_container').css('display', 'block');
                    } else {
                        $('#product_desc_container').css('display', 'none');
                    }

                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/product/get/byid/" + id,
                        success: function (response) {
                            if (!response.error) {
                                var price = response.data.price;

                                $('#product_price').val(price);
                                return false;
                            }

                            alert('Cannot get Product Price');
                        },
                        error: function (error) {
                            alert('Cannot get Product Price');
                        }
                    });

                    return;
                }

                $('#product_desc_container').css('display', 'none');
                $('#product_price').val(0);
            });

            // Adding Products
            $('#product_details').on('submit', function(e) {
                e.preventDefault();

                var $product = $('#product_list').val();
                var $product_name = $( "#product_list option:selected" ).text();
                var $price = $('#product_price').val();
                var $qty = $('#product_qty').val();
                var $description = $('#product_description').val();
                var $escapedDescription = escape($('#product_description').val());

                if ($product_name == 'Custom') {
                    $product_name = $description;
                }

                // Row Data-Id
                rowIdPr = rowIdPr + 1;

                // Hidden Field for POST to route
                var hidden_values = '';
                hidden_values += `<input type="hidden" class="product" name="product_list_items[{0}]['product']" value="{1}"/>`.format(rowIdPr, $product)
                hidden_values += `<input type="hidden" class="price" name="product_list_items[{0}]['price']" value="{1}"/>`.format(rowIdPr, $price)
                hidden_values += `<input type="hidden" class="qty" name="product_list_items[{0}]['qty']" value="{1}"/>`.format(rowIdPr, $qty)
                hidden_values += `<input type="hidden" class="description" name="product_list_items[{0}]['description']" value="{1}"/>`.format(rowIdPr, $escapedDescription)

                var product_row = '';

                product_row += '<tr data-id="{0}">'.format(rowIdPr)
                product_row += '<td>{0}</td>'.format('')
                product_row += '<td>{0}</td>'.format($product_name)
                product_row += '<td>{0}</td>'.format($qty)
                product_row += '<td>{0}</td>'.format($price)
                product_row += '<td>{0}</td>'.format((parseFloat($qty) * parseFloat($price)).toFixed(2))
                product_row += '<td>{0}{1}</td>'.format('<a href="#" class="btn btn-xs btn-danger mr-1 delete-pr"><i class="icon-trash"></i></a>', hidden_values)
                product_row += '</tr>'

                $('#products').append(product_row);

                swal('Success', 'Product Added to List', 'success')

                // Handling delete button click event on job list table
                $('.delete-pr').on('click', function (e) {
                    e.preventDefault();

                    $(this).closest('tr').remove()
                })

                $('#product_list').val(0);
                $('#product_list').multiselect('refresh');
                $('#product_list').trigger('change');

                $('#product_price').val(0);
                $('#product_qty').val(1);
                $('#product_description').val('');
            });

            // Handler for Current Products
            // Handling delete button click event on job list table
            $('.delete-pr').on('click', function (e) {
                e.preventDefault();

                $(this).closest('tr').remove()
            })

            $('#pwidth, #pheight, #messure, #sqft_rate').on('change', function() {
                calculateUnitPrice();
            });

            // Calculating Unit Price
            function calculateUnitPrice() {
                var $printing_width = parseFloat($('#pwidth').val());
                var $printing_height = parseFloat($('#pheight').val());
                var $meassure = $('#messure').val();
                var $sqft_rate = parseFloat($('#sqft_rate').val());
                var $job_type = $("input[name='job_type']:checked").val();

                if ($printing_width != null && $printing_height != null && $sqft_rate != null) {
                    if ($job_type === 'large_format') {
                        var $area = $printing_width * $printing_height;
                        var $sqft = 0;

                        if ($area > 0) {
                            // Converting width x height to sqft
                            switch($meassure) {
                                case 'cm':
                                    $sqft = $area * {{ config('unit.cm') }};
                                    break;
                                case 'mm':
                                    $sqft = $area * {{ config('unit.mm') }};
                                    break;
                                case 'm':
                                    $sqft = $area * {{ config('unit.m') }};
                                    break;
                                case 'in':
                                    $sqft = $area * {{ config('unit.in') }};
                                    break;
                                default:
                                    $sqft = $area;
                                    break;
                            }

                            var $unit_price = ($sqft * $sqft_rate).toFixed(2);

                            $('#unit_price').val($unit_price);
                            calculateTotalPrice();
                        }
                    } else {
                        $('#unit_price').val($sqft_rate);
                        calculateTotalPrice();
                    }
                }
            }

            $('#unit_price, #finishing_rate, #lamination_rate, #copies').on('change', function() {
                calculateTotalPrice();
            });

            // get products by product category
            $('#stock_product_category').on('change', function() {
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
                                $('#stock_product').empty();

                                $('#stock_product').append(
                                    '<option value="0">- Choose Product -</option>'
                                )

                                $.each(response.data, function(key, value) {
                                    $('#stock_product').append(
                                        '<option value="' + value.id + '">' + value.name + '</option>'
                                    )
                                });

                                $('#stock_product').multiselect('rebuild');
                            },
                        });
                    }
            });

            // Calculating Total Price
            function calculateTotalPrice() {
                var $unit_price = parseFloat($('#unit_price').val());
                var $finishing_rate = parseFloat($('#finishing_rate').val());
                var $lamination_rate = parseFloat($('#lamination_rate').val());
                var $copies = parseFloat($('#copies').val());

                if ($unit_price != null && $finishing_rate != null && $lamination_rate != null) {
                    var $total = (($unit_price * $copies) + $finishing_rate + $lamination_rate).toFixed(2);

                    $('#total').val($total);
                }
            }

            // Adding job details to the list
            $('#job_details').on('submit', function(e) {
                e.preventDefault();

                // Assignign Input values to JQuery Variables
                var $description = $('#description').val();
                var $pwidth = $('#pwidth').val();
                var $pheight = $('#pheight').val();
                var $messure = $('#messure').val();
                var $format = $('#format').val();
                var $format_text = $('#format :selected').text();
                var $printer = $('#printer').val();
                var $printer_text = $('#printer :selected').text();
                var $print_type = $('#print_type').val();
                var $sqft_rate = $('#sqft_rate').val();
                var $copies = $('#copies').val();
                var $material = $('#material').val();
                var $material_text = $('#material :selected').text();
                var $lamination = $('#lamination').val();
                var $lamination_text = $('#lamination :selected').text();
                var $lamination_rate = $('#lamination_rate').val();
                var $unit_price = $('#unit_price').val();
                var $total = $('#total').val();
                var $finishing = $('#finishing').val();
                var $finishing_text = $('#finishing :selected').text();
                var $finishing_rate = $('#finishing_rate').val();
                var $job_type = $('.job_type').val();
                // for stock
                var $stock_product_category = $('#stock_product_category').val();
                var $stock_product = $('#stock_product').val();
                var $stock_product_text = $('#stock_product :selected').text();

                var $job_ss = $('.job-ss').css('background-image');
                $job_ss = $job_ss.replace('url(','').replace(')','').replace(/\"/gi, "");
                $job_image = '<img src="{0}" class="w35 rounded avatar" alt="Job Screenshot" />'.format($job_ss);

                if ($job_ss == 'none') {
                    $job_ss = 1;
                    $job_image = '--';
                }

                // Selectable option validations
                if ($description.length == 0){
                    // VALIDATE DESCRIPTION
                    swal('Failed', 'Please Enter Description', 'warning')
                    return false;
                } else if($pwidth.length == 0) {
                    // VALIDATE WIDTH
                    swal('Failed', 'Please Enter Width', 'warning')
                    return false;
                } else if($pheight.length == 0) {
                    // VALIDATE HEIGHT
                    swal('Failed', 'Please Enter Height', 'warning')
                    return false;
                } else if ($messure == 0) {
                    // VALIDATE MESSURE MENT UNIT
                    swal('Failed', 'Please Choose Messure', 'warning')
                    return false;
                } else if($copies.length == 0) {
                    // VALIDATE COPIES / QTY
                    swal('Failed', 'Please Enter Copies', 'warning')
                    return false;
                }
                // VALIDATE STOCK
                else if ($stock_product_category == 0) {
                    // VALIDATE PRODUCT CATEGORY
                    swal('Failed', 'Please Choose Stock - Material Category', 'warning')
                    return false;
                } else if ($stock_product == 0) {
                    // VALIDATE  PRODUCT
                    swal('Failed', 'Please Choose Stock - Material', 'warning')
                    return false;
                }
                // format doesn't select
                if ($format == 0) {
                    $format = $('#format').val(0);
                    $format_text = "None";
                }
                // else if(){

                // }
                // PRINT DOESN'T SELECT
                if ($printer == 0) {
                    $printer = $('#printer').val(0);
                    $printer_text = "None";
                }
                if ($sqft_rate.length == 0) {
                    $sqft_rate = $('#sqft_rate').val(0);
                }
                // material doesn't select
                if ($material == 0) {
                    $material = $('#stock_product').val();
                    $material_text = $('#stock_product :selected').text();
                }
                // lamination doesn't select
                if ($lamination == 0) {
                    $lamination = $('#lamination').val(0);
                    $lamination_text = "None";
                    $lamination_rate = $('#lamination_rate').val(0);
                }
                // finishing doesn't select
                if ($finishing == 0) {
                    $finishing = $('#finishing').val(0);
                    $finishing_text = "None";
                    $finishing_rate = $('#finishing_rate').val(0);
                }

                // Row Data-Id
                rowId = rowId + 1;

                // Hidden Field for POST to route
                var hidden_values = '';
                hidden_values += `<input type="hidden" class="description" name="job_list[{0}]['description']" value="{1}"/>`.format(rowId, $description)
                hidden_values += `<input type="hidden" class="width" name="job_list[{0}]['width']" value="{1}"/>`.format(rowId, $pwidth)
                hidden_values += `<input type="hidden" class="height" name="job_list[{0}]['height']" value="{1}"/>`.format(rowId, $pheight)
                hidden_values += `<input type="hidden" class="messure" name="job_list[{0}]['messure']" value="{1}"/>`.format(rowId, $messure)
                hidden_values += `<input type="hidden" class="format" name="job_list[{0}]['format']" value="{1}"/>`.format(rowId, $format)
                hidden_values += `<input type="hidden" class="printer" name="job_list[{0}]['printer']" value="{1}"/>`.format(rowId, $printer)
                hidden_values += `<input type="hidden" class="print_type" name="job_list[{0}]['print_type']" value="{1}"/>`.format(rowId, $print_type)
                hidden_values += `<input type="hidden" class="sqft_rate" name="job_list[{0}]['sqft_rate']" value="{1}"/>`.format(rowId, $sqft_rate)
                hidden_values += `<input type="hidden" class="copies" name="job_list[{0}]['copies']" value="{1}"/>`.format(rowId, $copies)
                hidden_values += `<input type="hidden" class="material" name="job_list[{0}]['material']" value="{1}"/>`.format(rowId, $material)
                hidden_values += `<input type="hidden" class="lamination" name="job_list[{0}]['lamination']" value="{1}"/>`.format(rowId, $lamination)
                hidden_values += `<input type="hidden" class="unit_price" name="job_list[{0}]['unit_price']" value="{1}"/>`.format(rowId, $unit_price)
                hidden_values += `<input type="hidden" class="total" name="job_list[{0}]['total']" value="{1}"/>`.format(rowId, $total)
                hidden_values += `<input type="hidden" class="finishing" name="job_list[{0}]['finishing']" value="{1}"/>`.format(rowId, $finishing)
                hidden_values += `<input type="hidden" class="s_job_type" name="job_list[{0}]['job_type']" value="{1}"/>`.format(rowId, $job_type)
                hidden_values += `<input type="hidden" class="job_ss" name="job_list[{0}]['job_ss']" value="{1}"/>`.format(rowId, $job_ss)
                hidden_values += `<input type="hidden" class="stock_product_category" name="job_list[{0}]['stock_product_category']" value="{1}"/>`.format(rowId, $stock_product_category)
                hidden_values += `<input type="hidden" class="stock_product" name="job_list[{0}]['stock_product']" value="{1}"/>`.format(rowId, $stock_product)
                // material
                var $material_name = '';
                if($material_text == "None"){
                   $material_name = $stock_product_text;
                }else{
                    $material_name = $material_text;
                }

                var job_row = '';

                job_row += '<tr data-id="{0}">'.format(rowId)
                job_row += '<td>{0}</td>'.format($job_image)
                job_row += '<td>{0}</td>'.format($copies)
                job_row += '<td>{0}</td>'.format($description)
                job_row += '<td>{0} x {1} {2}</td>'.format($pwidth, $pheight, $messure)
                job_row += '<td>{0}</td>'.format($format_text)
                job_row += '<td>{0} | {1}</td>'.format($printer_text, $print_type)
                job_row += '<td>{0}</td>'.format($material_text)
                job_row += '<td>{0} | {1}</td>'.format($lamination_text, $finishing_text)
                job_row += '<td>{0}</td>'.format($unit_price)
                job_row += '<td>{0}</td>'.format($total)
                job_row += '<td>{0}{1}{2}</td>'.format('<a href="#" class="btn btn-xs btn-warning mr-1 edit"><i class="icon-note"></i></a>', '<a href="#" class="btn btn-xs btn-danger mr-1 delete"><i class="icon-trash"></i></a>', hidden_values)
                job_row += '</tr>'

                $('#job_list').append(job_row);

                $('#save').css('display', 'none');
                $('#addnew').css('display', 'block');

                swal('Success', 'Job Added to List', 'success')

                // Handling delete button click event on job list table
                $('.delete').on('click', function (e) {
                    e.preventDefault();

                    $(this).closest('tr').remove()
                })

                // Handling edit button click event on job list table
                $('.edit').on('click', function (e) {
                    e.preventDefault();

                    var $row = $(this).closest('tr');

                    // Changing Job Type
                    var job_type = $row.find('.s_job_type').val();

                    var $radios = $('input:radio[name=job_type]');
                    $radios.filter('[value='+ job_type +']').prop('checked', true);

                    loadDataByJobType(false);

                    // Setting values to inputs
                    $('#description').val($row.find('.description').val())
                    $('#pwidth').val($row.find('.width').val())
                    $('#pheight').val($row.find('.height').val())
                    $('#messure').val($row.find('.messure').val())
                    $('#format').val($row.find('.format').val())
                    $('#format').trigger('change')
                    $('#printer').val($row.find('.printer').val())
                    $('#print_type').val($row.find('.print_type').val())
                    $('#sqft_rate').val($row.find('.sqft_rate').val())
                    $('#copies').val($row.find('.copies').val())
                    $('#material').val($row.find('.material').val())
                    $('#lamination').val($row.find('.lamination').val())
                    $('#unit_price').val($row.find('.unit_price').val())
                    $('#total').val($row.find('.total').val())
                    $('#finishing').val($row.find('.finishing').val())

                    $('#stock_product_category').val($row.find('.stock_product_category').val())
                    $('#stock_product').val($row.find('.stock_product').val())

                    if ($row.find('.job_ss').val() == '1') {
                        $('.job-ss').css("background-image", 'none');
                    } else {
                        $('.job-ss').css("background-image", "url("+ $row.find('.job_ss').val() +")");
                    }

                    // Refreshing Multiselect
                    $('#lamination').multiselect('refresh')
                    $('#finishing').multiselect('refresh')
                    $('#printer').multiselect('refresh')
                    $('#format').multiselect('refresh')
                    $('#messure').multiselect('refresh')
                    $('#material').multiselect('refresh')
                    $('#print_type').multiselect('refresh')
                    $('#stock_product_category').multiselect('refresh')

                    // Triggering lamination and finishing select box change method to fetch their rates
                    $('#lamination').trigger("change");
                    $('#finishing').trigger("change");
                    $('#stock_product_category').trigger("change");

                    $('#save').css('display', 'block');
                    $('#addnew').css('display', 'none');

                    $(this).closest('tr').remove()
                });

                // Resetting Form
                $('#description').val('')
                $('#pwidth').val('')
                $('#pheight').val('')
                $('#messure').val('0')
                $('#format').val('0')
                $('#printer').val('0')
                $('#print_type').val('0')
                $('#sqft_rate').val('')
                $('#copies').val('')
                $('#material').val('0')
                $('#lamination').val('0')
                $('#unit_price').val('')
                $('#total').val('')
                $('#finishing').val('0')
                $('#finishing_rate').val('')
                $('#lamination_rate').val('')
                $('.job-ss').css("background-image", '')
                $('#stock_product').val('0')
                $('#stock_product_category').val('0')

                // Refreshing Multiselect
                $('#lamination').multiselect('refresh')
                $('#finishing').multiselect('refresh')
                $('#printer').multiselect('refresh')
                $('#format').multiselect('refresh')
                $('#messure').multiselect('refresh')
                $('#material').multiselect('refresh')
                $('#print_type').multiselect('refresh')
                $('#stock_product').multiselect('refresh')
                $('#stock_product_category').multiselect('refresh')
            });

            // Handling Current Jobs Click Events
            // Handling delete button click event on job list table
            $('.delete').on('click', function (e) {
                e.preventDefault();

                $(this).closest('tr').remove()
            })

            // Handling edit button click event on job list table
            $('.edit').on('click', function (e) {
                e.preventDefault();

                var $row = $(this).closest('tr');

                // Changing Job Type
                var job_type = $row.find('.s_job_type').val();

                var $radios = $('input:radio[name=job_type]');
                $radios.filter('[value='+ job_type +']').prop('checked', true);

                loadDataByJobType(false);

                // Setting values to inputs
                $('#description').val($row.find('.description').val())
                $('#pwidth').val($row.find('.width').val())
                $('#pheight').val($row.find('.height').val())
                $('#messure').val($row.find('.messure').val())
                $('#format').val($row.find('.format').val())
                $('#format').trigger('change')
                $('#printer').val($row.find('.printer').val())
                $('#print_type').val($row.find('.print_type').val())
                $('#sqft_rate').val($row.find('.sqft_rate').val())
                $('#copies').val($row.find('.copies').val())
                $('#material').val($row.find('.material').val())
                $('#lamination').val($row.find('.lamination').val())
                $('#unit_price').val($row.find('.unit_price').val())
                $('#total').val($row.find('.total').val())
                $('#finishing').val($row.find('.finishing').val())
                if ($row.find('.job_ss').val() == '1') {
                    $('.job-ss').css("background-image", 'none');
                } else {
                    $('.job-ss').css("background-image", "url("+ $row.find('.job_ss').val() +")");
                }

                // Refreshing Multiselect
                $('#lamination').multiselect('refresh')
                $('#finishing').multiselect('refresh')
                $('#printer').multiselect('refresh')
                $('#format').multiselect('refresh')
                $('#messure').multiselect('refresh')
                $('#material').multiselect('refresh')
                $('#print_type').multiselect('refresh')

                // Triggering lamination and finishing select box change method to fetch their rates
                $('#lamination').trigger("change");
                $('#finishing').trigger("change");

                $('#save').css('display', 'block');
                $('#addnew').css('display', 'none');

                $(this).closest('tr').remove()
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

            // Get Material, Lamination, Finishing according to Format
            $('#format').on('change', function() {
                var format = $(this).val();

                if (format == 0) {
                    $('#material').empty();
                    $('#material').append("<option value='0'>- Choose Material -</option>");

                    $('#lamination').empty();
                    $('#lamination').append("<option value='0'>- Choose Lamination -</option>");

                    $('#finishing').empty();
                    $('#finishing').append("<option value='0'>- Choose Finishing -</option>");

                    $('#material').multiselect('destroy')
                    $('#material').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        maxHeight: 200
                    })
                    $('#lamination').multiselect('destroy')
                    $('#lamination').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        maxHeight: 200
                    })
                    $('#finishing').multiselect('destroy')
                    $('#finishing').multiselect({
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        maxHeight: 200
                    })

                    $('#lamination_rate').val('0');
                    $('#finishing_rate').val('0');
                    calculateTotalPrice();
                    return;
                }

                $.ajax({
                    type: "get",
                    url: "{{ config('app.url') }}/format/get/byid/" + format,
                    async: false,
                    success: function (response) {
                        if (!response.error) {
                            var materials = response.data.materials;
                            var laminations = response.data.laminations;
                            var finishings = response.data.finishings;

                            // Loading Materials
                            $('#material').empty();
                            $('#material').append("<option value='0'>- Choose Material -</option>");

                            $.each(materials, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.id, value.name);

                                $('#material').append(item);
                            });

                            $('#material').multiselect('destroy')
                            $('#material').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            // Loading Laminations
                            $('#lamination').empty();
                            $('#lamination').append("<option value='0'>- Choose Lamination -</option>");

                            $.each(laminations, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.id, value.name);

                                $('#lamination').append(item);
                            });

                            $('#lamination').multiselect('destroy')
                            $('#lamination').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            // Loading Laminations
                            $('#finishing').empty();
                            $('#finishing').append("<option value='0'>- Choose Finishing -</option>");

                            $.each(finishings, function(key, value) {
                                var item = "<option value='{0}'>{1}</option>".format(value.id, value.name);

                                $('#finishing').append(item);
                            });

                            $('#finishing').multiselect('destroy')
                            $('#finishing').multiselect({
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                maxHeight: 200
                            })

                            return false;
                        }

                        alert('Cannot get Material, Lamination, Finishing Data');
                    },
                    complete: function () {
                        $('#material').multiselect('refresh');
                    },
                    error: function (error) {
                        alert('Cannot get Material, Lamination, Finishing Data');
                    }
                });
            });

            // Get sqft Rate
            $('#print_type').on('change', function() {
                var $id = $(this).val()

                if ($id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/printtype/get/byid/" + $id,
                        success: function (response) {
                            if (!response.error) {
                                var rate = response.data[0].rate;

                                $('#sqft_rate').val(rate);
                                $('#sqft_rate').trigger('change');
                                return false;
                            }

                            alert('Cannot get Square Feet Rate');
                        },
                        error: function (error) {
                            alert('Cannot get Square Feet Details');
                        }
                    });
                    return;
                }

                $('#sqft_rate').val('0');
            });

            // Get Lamination Rate
            $('#lamination').on('change', function() {
                var $id = $(this).val()

                if ($id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/lamination/get/byid/" + $id,
                        success: function (response) {
                            if (!response.error) {
                                var rate = response.data.rate;

                                $('#lamination_rate').val(rate);
                                $('#lamination_rate').trigger('change');
                                return false;
                            }

                            alert('Cannot get Lamination Rate');
                        },
                        error: function (error) {
                            alert('Cannot get Lamination Details');
                        }
                    });
                    return;
                }
            });

            // Get Finishing Rate
            $('#finishing').on('change', function() {
                var id = $(this).val()

                if (id != 0) {
                    $.ajax({
                        type: "get",
                        url: "{{ config('app.url') }}/finishing/get/byid/" + id,
                        success: function (response) {
                            if (!response.error) {
                                var rate = response.data.rate;

                                $('#finishing_rate').val(rate);
                                $('#finishing_rate').trigger('change');
                                return false;
                            }

                            alert('Cannot get Finishing Rate');
                        },
                        error: function (error) {
                            alert('Cannot get Finishing Details');
                        }
                    });
                    return;
                }
            });

            // Create Job
            $('#createjob').on('click', function() {
                var $job_count = $('#job_list tr').length
                var $product_count = $('#products tr').length

                if ($job_count == 0 && $product_count == 0) {
                    swal('Failed', 'Please add at least one job/product to continue', 'warning')
                    return false;
                }

                var $finish_date = $('#finish_date').val();
                var $finish_time = $('#finish_time').val();

                if ($finish_date == '' || $finish_time == 0) {
                    swal('Failed', 'Please choose Finish Date and Finish Time', 'warning')
                    return false;
                }

                var $client = $('#client').val();
                var $clientNote = $('textarea:input[name=client_note]').val();

                if ($client == 0) {
                    swal('Failed', 'Please choose Client', 'warning')
                    return false;
                }

                var $designer = $('#assigned').val()

                if ($designer == 0) {
                    swal('Failed', 'Please choose Assigned Designer', 'warning')
                    return false;
                }

                // Values
                var $jobNote = $('textarea:input[name=job_note]').val();
                var $poNo = $('#po_no').val();

                // Get Job List to JSON Object
                var job_list = $('input[name^="job_list"]').map(function() {
                      return $(this).val()
                }).get();

                console.log("job list");
                console.log(job_list);

                var counter = 0;
                var keys = [
                    'description',
                    'width',
                    'height',
                    'messure',
                    'format',
                    'printer',
                    'print_type',
                    'sqft_rate',
                    'copies',
                    'material',
                    'lamination',
                    'unit_price',
                    'total',
                    'finishing',
                    'job_type',
                    'job_ss',
                    'stock_product_category',
                    'stock_product',
                ];
                var job_list_data = [];
                var job_object = {};

                $.each(job_list, function(key, value) {
                    var id = keys[counter]
                    console.log("Counter")
                    console.log(counter)
                    job_object[id] = value

                    if (counter == 17) {
                        job_list_data.push(job_object)
                        job_object = {};
                        counter = -1;
                    }
                    counter++;
                });

                console.log("after");
                console.log(job_list_data);
                // Get Products List to JSON Object
                var products_list = $('input[name^="product_list_items"]').map(function() {
                      return $(this).val()
                }).get();

                counter = 0;
                var product_keys = [
                    'product',
                    'price',
                    'qty',
                    'description'
                ]
                var product_list = [];
                var product_object = {};

                $.each(products_list, function(key, value) {
                    if (product_keys[counter] == 'description') {
                        product_object[product_keys[counter]] = unescape(value)
                    } else {
                        product_object[product_keys[counter]] = value
                    }

                    if (counter == 3) {
                        product_list.push(product_object)
                        product_object = {};
                        counter = -1;
                    }
                    counter++;
                });

                // var $job_ss = $('.invoice_ss').css('background-image');
                // $job_ss = $job_ss.replace('url(','').replace(')','').replace(/\"/gi, "");

                // if ($job_ss == 'none') {
                //     $job_ss = null;
                // }

                $('#createjob > div').css('display', 'block');
                $('#createjob > span').css('display', 'none');

                // Sending Ajax Request
                $.ajax({
                    type: "POST",
                    url: "{{ config('app.url') }}/jobcard/edit/job",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'client_id': $client,
                        'client_note': $clientNote,
                        'designer': $designer,
                        'job_note': $jobNote,
                        'finish_date': $finish_date,
                        'finish_time': $finish_time,
                        'job_list': job_list_data,
                        'product_list': product_list,
                        'po_no': $poNo,
                        'id': {{ $job->id }},
                    },
                    success: function (response) {
                        // if (response.error) {
                        //     $.each(response.error, function (key, value) {
                        //         swal('Error', value[0], 'error');
                        //         return false;
                        //     });
                        //     return;
                        // }

                        // window.location.replace("{{ route('jobcard.index') }}/" + response.job_id);
                    },
                    error: function (error) {
                        swal('Error', 'Unable to update job, please try again later', 'error');
                    },
                    complete: function () {
                        $('#createjob > div').css('display', 'none');
                        $('#createjob > span').css('display', 'block');
                    }
                });
            });

            // Limit Finish Time for Saturdays
            $('#finish_date').on('change', function() {
                var $date = $(this).val();
                var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                var saturdayTimes = [
                    '8.00',
                    '8.30',
                    '9.00',
                    '9.30',
                    '10.00',
                    '10.30',
                    '11.00',
                    '11.30',
                    '12.00',
                    '12.30',
                ];

                var weekDayTimes = [
                    '8.00',
                    '8.30',
                    '9.00',
                    '9.30',
                    '10.00',
                    '10.30',
                    '11.00',
                    '11.30',
                    '12.00',
                    '12.30',
                    '13.00',
                    '13.30',
                    '14.00',
                    '14.30',
                    '15.00',
                    '15.30',
                    '16.00',
                    '16.30',
                    '17.00',
                    '17.30',
                    '18.00',
                    '18.30',
                ];

                var a = new Date($date);

                if (weekday[a.getDay()] == 'Saturday') {
                    $('#finish_time').empty();
                    $.each(saturdayTimes, function(key, value) {
                        var item = '<option value="{0}">{1}</option>'.format(value, value);

                        $('#finish_time').append(item);
                    });

                    $('#finish_time').val('{{ $job->finishing_time }}');
                    $('#finish_time').multiselect('rebuild');
                    return;
                }

                $('#finish_time').empty();
                $.each(weekDayTimes, function(key, value) {
                    var item = '<option value="{0}">{1}</option>'.format(value, value);

                    $('#finish_time').append(item);
                });


                $('#finish_time').val('{{ $job->finishing_time }}');
                $('#finish_time').multiselect('rebuild');
                console.log("Changed Times")
            });

            $('#finish_date').val('{{ $job->finishing_date }}');
            $('#finish_date').trigger('change');
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('printtype.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Utility Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Add New Print Types</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('printtype.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Print Type</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(Single Side)</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Short Code</label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control @error('slug') is-invalid @enderror" required>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(SS)</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Job Type</label>
                                        <select class="form-control @error('job_type') is-invalid @enderror" name="job_type" required>
                                            <option value="">-- Choose Job Type --</option>
                                            <option value="large_format">Large Format</option>
                                            <option value="document">Document</option>
                                        </select>
                                        @error('job_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Rate</label>
                                        <input type="number" min="0" step="0.1" name="rate" id="rate" value="{{ old('rate') }}" class="form-control @error('rate') is-invalid @enderror" required>
                                        @error('rate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(100.00)</span>
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

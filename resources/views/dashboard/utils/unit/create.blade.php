@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('unit.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Utility Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Add New Unit</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('unit.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Unit Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(Centimeter)</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="control-label">Unit</label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control @error('slug') is-invalid @enderror" required>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(cm)</span>
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

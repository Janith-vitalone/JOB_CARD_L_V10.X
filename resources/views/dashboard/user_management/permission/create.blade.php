@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('permission.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Permission Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Create new Permissions</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('permission.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(Designation Form)</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Form</label>
                                        <div class="multiselect_div">
                                            <select id="form" name="form" class="multiselect multiselect-custom @error('form') is-invalid @enderror" required>
                                                <option value="0">- Please Choose -</option>
                                                @foreach ($forms as $form)
                                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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

    @if (old('form'))
        <script>
            $('#form').val('{{ old("form") }}');
        </script>
    @endif

    <script>
        $('#form').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
    </script>
@endsection

@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('user-assign.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Assign user to Role',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Assign user Roles</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('user-assign.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select a User</label>
                                        <div class="multiselect_div">
                                            <select id="name" name="name" class="multiselect multiselect-custom @error('name') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for ="user_role" class="control-label">Select a Role</label>
                                        <div class="multiselect_div">
                                            <select id="role" name="role" class="multiselect multiselect-custom @error('role') is-invalid @enderror" required>
                                                <option value="0"> -Please Choose- </option>
                                                @foreach ($userRoles as $userRole )
                                                    <option value="{{ $userRole->id }}">{{ $userRole->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role')
                                            <span>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> <span>Assign</span></button>
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

    <script>
        $('#name').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        $('#role').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });
    </script>
@endsection

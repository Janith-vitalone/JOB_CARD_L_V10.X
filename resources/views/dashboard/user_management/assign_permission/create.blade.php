@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/multi-select/css/multi-select.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('assign-permission.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Assign Role Permissions',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Assign Role Permissions</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('assign-permission.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select a User Role</label>
                                        <div class="multiselect_div">
                                            <select id="role" name="role_id" class="multiselect multiselect-custom @error('role_id') is-invalid @enderror" required>
                                                <option value="0">- Please Choose -</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for ="user_role" class="control-label">Select a Permission</label>
                                        {{-- <div class="multiselect_div"> --}}
                                            <select id="permission" name="permission_id[]" class="ms @error('permission_id[]') is-invalid @enderror" required multiple>
                                                {{-- <option value="0" disabled>- Please Choose -</option> --}}
                                                <optgroup label="Permissions">
                                                    @foreach ($permissions as $permission )
                                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        {{-- </div> --}}
                                        @error('permission_id[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2"><i id="add" class="fa fa-plus"></i> <i id="loader" class="fa fa-spinner fa-spin" style="display: none;"></i> <span>Assign</span></button>
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
        $('#role').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        var perms = $('#permission').multiSelect({ selectableOptgroup: true });

        $('#role').on('change', function() {
            var roleId = $(this).val();

            $.ajax({
                type: "get",
                url: "{{ config('app.url') }}/assign-permission/get/role/" + roleId,
                beforeSend: function() {
                    $('#add').css('display', 'none');
                    $('#loader').css('display', 'inline-block');
                    $(':input[type="submit"]').prop('disabled', true);
                },
                success: function (response) {
                    $('#permission').multiSelect('deselect_all');
                    var permissions = [];

                    $.each(response.permissions, function(key, value) {
                        permissions.push("" + value.id + "");
                    })

                    $('#permission').multiSelect('select', permissions);
                    return false;
                },
                complete: function() {
                    $('#add').css('display', 'inline-block');
                    $('#loader').css('display', 'none');
                    $(':input[type="submit"]').prop('disabled', false);
                }
            });
        })
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('user.index'),
            'page' => 'Manage',
            'current_page' => 'Edit',
            'heading' => 'User Management',
        ]])

        <div class="row clearfix">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Users</h2>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                        </ul>
                    </div>
                    <div class="body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('user.update', ['id' => $user->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">First Name *</label>
                                        <input type="text" name="first_name" value="{{ $user->name }}" class="form-control @error('first_name') is-invalid @enderror" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Last Name *</label>
                                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control @error('last_name') is-invalid @enderror" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Gender *</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender" required>
                                            <option value="">-- Select Gender --</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Designation *</label>
                                        <select class="form-control @error('designation') is-invalid @enderror" @if(Auth::user()->userRoles[0]->slug != 'super_admin') disabled @endif name="designation" id="designation" required>
                                            <option value="">-- Select Designation --</option>
                                        </select>
                                        @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Birthday *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                                            </div>
                                            <input data-provide="datepicker" value="{{ $user->dob }}" name="dob" data-date-format="yyyy-mm-dd" data-date-autoclose="true" class="form-control @error('dob') is-invalid @enderror" required>
                                            @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Contact No *</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="contact_no" value="{{ $user->contact_no }}" class="form-control phone-number @error('contact_no') is-invalid @enderror" placeholder="Ex: 07x xxx xxxx" required>
                                            @error('contact_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email *</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" required disabled>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="{{ $user->avatar }}" name="old_avatar" />
                            <input type="file" class="d-none @error('avatar') is-invalid @enderror" name="avatar" id="avatarfile" />

                            <button type="submit" class="btn btn-primary">Update User Info</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>User Avatar</h2>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 text-center">
                                <div class="avatar-wrapper">
                                    <img src="{{ url('/assets/avatars/') }}/{{ $user->avatar }}" id="avatar" class="img-fluid rounded">
                                    <div class="camera-overlay text-center">
                                        <i class="icon-camera"></i>
                                    </div>
                                </div>

                                @error('avatar')
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Change Password</h2>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                        </ul>
                    </div>
                    <div class="body">
                        <form method="POST" action={{ route('change.password', ['id' => $user->id]) }}>
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Old Password *</label>
                                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">New Password *</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Confirm Password *</label>
                                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

    <style>
        #avatar {
            max-width: 256px;
            max-height: 256px;
        }

        .camera-overlay {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            font-size: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #00000000;
            color: transparent;
            cursor: pointer;
            transition: background-color 0.5s ease;
            transition: color 0.5s ease;
        }

        .camera-overlay:hover {
            background-color: #00000094;
            color: white;
        }

        .avatar-wrapper {
            position: relative;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script><!-- Input Mask Plugin Js -->
    <script src="{{ asset('assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $('#gender').val('{{ $user->gender }}');
    </script>

    <script>
        $.ajax({
            type: "get",
            url: "{{ config('app.url') }}/designation/get/all",
            contentType: "application/json",
            success: function (response) {
                $('#designation').empty();

                $.each(response.data, function(key, value) {
                    var item = '<option value="' + value.id + '">' + value.name + '</option>';
                    $('#designation').append(item);
                });

                $('#designation').val('{{ $user->designation_id }}');
            }
        });

        $('.camera-overlay').on('click', function() {
            $('#avatarfile').click();
        })

        $("#avatarfile").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection

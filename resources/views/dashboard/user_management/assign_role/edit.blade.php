@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
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
                
                                <form action="{{ route('user-assign.update',$userHasRole[0]->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select a User</label>
                                        
                                        <select name="name" id="name" class="form-control @error('name') is-invalid @enderror" required disabled>
                                            <option value="0"> -Please Choose- </option>
                                            
                                                @foreach ($users as $user )
                                                    
                                                    @if($userHasRole[0]->userRoles[0]->pivot->user_id === $user->id )
                                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                    @else
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endif
                                                    
                                                @endforeach    
                                        </select>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for ="user_role" class="control-label">Select a Role</label>
                                        <select name="role" id="role" class="form-control @error('role') id-invalid @enderror" required>
                                            <option value="0"> -Please Choose- </option>
                                            @foreach ($userRoles as $userRole )

                                                @if($userHasRole[0]->userRoles[0]->pivot->user_role_id === $userRole->id )
                                                <option value="{{ $userRole->id }}" selected>{{ $userRole->name }}</option>
                                                @else
                                                <option value="{{ $userRole->id }}">{{ $userRole->name }}</option>
                                                @endif
                                                
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <span>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-secondary  mb-2"><i class="fa fa-plus"></i> <span>Update</span></button>
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
<script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
<script>
    $('#name').select2();
    $('#role').select2();
</script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('lamination.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Utility Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Update Lamination</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('lamination.update', $lamination->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Lamination</label>
                                        <input type="text" name="name" id="name" value="{{ $lamination->name }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(Flex)</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Rate</label>
                                        <input type="text" name="rate" id="rate" value="{{ $lamination->rate }}" class="form-control @error('rate') is-invalid @enderror" required>
                                        @error('rate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="help-block">(1000.00)</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Job Type</label>
                                        <select class="form-control @error('job_type') is-invalid @enderror" name="job_type" id="job_type" required>
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
                                        <label for="phone" class="control-label">Format</label>
                                        <select class="form-control @error('job_type') is-invalid @enderror" name="format" id="format" required>
                                            <option value="">-- Choose Format --</option>
                                        </select>
                                        @error('format')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-secondary mb-2"><span>Update</span></button>
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
    <script>
        $(document).ready(function() {
            $('#job_type').val('{{ $lamination->job_type }}');
            getFormats('{{ $lamination->job_type }}');

            $('#job_type').on('change', function() {
                var type = $(this).val();

                if (type == '') {
                    return;
                }

                getFormats(type)
            });

            function getFormats(type) {
                $.ajax({
                    type: "get",
                    url: "{{ config('app.url') }}/format/get/jobtype/" + type,
                    success: function (response) {
                        if (!response.error) {
                            var data = response.data;

                            $('#format').empty();
                            $('#format').append('<option value="">-- Choose Format --</option>');

                            $.each(data, function(key, value) {
                                var item = '<option value="{0}">{1}</option>'.format(value.id, value.name);
                                $('#format').append(item);
                            });

                            $('#format').val('{{ $lamination->format_id }}')

                            return false;
                        }

                        alert('Cannot get Formats');
                    },
                    error: function (error) {
                        alert('Cannot get Formats');
                    }
                });
            }

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

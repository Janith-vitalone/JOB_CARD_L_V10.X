@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/multi-select/css/multi-select.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => route('printermaterial.index'),
            'page' => 'Manage',
            'current_page' => 'Create',
            'heading' => 'Utility Management',
        ]])

        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Assign Printer Materials</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{ route('printermaterial.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user" class="control-label">Select a Printer</label>
                                        <div class="multiselect_div">
                                            <select id="printer" name="printer_id" class="multiselect multiselect-custom @error('printer_id') is-invalid @enderror" required>
                                                <option value="0">- Please Choose -</option>
                                                @foreach ($printers as $printer)
                                                    <option value="{{ $printer->id }}">{{ $printer->name }}</option>
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
                                        <label for ="materials_id" class="control-label">Select a Materials</label>
                                        <select id="materials" name="materials_id[]" class="ms @error('materials_id[]') is-invalid @enderror" required multiple>
                                            <optgroup label="Materials">
                                                @foreach ($materials as $material )
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        @error('materials_id[]')
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
        $('#printer').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200
        });

        var perms = $('#materials').multiSelect({ selectableOptgroup: true });

        $('#printer').on('change', function() {
            var printerId = $(this).val();

            $.ajax({
                type: "get",
                url: "{{ config('app.url') }}/printermaterial/get/material/" + printerId,
                beforeSend: function() {
                    $('#add').css('display', 'none');
                    $('#loader').css('display', 'inline-block');
                    $(':input[type="submit"]').prop('disabled', true);
                },
                success: function (response) {
                    $('#materials').multiSelect('deselect_all');
                    var materials = [];

                    $.each(response.materials, function(key, value) {
                        materials.push("" + value.id + "");
                    })

                    $('#materials').multiSelect('select', materials);
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

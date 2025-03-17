@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title', 'Add Invoice')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoices</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add invoice</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('Add Invoice')
                        <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                            autocomplete="off">
                            {{ csrf_field() }}
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Invoice Number</label>
                                    <input type="text" class="form-control" id="inputName" name="invoice_number"
                                        title="Please enter invoice number" required>
                                </div>
                                <div class="col">
                                    <label>Invoice Date</label>
                                    <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                        type="text" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col">
                                    <label>Due Date</label>
                                    <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                        type="text" required>
                                </div>
                            </div>

                            {{-- 2 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Sections</label>
                                    <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')">
                                        <!--placeholder-->
                                        <option value="" selected disabled>select section</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Products</label>
                                    <select id="product" name="product" class="form-control">
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="inputName" class="control-label">Collection Amount</label>
                                    <input type="text" class="form-control" id="amount_collection" name="amount_collection"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>
                            {{-- 3 --}}
                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">Commission Amount</label>
                                    <input type="text" class="form-control form-control-lg" id="amount_commission"
                                        name="amount_commission" title="Please enter commission amount "
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Discount</label>
                                    <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                        title="Please enter discount amount "
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        value=0 required>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">VAT rate</label>
                                    <select name="rate_vat" id="rate_vat" class="form-control SlectBox" onchange="myFunction()">
                                        <!--placeholder-->
                                        <option value="" selected disabled>Specify the tax rate</option>
                                        <option value=" 5%">5%</option>
                                        <option value="10%">10%</option>
                                    </select>
                                </div>
                            </div>
                            {{-- 4 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">Value added tax value</label>
                                    <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">Total including tax</label>
                                    <input type="text" class="form-control" id="total" name="total" readonly>
                                </div>
                            </div>
                            {{-- 5 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="exampleTextarea">Notes</label>
                                    <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                                </div>
                            </div><br>

                            <p class="text-danger"> Attachment format pdf, jpeg ,.jpg , png * </p>
                            <h5 class="card-title">Attachment</h5>
                            <div class="col-sm-12 col-md-12">
                                <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                    data-height="70" />
                            </div><br>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Save Data</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        $(document).ready(function () {
            $('select[name="Section"]').on('change', function () {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('sections') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="product"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
    <script>
        function myFunction() {
            var amount_commission = parseFloat(document.getElementById("amount_commission").value);
            var discount = parseFloat(document.getElementById("discount").value);
            var rate_vat = parseFloat(document.getElementById("rate_vat").value);
            var value_vat = parseFloat(document.getElementById("value_vat").value);

            var Amount_Commission2 = amount_commission - discount;
            if (typeof amount_commission === 'undefined' || !amount_commission) {
                alert('Please enter the commission amount ');
            } else {
                var intResults = Amount_Commission2 * rate_vat / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("value_vat").value = sumq;

                document.getElementById("total").value = sumt;
            }
        }
    </script>
@endsection
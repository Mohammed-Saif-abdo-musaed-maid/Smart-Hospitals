<!doctype html>
@php
\App::setLocale(Session::get('locale'));
$app_locale = \App::getLocale();
$is_rtl = ($app_locale === 'ar');
@endphp
<html lang="{{ $app_locale }}" dir="{{ $is_rtl ? 'rtl' : 'ltr' }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/af9fc7310f.js"></script>

    <title>{{ __('Print Attendance') }}</title>

    @if($is_rtl)
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif

    <style>
        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <button onclick="window.history.back()" class="mt-5 btn-sm btn btn-success no-print"><i
                            class="fa fa-arrow-left"></i> {{ __('Back') }}
                    </button>
                    <button onclick="window.print()" class="mt-5 btn-sm btn btn-warning no-print">{{ __('Print') }} <i
                            class="fas fa-print"></i></button>
                    <button onclick="HTMLtoPDF()" class="mt-5 btn-sm btn btn-danger no-print">{{ __('Download PDF') }}</button>
                </div>
            </div>
            <br>

            <div class="box" id="HTMLtoPDF">
                <h2 align="center">{{ __('CENTRAL HOSPITAL OF AYRVEDA') }}</h2>
                <h4 align="center">{{ __('Attendance Report') }}</h4>

                <br>
                <label>{{ __('Date :') }} @php echo date('Y/m/d'); @endphp</label>
                <br>
                <br>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Attend Dates') }}</th>
                                    <th scope="col">{{ __('Short Leave') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $result)
                                <tr>
                                    <td>{{$result->name}}</td>
                                    <td>{{$result->type}}</td>
                                    <td>{{$result->attended}}</td>
                                    <td>{{$result->shortleave}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Attend Dates') }}</th>
                                <th>{{ __('Short Leave') }}</th>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <br>
                <label>{{ __('Made By :') }} {{$title}}</label>
                <div align="right">
                    <label style="display:block">...............................................................</label>
                    <label>{{ __('Sighned By , Officer') }}</label>
                </div>
                <br>
                <br>
            </div>
        </section>
    </div>
    <script src="js/pdf_js/jspdf.js"></script>
    <script src="js/pdf_js/jquery-2.1.3.js"></script>
    <script src="js/pdf_js/pdfFromHTML.js"></script>
</body>

</html>

@extends('template.main')

@section('title', $title)

@section('content_title',__("In Patients"))
@section('content_description',__("Details About Admitted & Discharged Patients"))

@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>{{ __('Dashboard') }}</a></li>
    <li class="active">{{ __('Here') }}</li>
</ol>
@endsection

@php
use App\Patients;
@endphp
@section('main_content')

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Search Options') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="GET" action="{{route('inPatientReportData')}}">
                    <label for="">{{ __('Pick a Date') }}</label>
                    <div class="input-group input-group-sm">
                        <input @if($date!=null) value="{{$date}}" @endif type="date" required max="{{date('Y-m-d')}}" name="date" id="date" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">{{ __('Go!') }}</button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        {{-- @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{session()->get('success')}}
        </div>
        @endif --}}
        @if (session()->has('fail'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> {{ __('Sorry!') }}</h4>

            {{session()->get('fail')}}
        </div>
        @endif
    </div>
    <div class="col-md-1"></div>
</div>
@if($data_count!=0)
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Search Results') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>{{ __('Patient') }}</th>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Admit Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Discharged Date') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rec)
                                    <tr>
                                        <td>{{Patients::find($rec->patient_id)->name}}</td>
                                        <td>{{$rec->patient_id}}</td>
                                        <td>{{explode(" ",$rec->created_at)[0]}}</td>

                                        @if ($rec->discharged_date==null)
                                        <td>{{ __('Not Discharged') }}</td>
                                        @else
                                        <td>{{ __('Discharged') }}</td>
                                        @endif

                                        @if ($rec->discharged_date!=null)
                                        <td>{{explode(" ",$rec->discharged_date)[0]}}</td>
                                        @else
                                        <td>
                                            {{ __('Not Found') }}
                                        </td>

                                        @endif


                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th>{{ __('Patient') }}</th>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Admit Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Discharged Date') }}</th>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>


    </div>
    <div class="col-md-1"></div>
</div>
@endif

@endsection

@section('optional_scripts')
<script>
    $(function () {

        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

</script>

@endsection

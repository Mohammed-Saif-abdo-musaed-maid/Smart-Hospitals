@extends('template.plain')
@section('content_title')
{{ __('Patient Treatment History') }}
@endsection
@section('title', $title)
@php
use App\Medicine;
use App\Clinic;
@endphp
@section('sidebar_content')

@foreach ($prescs as $presc)
<li>
<a href="#presc{{$presc->id}}">
    <i class="fas fa-history"></i>
         <span>
            &nbsp; {{explode(" ",$presc->created_at)[0]}}
        </span>
    </a>
</li>
@endforeach



@endsection

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">{{ucwords($patient->name)}}</h3>
                <h5 class="widget-user-desc">ID : {{$patient->id}}</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" height="128px" width="128px" src="{{Storage::url($patient->id . ".png")}}"
                    alt="User Avatar">
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><span class="@if($status=='Active') text-green @else
                                    text-danger @endif">{{$status}}</span></h5>
                            <span class="description-text">{{ __('Status') }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{$hospital_visits}}</h5>
                            <span class="description-text">{{ __('HOSPITAL VISITS') }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <div class="description-block">
                            <h5 class="description-header">{{$last_seen}}</h5>
                            <span class="description-text">{{ __('LAST VISIT') }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->

    </div>

</div>

@if ($clinics=$patient->clinics->count()>0)
<div class="row mb-4">
    <div class="col-md-12">
        <h3>{{ __('Attending Clinics') }}</h3>
        @foreach ($patient->clinics as $clinic)
        <span style="display:inline-block;font-size:15px" class="mt-2 mb-2 badge bg-navy">{{$clinic->name_eng}}</span>
        @endforeach
    </div>
</div>
@endif


<div class="row">
    <div class="col-md-12">
        @foreach ($prescs as $presc)
        <div id="presc{{$presc->id}}" class="box box-success collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Visit On') }} ({{explode(" ",$presc->created_at)[0]}})</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="display:none">

                @php

                $pres_med=json_decode($presc->medicines);
                $bp=json_decode($presc->bp);
                $cholestrol=json_decode($presc->cholestrol);
                $sugar=json_decode($presc->blood_sugar);
                @endphp

                <h4>{{ __('Diagnosis') }}</h4>
                <p class="text-primary" style="font-size:17px;font-weight:600">{{$presc->diagnosis}}</p>

                <h4>{{ __('Blood Pressure') }}</h4>
                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{$bp->value}}<small> ({{ __('Updated') }}
                        {{explode(" ",$bp->updated)[0]}})</small></h5>

                <h4>{{ __('Blood Sugar') }}</h4>
                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{$sugar->value}}<small> ({{ __('Updated') }}
                        {{explode(" ",$sugar->updated)[0]}})</small></h5>

                <h4>{{ __('Blood Cholestrol') }}</h4>
                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{$cholestrol->value}}<small> ({{ __('Updated') }}
                        {{explode(" ",$cholestrol->updated)[0]}})</small></h5>

                <h4>{{ __('Issued Medicines') }}</h4>
                <ul style="font-size:16px">
                    @foreach($pres_med as $med)
                    <li>
                        {{ucwords($med->name)}}({{Medicine::where('name_english',$med->name)->first()->name_sinhala}})
                    </li>
                    <ul>
                        <li> {{$med->note}} </li>
                    </ul>
                    @endforeach
                </ul>



            </div>

        </div>
        @endforeach

    </div>
</div>

@endsection
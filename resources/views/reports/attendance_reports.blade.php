@extends('template.main')

@section('title', $title)

@section('content_title',__("Attendance Report"))
@section('content_description',__("Generate Your Report Here..."))
@section('breadcrumbs')

    <ol class="breadcrumb">
        <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>{{ __('Dashboard') }}</a></li>
        <li class="active">{{ __('Here') }}</li>
    </ol>
@endsection

@section('main_content')
    <?php $user = Auth::user();
    $name = $user->name;
    $user_type = $user->user_type;
    $image_path = $user->img_path;
    $outlet = 'مستشفى الشفاء'?>

    <section class="content">

        <div class="box box-danger">

            <div class="box-header with-border">

                <h3 class="box-title">{{ __('Enter Details :-') }}</h3>

            </div>
            <!-- /.box-header -->

            <form method="post" action="{{ route('gen_att_reports') }}">
                {{csrf_field()}}
                <div class="box-body" style="">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>{{ __('Select Attendeance Type') }}</label>
                                    <select class="form-control" style="width: 100%;" name="type" data-select2-id="1"
                                            tabindex="-1" aria-hidden="true">
                                        <option selected="selected" value="My Attendance" data-select2-id="3">{{ __('My Attendance') }}</option>
                                        <option value="All">{{ __('All') }}</option>
                                        <option value="Doctors">{{ __('Doctors') }}</option>
                                        <option value="General Staff">{{ __('General Staff') }}</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>{{ __('Starting Date:') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" name="start"
                                               placeholder="{{ __('Enter date') }}">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Ending Date:') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" name="end"
                                               placeholder="{{ __('Enter date') }}">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                            </div>

                            <div class="form-group">
                                <input type="submit" value="{{ __('Get Report') }}" class="btn btn-warning pull-right">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </form>

        </div>


    </section>

    <script>
        $(function () {
            $('input[name="start"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            });
        });
        $(function () {
            $('input[name="end"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
            });
        });
    </script>

@endsection

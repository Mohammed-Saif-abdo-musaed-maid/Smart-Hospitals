@extends('template.main')

@section('title', $title)

@section('content_title',__("Notices"))
@section('content_description',__("Send Notices & Push General Notices To Noticeboard"))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>{{ __('Dashboard') }}</a></li>
    <li class="active">{{ __('Here') }}</li>
</ol>
@endsection

@section('main_content')
<?php $user = Auth::user();
$name = $user->name;
$user_type =$user->user_type;
$image_path =$user->img_path;
$outlet = 'مستشفى الشفاء'?>

<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

                    <li class="@if (!session('success')&&!session('unsuccess')||session('successnotice')) active @endif">
                        <a href="#activity" data-toggle="tab"
                            aria-expanded="@if (!session('unsuccess')&&!session('success')||session('successnotice')) true @else false @endif">{{ __('Add Notice') }}</a>
                    </li>

                    <li class="@if (session('success')||session('unsuccess')) active @endif">
                        <a href="#settings" data-toggle="tab"
                            aria-expanded="@if (session('success') ||session('unsuccess')) true @else false @endif">{{ __('Send Notice') }}</a>
                    </li>


                </ul>

                <div class="tab-content">

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="tab-pane @if (!session('unsuccess')&&!session('success')||session('successnotice')) active @endif"
                        id="activity">
                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        @if (session('successnotice'))
                                        <div class="alert alert-success">
                                            {{ session('successnotice') }}
                                        </div>
                                        @endif
                                        <div class="col-md-10">
                                            <br>
                                            <form class="form-inline" method="POST" action="{{route('addnotice')}}">
                                                @csrf
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control" name="subject"
                                                        placeholder="{{ __('enter subject') }}">
                                                </div>
                                                <div class="form-group mx-sm-3 mb-2">
                                                    <input type="text" class="form-control" name="description"
                                                        placeholder="{{ __('enter description') }}">
                                                </div>
                                                <button type="submit" class="btn btn-warning mb-2">{{ __('Add') }}</button>
                                            </form>
                                        </div>
                                        <div class="col-md-2"></div>

                                        <div class="col-sm-12">
                                            <br>
                                            <table id="example1" class="table table-bordered table-striped dataTable"
                                                role="grid" aria-describedby="example1_info">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Subject') }}</th>
                                                        <th>{{ __('Description') }}</th>
                                                        <th>{{ __('Created At') }}</th>
                                                        <th>{{ __('Action') }}</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($notices as $app)
                                                    <tr>
                                                        <td>{{$app->subject}}</td>
                                                        <td>{{$app->description}}</td>
                                                        <td>{{$app->time}}</td>
                                                        <td>
                                                            <form action="{{route('deletenotice')}}" method="post">
                                                                @csrf
                                                                <input type="text" style="display:none" name="id"
                                                                    value="{{$app->id}}">
                                                                <button type="submit" class="btn-sm btn-danger"><i
                                                                        class="fa fa-trash">
                                                                        {{ __('Delete') }}</i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <th>{{ __('Subject') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Created At') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane @if (session('success') ||session('unsuccess')) active @endif" id="settings">
                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body">

                                {{--  display validattion errors  --}}

                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                @if (session('unsuccess'))
                                <div class="alert alert-danger">
                                    {{ session('unsuccess') }}
                                </div>
                                @endif
                                <form role="form" method="post" action="{{ route('sendnotice') }}">

                                    {{csrf_field()}}

                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>{{ __('Enter your Message') }}</label>
                                        <textarea class="form-control" name="message" rows="5"
                                            placeholder="{{ __('Enter Message') }}" required></textarea>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-2">
                                            <label>{{ __('Select Method :') }}</label>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="checkbox" >
                                                <label>
                                                    <input type="checkbox" name="emails" value="email"> {{ __('Emails') }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="sms" value="sms"> {{ __('SMS') }}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label>{{ __('Select Receivers :') }}</label>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="receiverlist[]" value="admin"> {{ __('Admin') }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="receiverlist[]" value="doctor"> {{ __('Doctor') }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="receiverlist[]" value="general"> {{ __('Staff') }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="receiverlist[]" value="pharmacist">
                                                    {{ __('Pharmasist') }}
                                                </label>
                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group col-md-2 pull-right">
                                        <input type="submit" class="btn btn-danger btn-lg" name="send" value="{{ __('Send') }}">
                                    </div>

                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->

        <div class="col-md-3">

        </div>
        <!-- /.col -->
    </div>


</section>


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

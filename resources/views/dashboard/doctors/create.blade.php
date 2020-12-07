@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.doctors')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.doctors.index')}}">@lang('site.doctors')</a></li>
                    <li class="active">@lang('site.add')</li>

                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">@lang('site.add')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')
                        <form action="{{route('dashboard.doctors.store')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            <div class="form-group">
                                <label>@lang('site.name')*</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.username')*</label>
                                <input type="text" name="username" class="form-control" value="{{old('username')}}">
                            </div>


                            <div class="form-group">
                                <label>@lang('site.email')*</label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.password')*</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.password_confirmation')*</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.phone') *</label>
                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                            </div>

                            {{-- <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <select name="active" class="form-control">
                                    <option value="1" selected>@lang('site.is_active')</option>
                                    <option value="0">@lang('site.not_active')</option>
                                </select>
                            </div> --}}

                            <input type="hidden" name="active" value="0">

                            <div class="form-group">
                                <label>@lang('site.active')*</label>
                                <div class="custom-control custom-switch material-switch">
                                        <input type="checkbox" name="active" class="custom-control-input" id="doctorSwitch"
                                        onchange="this.checked? this.value = 1 : this.value = 0">
                                        <label class="custom-control-label" for="doctorSwitch"></label>
                                </div>
                            </div>

                            <input type="hidden" name="account_confirm" value="0">



                            {{--
                            <div class="form-group">
                                <label>@lang('site.permissions')</label>
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    @php
                                        $models = ['admins', 'doctors', 'students', 'subjects','lessons', 'assignments','regist','stdassign'];
                                        $maps   = ['create', 'read', 'update', 'delete'];
                                    @endphp
                                    <ul class="nav nav-tabs">
                                        @foreach ($models as $index=>$model)
                                            <li class="{{ $index == 0? 'active' : ''}}"><a href="#{{$model}}" data-toggle="tab">@lang('site.' .$model)</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($models as $index=>$model)
                                            <div class="tab-pane {{ $index == 0? 'active' : ''}}" id="{{$model}}">
                                                @foreach ($maps as $map)
                                                    <label><input type="checkbox" name="permissions[]" value="{{$map. '_' .$model}}"> @lang('site.' .$map) </label>
                                                @endforeach
                                            </div>
                                            <!-- /.tab-pane -->
                                        @endforeach
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                            <!-- nav-tabs-custom -->
                            </div><!--end of form group-->
                            --}}


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                            </div>
                        </form>
                    </div><!--end of box-body-->

                </div>

            </section>
        </section>


    </div>

@endsection

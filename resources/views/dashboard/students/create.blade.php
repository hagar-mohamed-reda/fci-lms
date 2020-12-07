@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content container-fluid">
            <section class="content-header">
                <h1>@lang('site.students')</h1>
                <ol class="breadcrumb">
                    <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li> <a href=" {{route('dashboard.students.index')}}">@lang('site.students')</a></li>
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
                        <form action="{{route('dashboard.students.store')}}" method="POST" enctype="multipart/form-data">
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
                                <label>@lang('site.level')*</label>
                                <select name="level_id" class="form-control select2-js" id="levels">
                                    <option value="">@lang('site.level')</option>
                                    @foreach ($levels as $level)
                                        <option value="{{$level->id}}" {{old('level_id') == $level->id ? 'selected' : ''}}>{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group">
                                <label>@lang('site.department')*</label>
                                <select name="department_id" class="form-control">
                                    <option value="">@lang('site.department')</option>
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}" {{old('department_id') == $department->id ? 'selected' : ''}}>
                                            {{$department->name}}-{{$department->level['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            @foreach ($departments as $department)
                            <input id="hiddeparts" type="hidden" name="" data-id="{{$department->id}}" data-name="{{$department->name}}" data-level="{{$department->level_id}}">
                            @endforeach
                            @foreach ($levels as $level)
                            <input id="hidlevels" type="hidden" name="" data-id="{{$level->id}}" data-name="{{$level->name}}">
                            @endforeach

                            <div class="form-group">
                                <label>@lang('site.department')*</label>
                                <select name="department_id" class="form-control  select2-js" id="departs">
                                    <option value="">@lang('site.department')</option>
                                    @foreach ($departments as $department)
                                        <option class="departoption" style="display: none" data-level="{{$department->level_id}}" value="{{$department->id}}" {{old('department_id') == $department->id ? 'selected' : ''}}>
                                            {{$department->name}}-{{$department->level['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label>@lang('site.code')*</label>
                                <input type="text" name="code" class="form-control" value="{{old('code')}}">
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
                                <label>@lang('site.phone')*</label>
                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.set_number')*</label>
                                <input type="text" name="set_number" class="form-control" value="{{old('set_number')}}">
                            </div>

                            <div class="form-group">
                                <label>@lang('site.national_id')*</label>
                                <input type="text" name="national_id" class="form-control" value="{{old('national_id')}}">
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
                                        <input type="checkbox" name="active" class="custom-control-input" id="studentSwitch"
                                        onchange="this.checked? this.value = 1 : this.value = 0">
                                        <label class="custom-control-label" for="studentSwitch"></label>
                                </div>
                            </div>

                            <input type="hidden" name="account_confirm" value="0">
                            <input type="hidden" name="graduated" value="0">
                            <input type="hidden" name="can_see_result" value="0">



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

@section('scripts')
<script>
    $("#levels").change(function(){
        $.ajax({
            url: "{{ route('departs.get_by_level') }}?level_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#departs').html(data.html);
            }
        });
    });
</script>

@endsection

@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">
    <section class="content container-fluid">
        <section class="content-header">
            <h1>@lang('site.assign_doc')</h1>
            <ol class="breadcrumb">
                <li><a href=" {{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li> <a href=" {{route('dashboard.subjects.index')}}">@lang('site.subjects')</a></li>
                <li class="active">@lang('site.assign_doc')</li>

            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">
                            @foreach ($docSubjects as $index=>$docSubject)
                            @if ($docSubject->subjects['id'] == $_GET['sbj_id'])
                            {{$docSubject->subjects['name']}} =>
                            @endif
                            @endforeach
                        </h3>
                        <h3 class="box-title">@lang('site.assign_doc')</h3>
                    </div>

                    <div class="box-body">
                        @include('partials._errors')
                        <form action="{{route('dashboard.doctor_courses.store')}}"  method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('post') }}

                            <input type="hidden" name="course_id" value={{$_GET['sbj_id']}}>

                            <div class="form-group">
                                <label>@lang('site.sbj_doc')*</label>
                                <select name="doctor_id" class="form-control select2-js">
                                    <option value="">@lang('site.doctors')</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{$doctor->id}}" {{old('doctor_id') == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                            </div>
                        </form>
                    </div><!--end of box-body-->

                </div>
            </div>

            <div class="row">
                <h3>@lang('site.subjs_assigned_to_doctors')</h3>

                <div class="box box-primary">



                    <div class="box-body">
                        @include('partials._errors')
                        @if ($docSubjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="docSbjTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                        <th>@lang('site.action')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docSubjects as $index=>$docSubject)

                                        @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                        <tr>
                                            {{-- <td>{{ $index + 1}}</td> --}}
                                            <td>{{ $docSubject->doctors['name']}}</td>
                                            <td>{{ $docSubject->subjects['name']}}</td>
                                            {{--<td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                                {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                            </td>--}}
                                            <td>
                                                {{--@if (auth()->user()->hasPermission('update_regist'))
                                                    <a href=" {{ route('dashboard.student_subjects.edit', $docSubject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                                @endif--}}
                                                @if (auth()->user()->hasPermission('delete_regist'))
                                                    <form action="{{route('dashboard.doctor_courses.destroy', $docSubject->id)}}" method="POST" style="display: inline-block">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete')}}
                                                        <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- {{$docSubjects->appends(request()->query())->links()}} --}}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div><!--end of box-body-->

                </div>
            </div>


        </section>
    </section>


</div>

@endsection
@section('scripts')
<script>
    $(function(){
        $('#docSbjTable').DataTable({
            'order': [[ 1, 'desc' ]],
            "dom" : 'lBfrtip',
         "buttons" : [
            'copy', 'csv', 'excel', 'pdf','print',
            ]
        });
    });

</script>
@endsection

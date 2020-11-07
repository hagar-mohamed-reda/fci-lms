@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.student_assignments')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.student_assignments')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.student_assignments') {{--<small>{{$subjects->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.student_assignments.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>
                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <div class="col-md-4">
                                    <select name="doc_id" class="form-control select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <select name="lesson_id" class="form-control select2-js">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->doc_id == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                            @endif
                                            @if (auth()->user()->hasRole('student'))
                                                @foreach ($stdSbs as $stdSb)
                                                @if($stdSb->subject_id == $subject->id && $stdSb->student_id == auth()->user()->fid)
                                                <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                                @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="lesson_id" class="form-control select2-js">
                                        <option value="">@lang('site.lessons')</option>
                                        @foreach ($lessons as $lesson)
                                            @if ($lesson->doc_id == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$lesson->id}}" {{request()->lesson_id == $lesson->id ? 'selected' : ''}}>{{$lesson->name}}</option>
                                            @endif
                                            @if (auth()->user()->hasRole('student'))
                                                @foreach ($stdSbs as $stdSb)
                                                @if($stdSb->subject_id == $lesson->sbj_id && $stdSb->student_id == auth()->user()->fid)
                                                <option value="{{$lesson->id}}" {{request()->lesson_id == $lesson->id ? 'selected' : ''}}>{{$lesson->name}}</option>
                                                @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select name="assign_id" class="form-control select2-js">
                                        <option value="">@lang('site.assignments')</option>
                                        @foreach ($assignments as $assignment)
                                        @if ($assignment->doc_id == auth()->user()->fid || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('student'))
                                            <option value="{{$assignment->id}}" {{request()->assign_id == $assignment->id ? 'selected' : ''}}>{{$assignment->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    {{--@if (auth()->user()->hasPermission('create_stdassign'))
                                        <a href=" {{route('dashboard.student_assignments.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif--}}


                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($stdAssignments->count() > 0)
                            <table class="table table-hover" id="stdassigntable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.assign_name')</th>
                                        <th>@lang('site.pdf_anss')</th>
                                        <th>@lang('site.date')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stdAssignments as $index=>$stdAssignment)
                                    @if ($stdAssignment->doc_id == auth()->user()->fid && auth()->user()->type == 'doctor' || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin')
                                    <tr>
                                        <td>{{ $stdAssignment->id}}</td>
                                        <td>{{ $stdAssignment->students['name']}}</td>
                                        <td>{{ $stdAssignment->assignments['name']}}</td>
                                        <td>
                                            {{--<a href="student_assignments/pdffiles/{{$stdAssignment->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                            <a href="student_assignments/pdffile/download/{{$stdAssignment->pdf_anss}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        {{--<td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                            {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                        </td>--}}
                                        @if ($stdAssignment->assignments['end_date'] > $stdAssignment->created_at)
                                            <td style="color: green">{{ $stdAssignment->created_at}}</td>
                                        @else
                                            <td style="color: red">{{ $stdAssignment->created_at}} @lang('site.after_date')</td>
                                        @endif
                                        <td>
                                            {{--@if (auth()->user()->hasPermission('update_stdassign'))
                                                <a href=" {{ route('dashboard.student_assignments.edit', $stdSubject->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif--}}
                                            @if (auth()->user()->hasPermission('delete_stdassign'))
                                                <form action="{{route('dashboard.student_assignments.destroy', $stdAssignment->id)}}" method="POST" style="display: inline-block">
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
                            {{$stdAssignments->appends(request()->query())->links()}}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>



@endsection

@section('scripts')
<script>
    $(function(){
        $('#stdassigntable').DataTable({
         "pageLength": 10,

        });
    });

</script>
@endsection

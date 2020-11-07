@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.lessons')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.lessons')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.lessons') {{--<small>{{$lessons->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.lessons.index')}}" method="GET">
                            <div class="row">
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
                                    <select name="sbj_id" class="form-control select2-js">
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
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                    @foreach ($lessons as $lesson)

                                    @endforeach
                                    {{--@if (auth()->user()->hasPermission('create_lessons'))
                                        <a href=" {{route('dashboard.lessons.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif--}}


                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($lessons->count() > 0)
                            <table class="table table-hover" id="lessonTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.youtube_link')</th>
                                        <th>@lang('site.pdf_file')</th>
                                        <th>@lang('site.pptx_file')</th>
                                        <th>@lang('site.assignments') </th>

                                        @if(auth()->user()->hasRole('doctor'))
                                        <th>@lang('site.action')</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lessons as $index=>$lesson)
                                    @if ($lesson->doc_id == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                    <tr>
                                        <td>{{ $lesson->id}}</td>
                                        <td>{{ $lesson->name}}</td>
                                        <td>{{ $lesson->subject['name']}}</td>
                                        <td><a class="btn btn-warning btn-sm" href="{{$lesson->youtube_link}}" target="_blank">go</a></td>
                                        <td>
                                                {{--<a href="lessons/pdffiles/{{$lesson->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                                <a href="lessons/pdffile/download/{{$lesson->pdf_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>

                                        </td>
                                        <td>
                                            <a href="lessons/pptxfile/download/{{$lesson->pptx_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        <td>
                                            {{ $lesson->assignments->count()}} <a href="{{route('dashboard.assignments.index', ['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id ])}}" class="btn btn-success btn-sm">@lang('site.show_lesson_assignments')</a>
                                            @if (auth()->user()->hasPermission('create_assignments'))
                                                <a href=" {{route('dashboard.assignments.create',['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> @lang('site.add_assignment')</a>
                                            @endif
                                        </td>
                                        {{--<td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                            {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                        </td>--}}
                                        @if(auth()->user()->hasRole('doctor'))
                                        <td>
                                            @if (auth()->user()->hasPermission('update_lessons'))
                                                <a href=" {{ route('dashboard.lessons.edit', $lesson->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_lessons'))
                                                <form action="{{route('dashboard.lessons.destroy', $lesson->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                            @endif

                                        </td>
                                        @endif
                                    </tr>
                                    @endif

                                    @if (auth()->user()->hasRole('student'))
                                    @foreach ($stdSbs as $stdSb)
                                    @if($stdSb->subject_id == $lesson->sbj_id && $stdSb->student_id == auth()->user()->fid)
                                    <tr>
                                        <td>{{ $lesson->id}}</td>
                                        <td>{{ $lesson->name}}</td>
                                        <td>{{ $lesson->subject['name']}}</td>
                                        <td><a class="btn btn-warning btn-sm" href="{{$lesson->youtube_link}}" target="_blank">go</a></td>
                                        <td>
                                                {{--<a href="lessons/pdffiles/{{$lesson->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                                <a href="lessons/pdffile/download/{{$lesson->pdf_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>

                                        </td>
                                        <td>
                                            <a href="lessons/pptxfile/download/{{$lesson->pptx_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        <td>
                                            {{ $lesson->assignments->count()}} <a href="{{route('dashboard.assignments.index', ['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id ])}}" class="btn btn-success btn-sm">@lang('site.show_lesson_assignments')</a>
                                            @if (auth()->user()->hasPermission('create_assignments'))
                                                <a href=" {{route('dashboard.assignments.create',['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> @lang('site.add_assignment')</a>
                                            @endif
                                        </td>
                                        {{--<td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                            {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                        </td>--}}

                                    </tr>
                                    @endif
                                    @endforeach

                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{$lessons->appends(request()->query())->links()}} --}}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>

    {{--model dailog--}}

    {{--
    <!-- Modal -->
    <div class="modal fade" id="sbjTable" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">@lang('site.sbj_table')</h4>
            </div>
            <div class="modal-body">
                <div class="pdfobject-container">
                    <div id="viewpdf"></div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>--}}

@endsection
@section('scripts')
<script>
    $('#lessonTable').DataTable({
            "pageLength": 5,
        });
</script>
@endsection

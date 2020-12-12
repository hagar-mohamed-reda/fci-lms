@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.assignments')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.assignments')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.assignments') {{--<small>{{$assignments->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.assignments.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>

                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <div class="col-md-4">
                                    <select name="doc_id" id="doctors" class="form-control  select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <select name="sbj_id" id="subjects" class="form-control  select2-js">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="lesson_id" id="lessons" class="form-control  select2-js">
                                        <option value="">@lang('site.lessons')</option>
                                        @foreach ($lessons as $lesson)
                                        <option value="{{$lesson->id}}" {{request()->lesson_id == $lesson->id ? 'selected' : ''}}>{{$lesson->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    {{--@if (auth()->user()->hasPermission('create_assignments'))
                                        <a href=" {{route('dashboard.assignments.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif--}}


                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="assigntable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.lesson_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.doc_name')</th>
                                        <th>@lang('site.quest_file')</th>
                                        <th>@lang('site.start_date')</th>
                                        <th>@lang('site.end_date')</th>

                                        @if (auth()->user()->hasPermission('read_stdassign'))
                                        <th>@lang('site.students')</th>
                                        @endif

                                        @if(auth()->user()->hasRole('doctor')  || auth()->user()->hasRole('student') )
                                        <th>@lang('site.action')</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $index=>$assignment)
                                    @if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                    <tr>
                                        {{-- <td>{{ $assignment->id}}</td> --}}
                                        <td>{{ $assignment->name}}</td>
                                        <td>{{ $assignment->lesson['name']}}</td>
                                        <td>{{ $assignment->subjects['name']}}</td>
                                        <td>{{ $assignment->doctor['name']}}</td>
                                        <td>
                                            {{--<a href="assignments/pdffiles/{{$assignment->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                            <a href="#" class="btn btn-primary btn-sm showFileOnline" data-open='off' data-src="{{'http://lms.seyouf.sphinxws.com/public/uploads/questions/'.$assignment->pdf_quest}}" {{--onclick="viewFile(this)"--}}><i class="fa fa-show"></i> @lang('site.show')</a>
                                            <a href="assignments/pdffile/download/{{$assignment->pdf_quest}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        <td>{{ $assignment->start_date}}</td>
                                        <td>{{ $assignment->end_date}}</td>
                                        {{--<td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sbjTable">@lang('site.show_subj_table')</button>
                                            {{--<a href="{{ asset('dashboard/files/myposProject.pdf') }}">@lang('site.show_subj_table')</a>}}
                                        </td>--}}
                                        <td>
                                            @if (auth()->user()->hasPermission('read_stdassign'))
                                            {{ $assignment->stdAssign->count()}} <a href="{{route('dashboard.student_assignments.index', ['assign_id' => $assignment->id ])}}" class="btn btn-info btn-sm">@lang('site.show_students_anss')</a>
                                            @endif
                                        </td>

                                        @if(auth()->user()->hasRole('doctor'))
                                        <td>
                                            @if (auth()->user()->hasPermission('update_assignments') && auth()->user()->fid == $assignment->doc_id)
                                                <a href=" {{ route('dashboard.assignments.edit', $assignment->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_assignments') && auth()->user()->fid == $assignment->doc_id)
                                                <form action="{{route('dashboard.assignments.destroy', $assignment->id)}}" method="POST" style="display: inline-block">
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

                                    <tr>
                                        {{-- <td>{{ $assignment->id}}</td> --}}
                                        <td>{{ $assignment->name}}</td>
                                        <td>{{ $assignment->lesson['name']}}</td>
                                        <td>{{ $assignment->subjects['name']}}</td>
                                        <td>{{ $assignment->doctor['name']}}</td>
                                        <td>
                                            {{--<a href="assignments/pdffiles/{{$assignment->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>--}}
                                            <a href="#" class="btn btn-primary btn-sm showFileOnline" data-open='off' data-src="{{'http://lms.seyouf.sphinxws.com/public/uploads/questions/'.$assignment->pdf_quest}}" {{--onclick="viewFile(this)"--}}><i class="fa fa-show"></i> @lang('site.show')</a>
                                            <a href="assignments/pdffile/download/{{$assignment->pdf_quest}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                        </td>
                                        <td>{{ $assignment->start_date}}</td>
                                        <td>{{ $assignment->end_date}}</td>


                                        <td>
                                            @if (auth()->user()->hasPermission('create_stdassign'))
                                            <a href="{{route('dashboard.student_assignments.create',['assign_id'=>$assignment->id,'lesson_id'=>$assignment->lesson_id,'sbj_id'=>$assignment->sbj_id,'doc_id'=>$assignment->doc_id])}}" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> @lang('site.upload_anss')</a>
                                                {{--
                                                <a href="{{route('dashboard.assignments.edit',$assignment->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-upload"></i> @lang('site.upload_anss')</a>
                                                <a href="/files/{{$assignment->pdf_anss}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a>
                                                --}}
                                            @endif
                                        </td>

                                    </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>

    {{--model dailog--}}


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
      </div>

@endsection

@section('scripts')
    <script>
        $(function(){
            //function to oben the answer in new tab
        $(document).on("click",".showFileOnline",function() {
            console.log($(this));
            var src = $(this).data('src');
            $(this).attr('data-open', 'on');

            return window.open("https://docs.google.com/viewerng/viewer?url="+src, '_blank');

            var modal = document.createElement("div");
            modal.className = "w3-modal w3-block nicescroll";
            modal.style.zIndex = "10000000";
            modal.style.paddingTop = "20px";

            modal.innerHTML = "<center><div class='w3-animate-zoom' > " +
                    '<iframe frameborder="0" scrolling="no" width="400" height="600" src="https://docs.google.com/viewerng/viewer?url=' + div.getAttribute("data-src") + '" ></iframe>'
                    + "</div></center>  ";

            modal.onclick = function () {
                window.open('https://usefulangle.com', '_blank');
                //modal.remove();
            };

            document.body.appendChild(modal);
        });

            $("#doctors").change(function(){
                $.ajax({
                    url: "{{ route('subjects.get_by_doctor') }}?doc_id=" + $(this).val(),
                    method: 'GET',
                    success: function(data) {
                        $('#subjects').html(data.html);
                    }
                });
            });
            $("#subjects").change(function(){
                $.ajax({
                    url: "{{ route('lessons.get_by_subject') }}?sbj_id=" + $(this).val(),
                    method: 'GET',
                    success: function(data) {
                        $('#lessons').html(data.html);
                    }
                });
            });
            $('#assigntable').DataTable({
            "pageLength": 5,
            "dom" : 'lBfrtip',
            "buttons" : [
                'copy', 'csv', 'excel', 'pdf','print',
            ]
        });
        });
    </script>
@endsection

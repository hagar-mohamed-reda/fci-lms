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
                                    <select name="doc_id" id="doctors" class="form-control select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4">
                                    <select name="sbj_id" id="subjects" class="form-control select2-js">
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
                        <div class="table-responsive">
                            <table class="table table-hover" id="lessonTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.doc_name')</th>
                                        <th>@lang('site.file_one')</th>
                                        <th>@lang('site.file_two')</th>
                                        <th>@lang('site.youtube_link')</th>
                                        <th>@lang('site.video')</th>
                                        <th>@lang('site.assignments') </th>

                                        @if(auth()->user()->hasRole('doctor'))
                                        <th>@lang('site.action')</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lessons as $index=>$lesson)
                                    <tr>
                                        <td>{{ $lesson->name}}</td>
                                        <td>{{ optional($lesson->subject)->name}}</td>
                                        <td>{{ optional($lesson->doctor)->name}}</td>

                                        <td>
                                            @if (isset($lesson->pptx_file))
                                            <a href="#" class="btn btn-primary btn-sm showFileOnline" data-open='off' data-src="{{'http://lms.seyouf.sphinxws.com/public/uploads/lessons/'.$lesson->pptx_file}}" {{--onclick="viewFile(this)"--}}><i class="fa fa-show"></i> @lang('site.show')</a>
                                            <a href="lessons/pptxfile/download/{{$lesson->pptx_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                            @else
                                            __
                                            @endif
                                        </td>

                                        <td>
                                            @if (isset($lesson->pdf_file))
                                                {{-- <a href="lessons/pdffiles/{{$lesson->id}}" class="btn btn-primary btn-sm"><i class="fa fa-show"></i> @lang('site.show')</a> --}}
                                                <a href="#" class="btn btn-primary btn-sm showFileOnline" data-open='off' data-src="{{'http://lms.seyouf.sphinxws.com/public/uploads/lessons/'.$lesson->pdf_file}}" {{--onclick="viewFile(this)"--}}><i class="fa fa-show"></i> @lang('site.show')</a>
                                                <a href="lessons/pdffile/download/{{$lesson->pdf_file}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> @lang('site.download')</a>
                                            @else
                                                __
                                            @endif
                                        </td>

                                        <td>
                                            @if (isset($lesson->youtube_link))
                                            <a class="btn btn-warning btn-sm" href="{{$lesson->youtube_link}}" target="_blank">@lang('site.show')</a>
                                            @else
                                            __
                                            @endif
                                        </td>

                                        <td>
                                            @if (isset($lesson->mp4_file))
                                            <a data-toggle="modal" data-target="#showvideo" onclick="showView('{{url("/uploads/lessons" . "/" . $lesson->mp4_file)}}')" class="btn btn-primary btn-sm"> @lang('site.show')</a>
                                            @else
                                            __
                                            @endif
                                        </td>
                                        <td>
                                            {{ optional($lesson->assignments)->count()}} <a href="{{route('dashboard.assignments.index', ['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id ])}}" class="btn btn-success btn-sm">@lang('site.show_lesson_assignments')</a>
                                            @if (auth()->user()->hasPermission('create_assignments') && auth()->user()->fid == $lesson->doc_id)
                                                <a href=" {{route('dashboard.assignments.create',['sbj_id' => $lesson->sbj_id, 'lesson_id' => $lesson->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> @lang('site.add_assignment')</a>
                                            @endif
                                        </td>

                                        @if(auth()->user()->hasRole('doctor'))
                                        <td>
                                            @if (auth()->user()->hasPermission('update_lessons') && auth()->user()->fid == $lesson->doc_id)
                                                <a href=" {{ route('dashboard.lessons.edit', $lesson->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_lessons') && auth()->user()->fid == $lesson->doc_id)
                                                <form action="{{route('dashboard.lessons.destroy', $lesson->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                            @endif

                                        </td>
                                        @endif

                                    </tr>
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
    <div class="modal fade" id="showvideo" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">@lang('site.video')</h4>
            </div>
            <div class="modal-body">

                <video class="lessonVideo" width="850" height="500" controls controlslist="nodownload">
                    <source src="" type="video/mp4">
                </video>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

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

    function showView(src){
        $('#showvideo video').attr('src', src);
    }

    $('.lessonVideo').bind('contextmenu',function() { return false; });//to privent click right on video

    $('#lessonTable').DataTable({
            "pageLength": 5,
            "dom" : 'lBfrtip',
            "buttons" : [
                'copy', 'csv', 'excel', 'pdf','print',
            ]
            /*"ajax" : {
                    "url" : "{{ url('dashboard/lessons/index') }}",
                    "type": "PUT",
                    data: {'_token':$('input[name=_token]').val()}
                },*/
        });
</script>
@endsection

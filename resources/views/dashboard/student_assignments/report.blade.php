@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.report')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.student_assignments')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.student_assignments') {{--<small>{{$subjects->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.student_assignments.getReport')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>


                                <div class="col-md-4">
                                    <select name="sbj_id" id="subjects" class="form-control select2-js">
                                        <option value="">@lang('site.subjects')</option>
                                        @foreach ($subjects as $subject)
                                            @if ($subject->docSubjs()->where('doctor_id', auth()->user()->fid)->exists() == auth()->user()->fid && auth()->user()->hasRole('doctor') || auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                            <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                            @endif
                                            {{-- @if (auth()->user()->hasRole('student'))
                                                @foreach ($stdSbs as $stdSb)
                                                @if($stdSb->subject_id == $subject->id && $stdSb->student_id == auth()->user()->fid)
                                                <option value="{{$subject->id}}" {{request()->sbj_id == $subject->id ? 'selected' : ''}}>{{$subject->name}}</option>
                                                @endif
                                                @endforeach
                                            @endif --}}
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
                        @if ($anssData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="ansReportTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>@lang('site.std_name')</th>
                                        <th>@lang('site.assign_name')</th>
                                        <th>@lang('site.sbj_name')</th>
                                        <th>@lang('site.date')</th>
                                        <th>@lang('site.grade')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anssData as $index=>$anssDa)
                                    @if ($anssDa->doc_id == auth()->user()->fid && auth()->user()->type == 'doctor' || auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin')
                                    <tr>
                                        {{-- <td>{{ $anssDa->id}}</td> --}}
                                        <td>{{ $anssDa->students['name']}}</td>
                                        <td>{{ $anssDa->assignments['name']}}</td>
                                        <td>{{ $anssDa->subjects['name']}}</td>

                                        @if ($anssDa->assignments['end_date'] > $anssDa->created_at)
                                            <td style="color: green">{{ $anssDa->created_at}}</td>
                                        @else
                                            <td style="color: red">{{ $anssDa->created_at}} @lang('site.after_date')</td>
                                        @endif
                                        <td>
                                            @if ($anssDa->grade > 0)
                                                {{$anssDa->grade}}
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- {{$anssDas->appends(request()->query())->links()}} --}}
                        @else
                            <h2>@lang('site.select_subject_name')</h2>
                        @endif
                    </div>

                </div>

            </section>

    </div>




@endsection

@section('scripts')
<script>
    $(function(){

        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function ( data, row, column, node ) {
                        // Strip $ from salary column to make it numeric
                        return column === 5 ?
                            data.replace( /[$,]/g, '' ) :
                            data;
                    }
                }
            }
        };

        $('#ansReportTable').DataTable({
         "pageLength": 10,
         "dom" : 'lBfrtip',
         "buttons" : [
            'copy', 'csv', 'excel',
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
            ,'print',
            ]
        });



    });

</script>
@endsection

@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.levels')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.levels')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.levels') {{--<small>{{$levels->total()}}</small>--}}</h3>
                        <form action="{{ route('dashboard.levels.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    @if (auth()->user()->hasPermission('create_levels'))
                                        <a href=" {{route('dashboard.levels.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($levels->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="levelsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($levels as $index=>$level)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{ $level->name}}</td>
                                        <td>
                                            @if (auth()->user()->hasPermission('update_levels'))
                                                <a href=" {{ route('dashboard.levels.edit', $level->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_levels'))
                                                <form action="{{route('dashboard.levels.destroy', $level->id)}}" method="POST" style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                            {{-- {{ $levels->appends(request()->query())->links() }} --}}
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
            $('#levelsTable').DataTable({
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
        });
    </script>
@endsection

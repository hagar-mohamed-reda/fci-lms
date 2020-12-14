@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.departments')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.departments')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.departments') {{--<small>{{$departments->total()}}</small>--}} </h3>
                        <form action="{{ route('dashboard.departments.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>

                                <div class="col-md-4 form-group">
                                    <select name="level_id" class="form-control select2-js" id="levels">
                                        <option value="">@lang('site.level')</option>
                                        @foreach ($levels as $level)
                                            <option value="{{$level->id}}" {{request()->level_id == $level->id ? 'selected' : ''}}>{{$level->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    @if (auth()->user()->hasPermission('create_departments'))
                                        <a href=" {{route('dashboard.departments.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @if ($departments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="departsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.level')</th>
                                        <th>@lang('site.notes')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $index=>$department)
                                    <tr>
                                        <td>{{ $index + 1}}</td>
                                        <td>{{ $department->name}}</td>
                                        <td>{{ $department->level['name']}}</td>
                                        <td>{{ $department->notes}}</td>
                                        <td>
                                            @if (auth()->user()->hasPermission('update_departments'))
                                                <a href=" {{ route('dashboard.departments.edit', $department->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif
                                            @if (auth()->user()->hasPermission('delete_departments'))
                                                <form action="{{route('dashboard.departments.destroy', $department->id)}}" method="POST" style="display: inline-block">
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

                            {{-- {{ $departments->appends(request()->query())->links() }} --}}
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
            $('#departsTable').DataTable({
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

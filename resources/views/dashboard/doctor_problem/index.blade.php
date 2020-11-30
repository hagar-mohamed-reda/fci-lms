@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.doctor_problems')</h1>
        <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"> @lang('site.doctor_problems')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 15px">@lang('site.doctor_problems') {{--<small>{{$subjects->total()}}</small>--}}</h3>
            </div>

            <div class="box-body">
                @if ($docProblems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="docProbTable" >
                        <thead>
                            <tr>
                                <th>{{ __('site.name') }}</th>
                                <th>{{ __('site.phone') }}</th>
                                <th>{{ __('site.type') }}</th>
                                <th>{{ __('site.problem') }}</th>
                                <th>{{ __('site.status') }}</th>
                                <th>{{ __('site.employee') }}</th>
                                <th>{{ __('site.employee_comment') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                @else
                    <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
        </div>
</div>




@endsection

{{-- @section("additional")

<!-- edit modal -->
<div class="modal fade"  role="dialog" id="editModal" style="width: 100%!important;height: 100%!important" >
    <div class="modal-dialog modal-" role="document" >
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center class="modal-title w3-xlarge">{{ __('edit problem') }}</center>
      </div>
      <div class="modal-body editModalPlace">

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection --}}

@section("headers")


{{--
    <button class=" btn btn-primary   w3-round-xxlarge hidden" onclick="$('.filters').slideToggle(300)" >
    <i class="fa fa-filter" ></i> {{ __('filters') }}
    </button>


    <button class="btn btn-default w3-round-xxlarge " onclick="filter.filter.status='default';search()" >  <i class="fa fa-circle" ></i>  {{ __('new') }} </button>

    <button class="btn btn-success w3-round-xxlarge " onclick="filter.filter.status='success';search()" >  <i class="fa fa-check" ></i>  {{ __('success') }} </button>

    <button class="btn btn-warning w3-round-xxlarge " onclick="filter.filter.status='warning';search()" >  <i class="fa fa-exclamation-triangle" ></i>  {{ __('warning') }} </button>

    <button class="btn btn-danger w3-round-xxlarge " onclick="filter.filter.status='error';search()" >  <i class="fa fa-exclamation-circle" ></i>  {{ __('error') }} </button>
--}}
@endsection
@section("scripts")

<script>
    var table = null;

    $('.app-add-button').remove();

    function updateStatus(id, status, comment, button) {
        console.log(status);
        if (!status || status.length <= 0)
            return error("{{ __('please choose the status') }}");

        var data = {
            _token: '{{ csrf_token() }}',
            comment: comment,
            status: status
        };
        $(button).html('<i class="fa fa-spin fa-spinner" ></i>');
        $.post('{{ url("/dashboard/problem/update") }}/'+id, $.param(data), function(r) {
            if (r.status == 1)
                success(r.message);
            else
                error(r.message);

            $('#table').DataTable().ajax.reload();
            $(button).html('<i class="fa fa-check" ></i>');
        });
    }

    function search() {
        //alert();
        table.ajax.url("{{ url('/dashboard/doctor-problem/data') }}?"+$.param(filter.filter)).load();
    }

    /*var filter = new Vue({
        el: '#filter',
        data: {
            filter: {}
        },
        methods: {
        },
        computed: {
        },
        watch: {
        }
    });*/

$(document).ready(function() {
     table = $('#docProbTable').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 5,
        "sorting": [0, 'DESC'],
        "ajax": {
                    "url" : "{{ url('/dashboard/doctor-problem/data') }}",
                    "type": "get",
                    data: {'_token':$('input[name=_token]').val()}
                },
        "columns":[
            { "data": "name" },
            { "data": "phone" },
            { "data": "type" },
            { "data": "notes" },
            { "data": "status" },
            { "data": "user_id" },
            { "data": "comment" },
            { "data": "action" }
        ]
     });

     //formAjax();
     $.fn.dataTable.ext.errMode = 'throw';


});
</script>
@endsection

@extends('layouts.dashboard.app')

@section('content')


    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.profile')</h1>

            <!-- <ol>
                <li><i class="fa fa-dashboard"></i>@lang('site.profile')</li>
                <li class="active"><i class="fa fa-dashboard"></i>@lang('site.users')</li>
            </ol> -->
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i>@lang('site.profile')</li>
                <li><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
            </ol>

        </section>


<!-- Main content -->
<section class="content w3-margin" style="direction: ltr">


    <!-- email section -->
    <div class="w3-white round shadow w3-animate-opacity table-  row" style="background-color: #fff;
                                                                                border-radius: 5px;
                                                                                padding: 10px;
                                                                                margin: 5px;">
        <div class="form-group w3-padding ">
            <label class="w3-xlarge" for="email">{{ __('translation') }}</label>
            <div class="w3-large w3-text-gray" >
               {{ __('you can translate each word in English or Arabic') }}
            </div>
            <table class="table table-bordered" >
                <tr style="text-align: center">
                    <th style="text-align: center">{{ __('key') }}</th>
                    <th style="text-align: center">{{ __('word in English') }}</th>
                    <th style="text-align: center">{{ __('word in Arabic') }}</th>
                </tr>
                @foreach(App\Translation::all() as $item)
                <tr class="dictionary-item" data-id="{{ $item->id }}" >
                    <td>
                        {{ $item->key }}
                    </td>
                    <td>
                        <input
                            type="text"
                            class="w3-input w3-block  word_en"
                            value="{{ $item->word_en }}"
                            style="width: 200px;padding: 8px;
                            border: none;
                            border-bottom: 1px solid #ccc;"
                            placeholder="">
                    </td>
                    <td>
                        <input
                            type="text"
                            class="w3-input w3-block  word_ar"
                            value="{{ $item->word_ar }}"
                            style="width: 200px;padding: 8px;
                            border: none;
                            border-bottom: 1px solid #ccc;"
                            placeholder="">
                    </td>
                </tr>
                @endforeach
            </table>
            <br>
            <div class="form-group w3-padding ">
                <button class="btn w3-indigo shadow btn-sm" onclick="editTranslation(this)" >
                    <i class="fa fa-check" ></i> {{ __('save') }}
                </button>
            </div>
        </div>
    </div>
    <br>

    <!-- /.row -->
</section>

</div>
@endsection


@section('scripts')
<script>

    function editTranslation(button) {
        $(button).attr('disabled', 'disabled');
        $(button).html('<i class="fa fa-spin fa-spinner" ></i>');

        var translations = [];

        $(".dictionary-item").each(function(){
            var item = {};
            item.id = $(this).attr('data-id');
            item.word_en = $(this).find(".word_en").val();
            item.word_ar = $(this).find(".word_ar").val();

            translations.push(item);
        });

        var data = {
            translations: JSON.stringify(translations),
            _token: '{{ csrf_token() }}'
        };



        $.post('{{ route("dashboard.translation.update.post") }}', $.param(data), function(r){
            if (r.status == 1) {
                alert(r.message);
            } else {
                alert(r.message);
            }
            $(button).removeAttr("disabled");
            $(button).html(' <i class="fa fa-check" ></i> {{ __('save') }}');
        });
    }


</script>
@endsection

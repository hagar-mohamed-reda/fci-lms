@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
            <section class="content-header">
                <h1>@lang('site.subjects')</h1>
                <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                    <li class="active"> @lang('site.subjects')</li>
                </ol>
            </section>
            <section class="content">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.subjects') <small>{{$subjects->total()}}</small></h3>
                        <form action="{{ route('dashboard.subjects.index')}}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search}}">
                                </div>

                                <div class="col-md-4">
                                    <select name="doc_id" class="form-control select2-js">
                                        <option value="">@lang('site.doctors')</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}" {{request()->doc_id == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                                    @if (auth()->user()->hasPermission('create_subjects'))
                                        <a href=" {{route('dashboard.subjects.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @else
                                        <a href="#" class="btn btn-success disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        @foreach ($subjects as $subject)

                                    <div class="panel-group">

                                        <div class="panel panel-info">

                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#{{ str_replace(' ', '-', $subject->name) }}">{{ $subject->name }}</a>
                                                </h4>
                                            </div>

                                            <div id="{{ str_replace(' ', '-', $subject->name) }}" class="panel-collapse collapse">

                                                <div class="panel-body">

                                                    @if ($subject->products->count() > 0)

                                                        <table class="table table-hover">
                                                            <tr>
                                                                <th>@lang('site.name')</th>
                                                                <th>@lang('site.stock')</th>
                                                                <th>@lang('site.price')</th>
                                                                <th>@lang('site.add')</th>
                                                            </tr>

                                                            @foreach ($subject->products as $product)
                                                                <tr>
                                                                    <td>{{ $product->name }}</td>
                                                                    <td>{{ $product->stock }}</td>
                                                                    <td>{{ number_format($product->sale_price,2) }}</td>
                                                                    <td>
                                                                        <a href=""
                                                                        id="product-{{ $product->id }}"
                                                                        data-name="{{ $product->name }}"
                                                                        data-id="{{ $product->id }}"
                                                                        data-price="{{ $product->sale_price }}"
                                                                        class="btn btn-success btn-sm add-product-btn">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </table><!-- end of table -->

                                                    @else
                                                        <h5>@lang('site.no_records')</h5>
                                                    @endif

                                                </div><!-- end of panel body -->

                                            </div><!-- end of panel collapse -->

                                        </div><!-- end of panel primary -->

                                    </div><!-- end of panel group -->

                                @endforeach

                    </div>

                </div>

            </section>

    </div>

@endsection

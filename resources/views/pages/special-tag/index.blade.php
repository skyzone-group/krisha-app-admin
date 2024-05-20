@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.special-tag.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.special-tag.title')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('cruds.special-tag.title_singular')</h3>
                        @can('special-tag.add')
                            <a href="{{ route('special-tagAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                @lang('global.add')
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable" class="table dt-responsive  w-100">

                            <thead>
                            <tr>
                                <th>@lang('cruds.special-tag.fields.id')</th>
                                <th>@lang('cruds.special-tag.fields.icon')</th>
                                <th>@lang('cruds.special-tag.fields.name')</th>
                                <th>@lang('cruds.special-tag.fields.color')</th>
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->icon }}</td>
                                    <td>{{ $item->name_ru }}</td>
                                    <td>
                                        <span style="background-color: {{ $item->color }}; color: {{ $item->color }}; display: block; width: 100%; height: 100%;">
                                            -
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @can('special-tag.delete')
                                            <form action="{{ route('special-tagDestroy',$item->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('special-tag.edit')
                                                        <a href="{{ route('special-tagEdit',$item->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) {this.form.submit()}"> @lang('global.delete')</button>
                                                </div>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

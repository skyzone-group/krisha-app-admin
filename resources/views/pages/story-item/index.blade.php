@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.story-item.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.story-item.title')</li>
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
                        <h3 class="card-title">@lang('cruds.story-item.title_singular')</h3>
                        @can('story-item.add')
                            <a href="{{ route('story-itemAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                @lang('global.add')
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>@lang('cruds.story-item.fields.id')</th>
                                <th>@lang('cruds.story-item.fields.story_category_id')</th>
                                <th>@lang('cruds.story-item.fields.title')</th>
                                <th>@lang('cruds.story-item.fields.file')</th>
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->story_category->title_uz }}</td>
                                    <td>{{ $item->title_ru }}</td>
                                    <td>
                                        @if($item->file)
                                            <a target="_blank" href="{{ config('constants.panel.file_url').$item->file }}">{{$item->file}}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('story-item.delete')
                                            <form action="{{ route('story-itemDestroy',$item->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('story-item.edit')
                                                        <a href="{{ route('story-itemEdit',$item->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
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

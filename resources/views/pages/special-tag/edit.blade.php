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
                        <li class="breadcrumb-item"><a href="{{ route('special-tagIndex') }}">@lang('cruds.special-tag.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.edit')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('special-tagUpdate', $item->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>@lang('cruds.special-tag.fields.category_type')</label>
                                <select class="select2" name="category_type" style="width: 100%;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->key }}" {{ $item->category_type == $category->key ? 'selected' : '' }}>{{ $category->name_ru }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    @foreach(config('constants.locales') as $locale)
                                        <div class="col-6 mb-2">
                                            <label>Название на  {{ $locale['title'] }}</label>
                                            <input type="text" name="name_{{$locale['short_name']}}" class="form-control {{ $errors->has("name_" . $locale['short_name']) ? "is-invalid":"" }}" value="{{ old('name_' . $locale['short_name'], $item->{'name_'.$locale['short_name']}) }}" required>
                                            @if($errors->has('name_' . $locale['short_name']))
                                                <span class="error invalid-feedback">{{ $errors->first('name_' . $locale['short_name']) }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <label>@lang('cruds.special-tag.fields.color')</label>
                                        <input type="color" value="{{ old('color', $item->color) }}" name="color" class="form-control" required>
                                    </div>
                                    <div class="col-12 mb-2" id="photo">
                                        <label class="col-form-label">@lang('cruds.special-tag.fields.icon')</label>
                                        <input style="border: 0px; padding-left: 0px" type="file" name="icon" class="form-control" value="{{ old('icon') }}" >
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label>@lang('cruds.special-tag.fields.description')</label>
                                        <input type="text" name="description" class="form-control" value="{{ old('description', $item->description) }}" required>
                                    </div>
                                </div>
                            </div>




                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('special-tagIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

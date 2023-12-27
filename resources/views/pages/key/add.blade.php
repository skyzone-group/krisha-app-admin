@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.key.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('keyIndex') }}">@lang('cruds.key.title')</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
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
                        <h3 class="card-title">@lang('global.add')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
<!--                        --><?php
//                        echo "<pre>";
//                        print_r($errors);
//                        echo "</pre>";
//                        ?>
                        <form action="{{ route('keyCreate') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('cruds.key.fields.category_key_name')</label>
                                <select class="select2" name="category_key" style="width: 100%;">
                                    @foreach($elements as $element)
                                        <option value="{{ $element->key }}">{{ $element->name_ru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @foreach(config('constants.locales') as $locale)
                                        <div class="col-6 mb-2">
                                            <label>Название на  {{ $locale['title'] }}</label>
                                            <input type="text" name="name_{{$locale['short_name']}}" class="form-control {{ $errors->has("name_" . $locale['short_name']) ? "is-invalid":"" }}" value="{{ old('name_' . $locale['short_name']) }}" required>
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
                                        <label>@lang('cruds.key.fields.key_name')</label>
                                        <input type="text" name="key" class="form-control {{ $errors->has("key") ? "is-invalid":"" }}" value="{{ old('key') }}" required>
                                        @if($errors->has('key'))
                                            <span class="error invalid-feedback">{{ $errors->first('key') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label>@lang('cruds.key.fields.type')</label>
                                        <select class="select2" name="type" style="width: 100%;">
                                                <option value="single"> @lang('cruds.key.fields.single') </option>
                                                <option value="multiple"> @lang('cruds.key.fields.multiple') </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.key.fields.comment')</label>
                                <textarea class="form-control" name="comment">{{ old('comment') }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('keyIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

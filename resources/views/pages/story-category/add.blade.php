@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.story-category.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('story-categoryIndex') }}">@lang('cruds.story-category.title')</a></li>
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

                        <form action="{{ route('story-categoryCreate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    @foreach(config('constants.locales') as $locale)
                                        <div class="col-6 mb-2">
                                            <label>Название на  {{ $locale['title'] }}</label>
                                            <input type="text" name="title_{{$locale['short_name']}}" class="form-control {{ $errors->has("title_" . $locale['short_name']) ? "is-invalid":"" }}" value="{{ old('title_' . $locale['short_name']) }}" required>
                                            @if($errors->has('title_' . $locale['short_name']))
                                                <span class="error invalid-feedback">{{ $errors->first('title_' . $locale['short_name']) }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="photo">
                                        <label class="col-form-label">@lang('cruds.story-category.fields.photo')</label>
                                        <input style="border: 0px; padding-left: 0px" type="file" name="photo" class="form-control" value="{{ old('photo') }}" required>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('story-categoryIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

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
                                <label>@lang('cruds.story-item.fields.story_category_id')</label>
                                <select class="select2" name="story_category_id" style="width: 100%;">
                                    @foreach($storyCategories as $storyCategory)
                                        <option value="{{ $storyCategory->id }}">{{ $storyCategory->title_ru }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="card card-primary card-outline card-tabs">
                                    <div class="card-header p-0 pt-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                            @foreach(config('constants.locales') as $locale)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : ''}}" id="custom-tabs-three-{{$locale['short_name']}}-tab" data-toggle="pill" href="#custom-tabs-three-{{$locale['short_name']}}" role="tab" aria-controls="custom-tabs-three-{{$locale['short_name']}}" aria-selected="true"><i class="{{'sl-flag flag-'.$locale['short_name']}}"></i>
                                                        {{ strtoupper($locale['short_name']) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                            @foreach(config('constants.locales') as $locale)
                                                <div class="tab-pane fade {{ $loop->first ? 'active show' : ''}}" id="custom-tabs-three-{{$locale['short_name']}}" role="tabpanel" aria-labelledby="custom-tabs-three-{{$locale['short_name']}}-tab">
                                                    @foreach(config('constants.locales') as $locale_second)
                                                        @if($locale['short_name'] == $locale_second['short_name'])
                                                            <div class="form-group">
                                                                <label>@lang('cruds.story-item.fields.title')  {{ $locale['title'] }}</label>
                                                                <input type="text" name="title_{{$locale['short_name']}}" class="form-control {{ $errors->has("title_" . $locale['short_name']) ? "is-invalid":"" }}" value="{{ old('title_' . $locale['short_name']) }}">
                                                                @if($errors->has('title_' . $locale['short_name']))
                                                                    <span class="error invalid-feedback">{{ $errors->first('title_' . $locale['short_name']) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('cruds.story-item.fields.subtitle')  {{ $locale['title'] }}</label>
                                                                <textarea rows="3" name="subtitle_{{$locale['short_name']}}" class="ckeditor form-control {{ $errors->has("subtitle_" . $locale['short_name']) ? "is-invalid":"" }}" required>{{ old('subtitle_' . $locale['short_name']) }}</textarea>
                                                                @if($errors->has('subtitle_' . $locale['short_name']))
                                                                    <span class="error invalid-feedback">{{ $errors->first('subtitle_' . $locale['short_name']) }}</span>
                                                                @endif
                                                            </div>

                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="photo">
                                        <label class="col-form-label">@lang('cruds.story-item.fields.file')</label>
                                        <input style="border: 0px; padding-left: 0px" type="file" name="file" class="form-control" value="{{ old('file') }}" required>
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

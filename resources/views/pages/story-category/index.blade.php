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
                        <li class="breadcrumb-item active">@lang('cruds.story-category.title')</li>
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
                        <h3 class="card-title">@lang('cruds.story-category.title_singular')</h3>
                        @can('story-category.add')
                            <a href="{{ route('story-categoryAdd') }}" class="btn btn-success btn-sm float-right">
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
                                <th></th>
                                <th>@lang('cruds.story-category.fields.id')</th>
                                <th>@lang('cruds.story-category.fields.title')</th>
                                <th>@lang('cruds.story-category.fields.photo')</th>
                                <th class="w-25">@lang('global.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr data-position="{{ $item->position }}" data-category-id="{{ $item->id }}">
                                    <td><span class="move-item" style="cursor: move;"><i class="fa fa-bars"></i></span></td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title_ru }}</td>
                                    <td>
                                        @if($item->photo)
                                            <a target="_blank" href="{{ config('constants.panel.file_url').$item->photo }}">{{$item->photo}}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('story-category.delete')
                                            <form action="{{ route('story-categoryDestroy',$item->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('story-category.edit')
                                                        <a href="{{ route('story-categoryEdit',$item->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
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

@section('scripts')
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script> -->

    <script>
        // Initialize Sortable.js
        var dataTable = document.getElementById('dataTable');
        var sortable = Sortable.create(dataTable.tBodies[0], {
            handle: '.move-item',
            onEnd: function(evt) {
                var sortedData = Array.from(dataTable.tBodies[0].rows).map(function(row) {
                    return {
                        position: row.getAttribute('data-position'),
                        categoryId: row.getAttribute('data-category-id')
                    };
                });

                // Send the sorted data to the server using an AJAX request
                $.ajax({
                    url: "{{ 'x' }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "categories": sortedData
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Действие успешно завершено.',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 2000,
                            })
                            console.log("Categories sorted successfully.");
                        } else {
                            console.log("Failed to sort categories.");
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: `${error}`,
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 2000,
                        })
                        console.log("An error occurred while sorting categories.");
                    }
                });
            },
            animation: 150, // Default animation duration
            ghostClass: 'sortable-ghost', // Class name for the dragged item
            chosenClass: 'sortable-chosen', // Class name for the chosen item
            dragClass: 'sortable-drag', // Class name for the dragging item
        });
    </script>
@endsection


@extends('layouts.app')

@section('title')
    Task  List
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/filters.css') }}">
    @endpush
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h2 id="card_title">
                            {{ __('Tasks') }}
                        </h2>

                         <div>
                             <a href="" data-view="tasks" id="clear-filters" class="btn btn-success btn-sm mr-1">
                                 <i class="fas fa-eraser"></i> Clear Filters</a>
                             <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                 <i class="fas fa-plus-circle"></i> {{ __('New Task') }}</a>
                         </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <p class="note">Click data column headers to sort by that column.</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-responsive table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>

										<th data-sort="title" class="column-sorter c-pointer">
											Title
                                            @if(isset($sort) && $sort === 'title')
                                                <img class="align-self-end"
                                                     src="{{ asset('assets/img/arrow-' . $sort_icon . '.svg')  }}">
                                            @endif
                                        </th>
										<th data-sort="description" class="column-sorter c-pointer">
											Description
                                            @if(isset($sort) && $sort === 'description')
                                                <img class="align-self-end"
                                                     src="{{ asset('assets/img/arrow-' . $sort_icon . '.svg')  }}">
                                            @endif
                                        </th>
										<th data-sort="status" class="column-sorter c-pointer">
											Status
                                            @if(isset($sort) && $sort === 'status')
                                                <img class="align-self-end"
                                                     src="{{ asset('assets/img/arrow-' . $sort_icon . '.svg')  }}">
                                            @endif
                                        </th>
										<th data-sort="due_date" class="column-sorter c-pointer">
                                            Due Date
                                            @if(isset($sort) && $sort === 'due_date')
                                                <img class="align-self-end"
                                                     src="{{ asset('assets/img/arrow-' . $sort_icon . '.svg')  }}">
                                            @endif
                                        </th>

                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="page" id="page" value="tasks">
                                    <input type="hidden" name="sort_icon" id="sort_icon" value="{{ $sort_icon }}">
                                    <tr id="filters">
                                        <td><img alt="filters" src="{{ asset('assets/img/filter.svg') }}"></td>
                                        <td><input class="form-control form-control-sm" type="text" name="filter['title']"
                                                   data-field="title"
                                                   value="{{ $get['title'] ?? '' }}"></td>

                                        <td><input class="form-control form-control-sm" type="text" name="filter['description']"
                                                   data-field="description"
                                                   value="{{ $get['description'] ??  '' }}"></td>

                                        <td><select id="statusFilter" class="form-select form-select-sm" name="filter['status']" data-field="status">
                                                <option></option>
                                                <option value="1" @if(isset($get['status']) && $get['status'] == 1) selected @endif>Complete</option>
                                                <option value="0" @if(isset($get['status']) && $get['status'] == 0) selected @endif>Incomplete</option>
                                            </select>
                                        <td><input class="form-control form-control-sm" type="text" name="filter['due_date']"
                                                   data-field="due_date"
                                                   value="{{ $get['due_date'] ?? '' }}"></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($models as $model)
                                        <tr id="row-{{ $model->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
											<td>{{ $model->title }}</td>
											<td>{{ $model->description }}</td>
                                            <td>
                                                @if($model->status === 0)
                                                    <img class="c-pointer" data-id="{{ $model->id }}" title="Toggle Status" alt="{{ \App\Models\Task::statusText()[$model->status] }}" src="{{ asset('assets/img/switch-off.svg') }}">
                                                @else
                                                    <img class="c-pointer" data-id="{{ $model->id }}" title="Toggle Status" alt="{{ \App\Models\Task::statusText()[$model->status] }}" src="{{ asset('assets/img/switch-on.svg') }}">
                                                @endif
                                                <span data-status="{{ $model->id }}">{{ \App\Models\Task::statusText()[$model->status] }}</span>
                                            </td>
                                            <td class="">{{ date('m/d/Y', strtotime($model->due_date)) }}</td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('tasks.destroy',$model->id) }}" method="POST">
                                                    <a class="" href="{{ route('tasks.show',$model->id) }}"><img alt="Show" src="{{ asset('assets/img/view.svg') }}"></a>
                                                    <a class="" href="{{ route('tasks.edit',$model->id) }}"><img alt="Show" src="{{ asset('assets/img/edit.svg') }}"></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0" style="background: none; padding: 0"><img alt="Show" src="{{ asset('assets/img/delete.svg') }}"></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-body')
    <script defer src="{{ asset('assets/js/filters.js') }}"></script>
    <script defer src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@endpush

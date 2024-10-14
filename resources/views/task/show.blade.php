@extends('layouts.app')

@section('title')
    {{ $model->name ?? 'Task' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Task</h2>
                        <div>
                            <a class="btn btn-primary" href="{{ route('tasks') }}">
                             <i class="fas fa-arrow-alt-circle-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Title:</strong> {{ $model->title }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $model->description }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $model->status }}
                        </div>
                        <div class="form-group">
                            <strong>Due date:</strong>
                            {{ date('m/d/Y', strtotime($model->due_date)) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

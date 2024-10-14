@extends('layouts.app')

@section('template_title')
    Update Player
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <h2 class="card-title">Update Task</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.update', $model->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('task.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

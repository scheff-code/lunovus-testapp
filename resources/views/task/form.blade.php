<div class="container">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <div class="form-floating mb-3">
                    <input
                        required="required"
                        type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        placeholder="Title"
                        value="@isset($model->title){{ $model->title }}@endisset"
                    >
                    <label for="title">Title *</label>
                </div>
                {!! $errors->first('title', '<p class="invalid-feedback">:message</p>') !!}

                <div class="form-floating mb-3">
                    <textarea rows="5" required="required" class="form-control form-textarea h-100" id="description" name="description" placeholder="Description *">@isset($model->description){{ $model->description }}@endisset</textarea>
                    <label for="description">Description *</label>
                </div>
                {!! $errors->first('title', '<p class="invalid-feedback">:message</p>') !!}

                <div class="form-floating mb-3">
                    <input required="required" type="date" class="form-control" id="due_date" name="due_date" placeholder="Due Date"
                        value="@isset($model->due_date){{ date('Y-m-d', strtotime($model->due_date)) }}@endisset"
                        >
                    <label for="due_date">Due Date *</label>
                </div>
                {!! $errors->first('due_date', '<p class="invalid-feedback">:message</p>') !!}

                <div class="form-floating mb-3">
                    <select required="required" class="form-control" id="status" name="status" placeholder="Status">
                        <option>Choose&hellip;</option>
                        <option value="1" @if($model->status === 1) selected @endif>Complete</option>
                        <option value="0" @if($model->status === 0) selected @endif>Incomplete</option>
                    </select>
                    <label for="status">Status *</label>
                </div>
                {!! $errors->first('status', '<p class="invalid-feedback">:message</p>') !!}


            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </div>
</div>

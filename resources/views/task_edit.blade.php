@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="page-header text-center">Tasks Management</h1>
  <div class="row">
      <div class="col-md-12">
          <h2>Edit Task</h2>
          @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <form action="{{ route('tasks.update', $task->id) }}" method="post">
              {{ csrf_field() }}
              @method('PUT')
              <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" name="name" class="form-control" value="{{ $task->name }}" type="text">
              </div>
              <div class="form-group">
                  <label for="description" class="control-label">Description</label>
                  <textarea id="description" name="description" class="form-control">{{ $task->description }}</textarea>
              </div>
              <input type="submit" value="Simpan" class="btn btn-primary">
          </form>
      </div>
  </div>
</div>
@endsection
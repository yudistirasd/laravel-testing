@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="page-header text-center">Tasks Management</h1>
  <div class="row">
      <div class="col-md-4 col-md-offset-2">
          <h2>Tasks</h2>
          <ul class="list-group">
              @foreach ($tasks as $task)
                  <li class="list-group-item">
                      {{ $task->name }} <br>
                      <p>{{ $task->description }}</p>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-default btn-xs">
                      Ubah
                    </a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="$(this).parent().submit()">
                        Hapus
                      </a>
                    </form>
                  </li>
              @endforeach
          </ul>
      </div>
      <div class="col-md-4">
          <h2>New Task</h2>
          @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <form action="{{ url('tasks') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" name="name" class="form-control" type="text">
              </div>
              <div class="form-group">
                  <label for="description" class="control-label">Description</label>
                  <textarea id="description" name="description" class="form-control"></textarea>
              </div>
              <input type="submit" value="Create Task" class="btn btn-primary">
          </form>
      </div>
  </div>
</div>
@endsection
<form action="{{ route('tasks.store') }}" method="POST">
  @csrf
  <input type="text" name="name">
  <input type="text" name="description">
  <button type="submit" value="Submit">Submit</button>
</form>
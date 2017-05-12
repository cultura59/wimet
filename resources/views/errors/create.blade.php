<div class="flash-message">
  @foreach ($errors->all() as $error)
  <p class="alert alert-danger">{{$error}} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
  @endforeach
</div>
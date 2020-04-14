@if (count($errors) > 0)
      @foreach ($errors->all() as $error)
        <div class="notification error errormsg successmsg">
            <span>Error : {{ $error }}</span><button class="close-ntf"><i class="fas fa-times"></i></button>
        </div>
      @endforeach
@endif
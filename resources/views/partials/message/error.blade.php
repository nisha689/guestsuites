@if(session('error'))
<div class="notification error successmsg">
  <span>Error : {{ session('error') }}</span>
  <button class="close-ntf"><i class="fas fa-times"></i></button>
</div>
@endif
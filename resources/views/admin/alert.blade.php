@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('success') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('error') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif(session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <span class="alert-inner--text"><strong>Warning!</strong> {{ session('warning') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif(session()->has('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('info') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

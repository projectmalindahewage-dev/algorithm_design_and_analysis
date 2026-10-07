
<h1>Attendance Formatting</h1>
@if (session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<form id="attendance_format_process_form" class="needs-validation" method="POST" action="{{url('attendance/formatting_process')}}">
  @csrf
  <div class="mb-3">
      <button id="att_format_btn" type="submit" class="btn btn-primary btn-sm mb-1">Format</button>
  </div>
</form>






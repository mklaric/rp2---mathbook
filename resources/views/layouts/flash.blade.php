@if (Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} fade in custom-alert" style="">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ ['alert-success' => 'Success!', 'alert-info' => 'Info!', 'alert-warning' => 'Warning!', 'alert-danger' => 'Error!'][Session::get('alert-class', 'alert-info')] }}</strong> {{ Session::get('message') }}
</div>

<script>
$("a.close").click(function() {
    $(this).parent().animate({height: 0}, {
        duration: 190,
        specialEasing: {
            height: "linear"
        }});
});
</script>
@endif

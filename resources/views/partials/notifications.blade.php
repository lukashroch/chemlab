<script type="text/javascript">
    $(document).ready(function () {
      @foreach (Alert::getMessages() as $type => $messages)
      @foreach ($messages as $message)
      new Notify("{{ $type }}", "{!! str_replace('"', "'", $message) !!}");
      @endforeach
      @endforeach
    });
</script>
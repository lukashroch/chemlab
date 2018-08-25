<script type="text/javascript">
    $(document).ready(function () {
      @foreach (Alert::getMessages() as $type => $messages)
      @foreach ($messages as $message)
      new PNotify({
          target: document.body,
          data: {
              text: "{!! str_replace('"', "'", $message) !!}",
              type: "{{ $type }}",
              icon: true
          }
      });
      @endforeach
      @endforeach
    });
</script>
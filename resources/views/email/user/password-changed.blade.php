@component('mail::message')
  # Dear {{ $userName }},

  You are receiving this email because password to your {{ link_to(config('app.url'), 'ChemLab') }}  account has been changed.

  @component('mail::panel')
    The change has been done from following location: {{ $userLoc }}
  @endcomponent

  If you did not change your password, please contact your ChemLab Administrator immediately. Otherwise, disregard and delete this message.

  Cheers,<br>
  {{ config('app.name') }}
@endcomponent

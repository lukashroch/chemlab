@component('mail::message')
  # Dear {{ $userName }},

  You are receiving this email because {{ $creatorName }} created new account for you in ChemLab laboratory database system.

  Please use combination of your email address and below generated password to access your new account at {{ config('app.url') }}.

  @component('mail::panel')
    Your password: <strong>{{ $userPass }}</strong> <br>
    <strong style="color: #ff4500">Please change your password in profile section as soon as you log in.</strong>
  @endcomponent

  Cheers,<br>
  {{ config('app.name') }}
@endcomponent

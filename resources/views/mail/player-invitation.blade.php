<x-mail::message>
  # You have been invited to join {{ $team->name }}

  {{ $team->name }} has invited you to join their team for the {{ $team->season->name }} season.

  You have 1 week to accept this invitation. If you do not accept this invitation within 1 week, it will expire.

  Please click the button below to accept the invitation:

  <x-mail::button :url='$url'>
    Accept Invitation
  </x-mail::button>

  Thanks,<br>
  {{ config("app.name") }}
</x-mail::message>

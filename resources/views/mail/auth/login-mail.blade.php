<x-mail::message>
  # Login to IMS

  Please click the link below to login to IMS.

  <x-mail::button :url="$url">
    Login to IMS
  </x-mail::button>

  If the above link does not work, please copy and paste the following URL in your browser:<br>
  {{ $url }}

  If you did not request a login, no further action is required.

  Thanks,<br>
  {{ config("app.name") }}
</x-mail::message>

@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Orden Servicio CRI')
<img src="{{ asset('/logo_cantv.svg') }}" class="logo" style="width:150px; height:90px;" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

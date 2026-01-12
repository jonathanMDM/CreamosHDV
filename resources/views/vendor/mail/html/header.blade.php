@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'CreamosHDV')
<img src="{{ asset('images/logo.png') }}" class="logo" alt="CreamosHDV Logo" style="max-height: 150px; height: auto;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>

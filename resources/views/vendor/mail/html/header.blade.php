@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'CO2')
                <img src="{{ asset('img/logo.png') }}" class="logo" alt="CO2 Peças logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>

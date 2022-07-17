@props(['matches'])

{{-- {{ dd($matches) }} --}}
<table class="w-full mt-4">
    <tr>
        <th class="p-2 align-middle text-center">Date</th>
        <th class="p-2 align-middle text-center">Summoner name</th>
        <th class="p-2 align-middle text-center">Lane</th>
        <th class="p-2 align-middle text-center">Champion played</th>
        <th class="p-2 align-middle text-center">Kills</th>
        <th class="p-2 align-middle text-center">Assists</th>
        <th class="p-2 align-middle text-center">Deaths</th>
        <th class="p-2 align-middle text-center">Duration</th>
    </tr>
    @foreach ($matches as $gamestat)
        <tr>
            <td class="p-2 align-middle text-center">{{ gmdate('d M Y', substr($gamestat->game->creation, 0, 10)) }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->summoner->name }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->lane }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->champion_name }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->kills }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->assists }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->deaths }}</td>
            <td class="p-2 align-middle text-center">{{ gmdate('H:i:s',$gamestat->game->duration) }}</td>
        </tr>
    @endforeach
</table>
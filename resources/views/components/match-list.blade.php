@props(['matches'])

<table class="w-full mt-4">
    <tr>
        <th class="p-2 align-middle text-center">Date</th>
        <th class="p-2 align-middle text-center">Win</th>
        <th class="p-2 align-middle text-center">Lane</th>
        <th class="p-2 align-middle text-center">Champion played</th>
        <th class="p-2 align-middle text-center">Kills</th>
        <th class="p-2 align-middle text-center">Assists</th>
        <th class="p-2 align-middle text-center">Deaths</th>
        <th class="p-2 align-middle text-center">Duration</th>
    </tr>
    @foreach ($matches as $gamestat)
        <tr class={{ $gamestat->win ? 'bg-green-100' : 'bg-red-100'}}>
            <td class="p-2 align-middle text-center">{{ $gamestat->game->creation }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->win ? 'Win' : 'Lose' }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->lane }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->champion_name }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->kills }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->assists }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->deaths }}</td>
            <td class="p-2 align-middle text-center">{{ $gamestat->game->duration }}</td>
        </tr>
    @endforeach
</table>

<table class="w-full mt-4">
    <tr>
        <th class="p-2 align-middle text-center">Total kills this week</th>
        <th class="p-2 align-middle text-center">Winrate this week</th>
    </tr>
    <tr>
        <td class="p-2 align-middle text-center">{{ $matches->sum('kills') }}</td>
        <td class="p-2 align-middle text-center">{{ round(($matches->sum('win') / count($matches)) * 100, 1) }}%</td>
    </tr> 
</table>
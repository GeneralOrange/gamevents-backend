@props(['matches', 'summoner'])

<table class="w-full mt-4">
    <tr>
        <th class="p-2 align-middle text-center">Summoner name</th>
        <th class="p-2 align-middle text-center">Champion played</th>
        <th class="p-2 align-middle text-center">Kills</th>
        <th class="p-2 align-middle text-center">Start time</th>
        <th class="p-2 align-middle text-center">Duration</th>
    </tr>
    @foreach ($matches as $match)
        <tr>
            <td class="p-2 align-middle text-center">{{ $match->info->participants[9]->summonerName }}</td>
            <td class="p-2 align-middle text-center">{{ $match->info->participants[9]->championName }}</td>
            <td class="p-2 align-middle text-center">{{ $match->info->participants[9]->kills }}</td>
            <td class="p-2 align-middle text-center">{{ gmdate('Y-m-d H:i:s',$match->info->gameCreation) }}</td>
            <td class="p-2 align-middle text-center">{{ gmdate('H:i:s',$match->info->gameDuration) }}</td>
        </tr>
    @endforeach
</table>
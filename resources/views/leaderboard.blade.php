<x-guest-layout>
    <h1 class="font-bold text-6xl mb-5">Leaderboards week: {{ now()->format('W') }}</h1>
    <p class="mb-10">{{ now()->parse('last Monday')->format('l jS') }} until {{ now()->parse('next Sunday')->format('l jS')}} of {{ now()->format('M')}}</p>
    <div class="max-w-2xl">
        <table class="w-full mt-4">
            <tr>
                <th class="p-2 align-middle text-left">Summoner</th>
                <th class="p-2 align-middle text-center">Total Games this week</th>
                <th class="p-2 align-middle text-center">Total Kills overall</th>
                <th class="p-2 align-middle text-center">Links</th>
            </tr>

            @foreach ($summoners as $summoner)
                <tr class="relative">
                    <td class="p-2 align-middle text-left">
                        {{ $summoner->name }} 
                    </td>
                    <td class="p-2 align-middle text-center">
                        {{ $summoner->games()->thisweek()->count() }}
                    </td>
                    <td class="p-2 align-middle text-center">
                        {{ $summoner->gamestats()->sum('kills') }}
                    </td>
                    <td class="p-2 align-middle text-center flex flex-col gap-1">
                        <a href="/summoner/{{ $summoner->slug }}" class="rounded-xl bg-gray-100 text-gray border-2 border-white p-2 hover:text-white hover:bg-gray-700">
                            Sum Profile
                        </a><br/>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-guest-layout>
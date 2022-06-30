<x-guest-layout>
    <h1 class="font-bold text-6xl mb-10">Leaderboards!</h1>
    <div class="bg-gray-300 rounded-md max-w-2xl p-4 shadow-md">
        <table>
            <tr><th class="p-2">ID</th><th class="p-2">Summoner</th><th>User</th><th>Links</th></tr>
            @foreach ($summoners as $summoner)
                <tr>
                    <td class="p-2">
                        {{ $summoner->id }}
                    </td>
                    <td class="p-2">
                        {{ $summoner->name }}
                    </td>
                    <td class="p-2">
                        {{ $summoner->user->name }}
                    </td>
                    <td class="p-2 flex flex-col gap-1">
                        <a href="/summoner/{{ $summoner->slug }}" class="rounded-xl bg-gray-100 text-gray border-2 border-white p-2 hover:text-white hover:bg-gray-700">
                            Sum Profile
                        </a><br/>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-guest-layout>
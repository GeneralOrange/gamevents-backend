<x-guest-layout>
    <h1 class="font-bold text-6xl mb-10">Leaderboards!</h1>
    <div class="bg-blue-500 rounded-md max-w-xl p-4">
        <table>
            <tr><th class="p-2">ID</th><th class="p-2">Name</th><th>User</th><th>Links</th></tr>
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
                        <a href="/summoner/{{ $summoner->slug }}" class="rounded-xl bg-cyan-500 text-white border-2 border-white p-2">
                            Summoner Profile
                        </a><br/>
                        <a href="/user/{{ $summoner->user->id }}" class="rounded-xl bg-cyan-500 text-white border-2 border-white p-2">
                            User Profile
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-guest-layout>
<x-guest-layout>
    <h1 class="font-bold text-6xl mb-10">Leaderboards!</h1>
    <div class="max-w-2xl">
        <table class="w-full mt-4">
            <tr>
                <th class="p-2 align-middle text-center">ID</th>
                <th class="p-2 align-middle text-center">Summoner</th>
                <th class="p-2 align-middle text-center">User</th>
                <th class="p-2 align-middle text-center">Links</th>
            </tr>
            @foreach ($summoners as $summoner)
                <tr>
                    <td class="p-2 align-middle text-center">
                        {{ $summoner->id }}
                    </td>
                    <td class="p-2 align-middle text-center">
                        {{ $summoner->name }}
                    </td>
                    <td class="p-2 align-middle text-center">
                        {{ $summoner->user->name }}
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
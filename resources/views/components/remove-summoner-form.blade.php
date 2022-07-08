<form method="POST" action="{{ route('summoner.delete')}}">
    @csrf

    <div class="flex items-center justify-end mt-4">
        <x-button
            :class="__('bg-red-500')">
            {{ __('Remove Summoner') }}
        </x-button>
    </div>
</form>

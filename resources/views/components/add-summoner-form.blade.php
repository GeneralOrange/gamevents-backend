<form method="POST" action="{{ route('summoner.find')}}">
    @csrf

    <!-- Summoner name -->
    <div>
        <x-label for="name" :value="__('Summoner name')" />

        <x-input id="name" class="block mt-1 w-full" type="text" name="summoner-name" :value="old('name')" required autofocus />
    </div>

    <div class="flex items-center justify-start mt-4">
        <x-button>
            {{ __('Search') }}
        </x-button>
    </div>
</form>
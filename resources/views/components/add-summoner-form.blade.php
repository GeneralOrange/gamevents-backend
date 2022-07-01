<form method="POST" action="{{ route('summoner.register')}}">
    @csrf

    <!-- Summoner name -->
    <div>
        <x-label for="summoner-name" :value="__('Summoner name')" />

        <x-input id="summoner-name" class="block mt-1 w-full" type="text" name="summoner-name" :value="old('summoner-name')" required autofocus />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button class="ml-4">
            {{ __('Add Summoner') }}
        </x-button>
    </div>
</form>
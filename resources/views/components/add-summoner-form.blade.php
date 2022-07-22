@unless (Auth::user()->summoner)
    <h3 class="font-semibold text-lg text-gray-800 leading-tight">
        {{ __('Add your Summoner')}}
    </h3>
    <form method="POST" action="{{ route('summoner.find')}}">
        @csrf

        <!-- Summoner name -->
        <div>
            <x-label for="name" :value="__('Summoner name')" />

            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>   
            @enderror
        </div>

        <div class="flex items-center justify-start mt-4">
            <x-button>
                {{ __('Add summoner') }}
            </x-button>
        </div>
    </form>
@endunless
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Summoner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">{{ $summoner->name }}</h3>
                    <x-remove-summoner-form/>
                </div>
                <div>
                    <x-match-list :matches="$matches"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
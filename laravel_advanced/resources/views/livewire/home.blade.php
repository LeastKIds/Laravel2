<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('home') }}
        </h2>
    </x-slot>


{{--    <div class="flex flex-row item-center justify-between p-5 bg-white border border-gray-200 rounded shadow-sm">--}}
{{--    </div>--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex my-10 w-12/12 text-gray-900">
                    <div class="w-3/12 px-2 border rounded mx-2">
                        @livewire('user-list')
                    </div>

                    <div class="w-9/12 px-2 border rounded mx-2">
                        @livewire('board')
                    </div>
                </div>

            </div>

        </div>
    </div>



</x-app-layout>

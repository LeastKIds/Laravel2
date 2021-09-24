<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div>
        {{--    --}}{{-- Stop trying to control. --}}


        @foreach($users as $user)
            <div class="p-3 my-2 border rounded shadow {{ $userId == $user -> id ? 'bg-green-400' : '' }}">

                <div class="flex justify-between my-2">
                    <div class="flex ">
                        <p class="text-lg font-bold text-gray-900">
                            {{ $user -> name }}
                        </p>

                        <p class="py-1 mx-3 text-xs font-semibold text-gray-500">
                            {{ $user -> created_at -> diffForHumans() }}
                        </p>
                        <i wire:click="$emit('userSelected', {{ $user -> id }})" class="mx-2 text-red-200 fas fa-info-circle cursor-pointer hover:text-red-600"></i>

                    </div>

                </div>

            </div>
        @endforeach

        {{ $users -> links() }}

    </div>

</div>

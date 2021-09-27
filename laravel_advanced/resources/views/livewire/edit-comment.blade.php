<div class="m-2">
    {{-- Stop trying to control. --}}

    <!-- component -->
        <div class="flex justify-center h-screen items-center bg-gray-200 antialiased">
            <div class="flex flex-col w-11/12 sm:w-5/6 lg:w-1/2 max-w-2xl mx-auto rounded-lg border border-gray-300 shadow-xl">

                <div class="flex flex-col px-6 py-5 bg-gray-50">
                    <p class="mb-2 font-semibold text-gray-700">Comment</p>
                    <textarea wire:model="newComment"
                        type="text"
                        name=""
                        placeholder="Type message..."
                        class="p-5 mb-5 bg-white border border-gray-200 rounded shadow-sm h-36 text-gray-700"
                        id=""
                    ></textarea>

                    <hr />

                    <div class="flex flex-row item-center justify-between p-5 bg-white border border-gray-200 rounded shadow-sm">
                        @if($image)
                            <img src="{{ $image -> temporaryUrl() }}" class="w-10 h-10 mr-3 rounded-full">
                        @elseif($orgComment -> image)
                            <img src="{{ $orgComment -> image_path }}" class="w-10 h-10 mr-3 rounded-full">
                        @endif
                        <input type="file" wire:model="image" wire:loading.attr="disabled" class="text-gray-900">
                        <div wire:loading wire:target="image" class="text-gray-900">Uploading...</div>
                    </div>
                    <div class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg text-gray-900">

                        <button wire:click="$emit('closeModal')" class="px-4 py-2 font-semibold text-white bg-green-500 rounded">Close</button>
                        <button wire:click="$emit('update')" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded">Update</button>

                    </div>

                </div>



            </div>


        </div>


</div>

<div>
{{--    --}}{{-- Stop trying to control. --}}

    <div>
        @if(session() -> has('message'))
            <div class="p-3 text-green-900 bg-green-500 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <section>
        @if($image)
            <img src="{{ $image -> temporaryUrl() }}" width="200">
        @endif
        <input type="file" id="image" wire:model="image" class="text-gray-900" wire:loading.attr="disabled">
            <div wire:loading wire:target="image" class="text-gray-900">
                File Uploading...
            </div>

        @error('image')
            <div class="text-red-700">
                <span>{{ $message }}</span>
            </div>
        @enderror
    </section>

    <form class="flex my-4" wire:submit.prevent="addPost">
        <input wire:model.debounce.500ms="newComment" type="text" class="w-full p-2 my-2 mr-2 border rounded shadow text-gray-900" placeholder="new comment here..."/>

        @error("newComment")
        <div>
            <span class="text-red-800">{{ $message }}</span>
        </div>
        @enderror

        <div class="py-2">
{{--            <span class="text-gray-900"> {{ $newPost }}</span>--}}

            <button class="w-20 p-2 text-white bg-blue-500 rounded shadow">
                Add
            </button>
        </div>


    </form>


    @foreach($comments as $comment)
    <div class="p-3 my-2 border rounded shadow">

        <div class="flex justify-between my-2">
            <div class="flex ">
                <p class="text-lg font-bold text-gray-900">
                    {{ $comment -> writer -> name }}
                </p>

                <p class="py-1 mx-3 text-xs font-semibold text-gray-500">
                    {{ $comment -> created_at -> diffForHumans() }}
                </p>
                <i wire:click="$emit('deleteClicked', {{ $comment -> id }})" class="text-red-200 fas fa-times cursor-pointer hover:text-red-600"></i>
                <i wire:click="$emit('openModal', 'edit-comment', {{ json_encode(['commentId' => $comment -> id]) }})" class="mx-5 text-red-200 fas fa-edit cursor-pointer hover:text-red-600"></i>

            </div>

            <p class="text-gray-800">
                {{ $comment -> content }}
            </p>

            @if($comment -> image)
                <img src="{{ $comment -> image_path }}"/>
            @endif
        </div>

    </div>
    @endforeach

    {{ $comments -> links() }}

</div>

<script>
    window.livewire.on('deleteClicked' ,(id) => {
        if(confirm("Are you sure to delete?")) {
            window.livewire.emit('delete',id);
        } else {
            console.log('false');
        }
    })
</script>

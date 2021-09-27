<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;


class EditComment extends ModalComponent
{
    use WithFileUploads;

    public $commentId;
    public $orgComment;
    public $newComment;
    public $image;

    protected $listeners = [
        'update' => 'updateComment',
    ];

    public function storeImage() {

        $img = ImageManagerStatic::make($this -> image) ->
        resize(300,300) -> encode('jpg');

        $name = Str::random().'.jpg';

//        $this -> image -> storeAs('public/images',$name);
        Storage::disk('public') -> put('/images/'.$name, $img);

        return $name;

    }



    public function updateComment() {
//        $this -> closeModal();
        $this -> validate([
            'newComment' => 'required',
            'image' => 'nullable | image | max:10240'
        ]);


        // 이미지가 있으면 원하는 폴더에 저장하고
        // 저장된 그 파일의 이름을 기억.
        // $imageFileName에 저장
        $imageFileName = null;

        if($this -> image) {
            // 기존 이미지는 삭제를 해야 한다.
            if($this -> orgComment -> image)
                Storage::disk('public') -> delete('/images/'.$this -> orgComment -> image);
            $imageFileName = $this -> storeImage();
            $this -> orgComment -> image = $imageFileName;
        }

        $this -> orgComment -> content = $this -> newComment;
        $this -> orgComment -> save();


        $this -> newComment = '';
        $this -> image = '';

        session() -> flash("message", 'comment updated successfully');
        $this -> closeModal();
        $this -> emit('commentUpdated');
    }

    public function render()
    {
        return view('livewire.edit-comment');
    }

    public function mount($commentId) {
        $this -> commentId = $commentId;
        $this -> orgComment = Comment::find($commentId);
        $this -> newComment = $this -> orgComment -> content;
    }


}

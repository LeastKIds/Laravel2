<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Board extends Component
{

    public $newComment;
    public $image;
    use WithPagination;
    use WithFileUploads;

    protected $listeners = [
        'delete' => 'remove'
    ];

    public function mount() {
        $this -> newComment = "" ;
    }

    protected $rules = [
        'newComment' => 'required',
        'image' => 'image|max:10240|nullable'
    ];

    public function addPost() {

        $this -> validate();


        // 이미지가 있으면 원하는 폴더에 저장하고
        // 저장된 그 파일의 이름을 기억.
        // $imageFileName에 저장
        $imageFileName = null;

        if($this -> image)
            $imageFileName = $this -> storeImage();


        Comment::create(
            [
                'user_id' => auth() -> user() -> id,
                'content' => $this -> newComment,
                'image' => $imageFileName,
            ]
        );

        $this -> newComment = '';
        $this -> image = '';

        session() -> flash("message", 'Post created successfully');
    }

    public function remove($postId) {
        $comments = Comment::find($postId);
        if($this -> image)
            Storage::disk('public') -> delete('images/'.$comments -> image);
        $comments -> delete();

        session() -> flash("message", 'Post deleted successfully');
    }

    public function updated($propertyName) {
        $this -> validateOnly($propertyName);
    }

    public function storeImage() {

        $img = ImageManagerStatic::make($this -> image) ->
        resize(300,300) -> encode('jpg');

        $name = Str::random().'.jpg';

//        $this -> image -> storeAs('public/images',$name);
        Storage::disk('public') -> put('/images/'.$name, $img);

        return $name;

    }

    public function render()
    {

        $comments = Comment::latest() -> paginate(5);

        return view('livewire.board', compact('comments'));
    }


}

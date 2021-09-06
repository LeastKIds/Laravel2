<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Board extends Component
{

    public $newPost;
    use WithPagination;

    protected $listeners = [
        'deleteClicked' => 'remove'
    ];

    public function mount() {
        $this -> newPost = "" ;
    }

    protected $rules = [
        'newPost' => 'required',
    ];

    public function addPost() {


        $this -> validate();


        Comment::create(
            [
                'user_id' => auth() -> user() -> id,
                'content' => $this -> newPost,

            ]
        );

        session() -> flash("message", 'Post created successfully');
    }

    public function remove($postId) {
        $comments = Comment::find($postId);

        $comments -> delete();

        session() -> flash("message", 'Post deleted successfully');
    }

    public function render()
    {

        $comments = Comment::latest() -> paginate(5);

        return view('livewire.board', compact('comments'));
    }


}

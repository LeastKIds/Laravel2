<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class Board extends Component
{

    public function render()
    {

        $posts = Post::all();

        return view('livewire.board', compact('posts'));
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;

class Posts extends Component
{
    public $selectedCategories = [];

    public $posts;

    public $categories;

    protected $queryString = [
        'selectedCategories'
    ];

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id');
        $this->refreshPosts();
    }

    public function render()
    {
        return view('livewire.posts', [
            'selectedCategories' => $this->selectedCategories,
            'categories' => $this->categories,
            'posts' => $this->posts
        ]);
    }

    public function refreshPosts()
    {
        $this->posts = Post::with('categories')
            ->where(function ($query) {
                $query->when(!empty($this->selectedCategories), function ($query) {
                    $query->whereHas('categories', function ($query) {
                        $query->whereIn('id', $this->selectedCategories);
                    })->orWhereDoesntHave('categories');
                });
            })
            ->where('start_date', '<', now())
            ->where('end_date', '>', now())
            ->orderByDesc('start_date')
            ->get();
    }

    public function filterCategories($id)
    {
        if (($key = array_search($id, $this->selectedCategories)) !== false) {
            unset($this->selectedCategories[$key]);
        } else {
            $this->selectedCategories[] = $id;
        }

        $this->refreshPosts();
    }
}

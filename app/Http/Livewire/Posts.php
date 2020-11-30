<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;

class Posts extends Component
{
    public $selectedCategories = [];

    public $categories;

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id');
    }

    public function render()
    {
        $posts = Post::with('categories')
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

        return view('livewire.posts', [
            'selectedCategories' => $this->selectedCategories,
            'categories' => $this->categories,
            'posts' => $posts
        ]);
    }

    public function filterCategories($id)
    {
        if (($key = array_search($id, $this->selectedCategories)) !== false) {
            unset($this->selectedCategories[$key]);
        } else {
            $this->selectedCategories[] = $id;
        }
    }
}

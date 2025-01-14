<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class VideoPlayer extends Component
{
    public $video;
    public $courseVideos;

    public function mount($video)
    {
        $this->courseVideos = $this->video->course->videos;
    }

    public function render(): View
    {
        return view('livewire.video-player');
    }

    public function nextVideo()
    {
        $this->video = $this->courseVideos->firstWhere('id', '>', $this->video->id);
    }

    public function markVideoAsCompleted(): void
    {
        auth()->user()->videos()->attach($this->video);
    }

}

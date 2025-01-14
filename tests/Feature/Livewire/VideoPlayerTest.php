<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows details for given video', function () {
    // Arrange
    $course = Course::factory()->has(Video::factory())->create();

    // Act & Assert
    $video = $course->videos->first();
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_in_min} min)",
        ]);
});

it('shows given video', function () {
    // Arrange
    $course = Course::factory()->has(Video::factory())->create();

    // Act & Assert
    $video = $course->videos->first();
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"');
});

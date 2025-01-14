<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('shows details for given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state([
            'title' => 'Video title',
            'description' => 'Video description',
            'duration' => 10,
        ]))
        ->create();

    // Act & Assert
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSeeText([
            'Video title',
            'Video description',
            '10min',
        ]);
});

it('shows given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state([
            'vimeo_id' => 'vimdeo-id',
        ]))
        ->create();

    // Act & Assert
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSee('<iframe src="https://player.vimeo.com/video/vimdeo-id"', false);

});

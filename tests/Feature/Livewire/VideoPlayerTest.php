<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createCourseAndVideos(int $videosCount = 1): Course
{
    return Course::factory()->has(Video::factory($videosCount))->create();
}

it('shows details for given video', function () {
    // Arrange
    $course = createCourseAndVideos(1);

    // Act & Assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_in_min} min)",
        ]);
});

it('shows given video', function () {
    // Arrange
    $course = createCourseAndVideos(1);

    // Act & Assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"');
});

it('shows list of all course videos', function () {
    // Arrange
    // $course = Course::factory()
    //     ->has(Video::factory()
    //         ->count(3)
    //         ->state(
    //             new Sequence(
    //                 ['title' => 'First Video'],
    //                 ['title' => 'Second Video'],
    //                 ['title' => 'Third Video'],
    //             )
    //         )
    //     )
    //     ->create();
    $course = createCourseAndVideos(videosCount: 3);


    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            ...$course->videos->pluck('title')->toArray(),
        ])
        ->assertSeeHtml([
            // removed check for link to current video because we don't show one
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('does not include route for current video', function () {
    // Arrange
    $course = createCourseAndVideos(videosCount: 1);

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertDontSeeHtml([
            route('pages.course-videos', $course->videos()->first()),
        ]);
});

it('marks video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    // $course = Course::factory()->has(Video::factory()->state(['title' => 'Course Video']))->create();
    $course = createCourseAndVideos(videosCount: 1);

    $user->purchasedCourses()->attach($course);

    // Assert
    expect($user->watchedVideos)->toHaveCount(0);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsCompleted')
        ->call('markVideoAsCompleted')
        ->assertMethodNotWired('markVideoAsCompleted')
        ->assertMethodWired('markVideoAsNotCompleted');

    // Assert
    $user->refresh();
    expect($user->watchedVideos)
        ->toHaveCount(1)
        ->first()->title->toEqual($course->videos()->first()->title);
});

it('marks video as not completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = createCourseAndVideos(videosCount: 1);

    $user->purchasedCourses()->attach($course);
    $user->watchedVideos()->attach($course->videos()->first());

    // Assert
    expect($user->watchedVideos)->toHaveCount(1);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    // Assert
    $user->refresh();
    expect($user->watchedVideos)
        ->toHaveCount(0);
});

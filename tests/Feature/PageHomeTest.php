<?php

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', closure: function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'description' => 'Description Course A']);
    Course::factory()->create(['title' => 'Course B', 'description' => 'Description Course B']);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Description Course C']);

    // Act & Assert
    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Description Course A',
            'Course B',
            'Description Course B',
            'Course C',
            'Description Course C',
        ]);
});

it('shows only released courses', function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    // Act & Assert
    get(route('home'))
        ->assertSeeText([
            'Course A'
        ]);

    get(route('home'))
        ->assertDontSee([
            'Course B'
        ]);
});

it('shows courses by release date', function () {
    // Arrange

    // Act

    // Assert

});

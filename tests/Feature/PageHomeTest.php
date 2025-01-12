<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', closure: function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A']);
    Course::factory()->create(['title' => 'Course B']);
    Course::factory()->create(['title' => 'Course C']);

    // Act & Assert
    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Course B',
            'Course C',
        ]);
});

it('shows only released courses', function () {
    // Arrange

    // Act

    // Assert
});

it('shows courses by release date', function () {
    // Arrange

    // Act

    // Assert

});

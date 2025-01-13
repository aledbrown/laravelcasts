<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only returns released courses for released scope', function () {

    // Arrange
    $releasedCourse = Course::factory()->released()->create();
    $notReleasedCourse = Course::factory()->create();

    // Act & Assert
    expect(Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

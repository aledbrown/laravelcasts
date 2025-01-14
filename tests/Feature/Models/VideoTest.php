<?php

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(
        ['duration_in_min' => 10]
    );

    // Act & Assert
    expect($video->getReadableDuration())->toEqual('10 min');
});

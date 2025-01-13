<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('cannot be accessed by guest', function () {
    // Act & Assert
    \Pest\Laravel\get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange

    // Act

    // Assert
});

it('does not list other courses', function () {
    // Arrange

    // Act

    // Assert
});

it('shows latest purchased course first', function () {
    // Arrange

    // Act

    // Assert
});

it('includes link to product videos', function () {
    // Arrange

    // Act

    // Assert
});

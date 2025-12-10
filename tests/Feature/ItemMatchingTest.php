<?php

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('creating a matching found item sends a notification to lost item owner', function () {
    // Create two users: one who lost, one who found
    $lostOwner = User::factory()->create();
    $foundOwner = User::factory()->create();

    // Existing LOST item (belongs to lostOwner)
    $lostItem = Item::create([
        'title'       => 'Lost black Samsung phone',
        'description' => 'I lost a black Samsung Galaxy phone near the city park.',
        'category'    => 'Electronics',
        'status'      => 'lost',
        'city'        => 'Rīga',
        'image'       => null,
        'user_id'     => $lostOwner->id,
    ]);

    // Act as the user who found something and create FOUND item
    $response = $this->actingAs($foundOwner)->post(route('items.store'), [
        'title'       => 'Found Samsung phone',
        'description' => 'Found a black Samsung smartphone near the park in Rīga.',
        'category'    => 'Electronics',   // must match
        'status'      => 'found',         // opposite of lost
        'city'        => 'Rīga',          // must match
        'image'       => null,
    ]);

    $response->assertRedirect(route('items.index'));

    // Reload lostOwner from DB to get fresh notifications
    $lostOwner->refresh();

    // Assert that the lost owner has at least one notification
    expect($lostOwner->notifications)->not()->toBeEmpty();

    // Optionally check that the notification data points to the found item
    $notification = $lostOwner->notifications->first();

    expect($notification->data['message'])->toBe('Possible match found for your item!');
    expect($notification->data['title'])->toBe('Found Samsung phone');
});

<?php

use App\Models\User;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guest cannot access item create page', function () {
    $this->get('/items/create')->assertRedirect('/login');
});

test('authenticated user can view create item page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get('/items/create')
         ->assertStatus(200)
         ->assertSee('Add New Lost or Found Item');
});

test('user can create an item', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/items', [
        'title' => 'Lost Phone',
        'description' => 'Black Samsung found near the park',
        'category' => 'Electronics',
        'status' => 'lost',
        'city' => 'Rīga',
        'image' => UploadedFile::fake()->create('phone.jpg', 100),

    ]);

    $response->assertRedirect('/items');

    $this->assertDatabaseHas('items', [
        'title' => 'Lost Phone',
        'category' => 'Electronics',
        'status' => 'lost',
        'city' => 'Rīga',
        'user_id' => $user->id
    ]);
});

test('user can update their item', function () {
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'user_id' => $user->id,
        'title' => 'Old Title'
    ]);

    $response = $this->actingAs($user)->put("/items/{$item->id}", [
        'title' => 'New Updated Title',
        'description' => $item->description,
        'category' => $item->category,
        'status' => $item->status,
        'city' => $item->city,
    ]);

    $response->assertRedirect("/items/{$item->id}");

    $this->assertDatabaseHas('items', [
        'id' => $item->id,
        'title' => 'New Updated Title'
    ]);
});

test('user can delete their item', function () {
    $user = User::factory()->create();

    $item = Item::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this->actingAs($user)->delete("/items/{$item->id}");

    $response->assertRedirect('/items');

    $this->assertDatabaseMissing('items', [
        'id' => $item->id
    ]);
});

test('user cannot edit someone elses item', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $item = Item::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $this->actingAs($user)
         ->get("/items/{$item->id}/edit")
         ->assertStatus(403);
});

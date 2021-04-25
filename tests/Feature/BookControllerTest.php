<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    public function test_can_fetch_list_of_books()
    {
        // Arrange
        Book::factory(20)->create();

        // Act
        $response = $this->getJson('/api/books');

        // Assert
        $response
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 10)
                    ->etc();
            })
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertOk();
    }

    public function test_can_create_a_book()
    {
        $response = $this->postJson('/api/books', [
            'name' => 'My New Book',
        ]);

        $response
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertCreated();

        $this->assertDatabaseHas('books', [
            'title' => 'My New Book',
        ]);
    }

    public function test_it_validates_name_exsists_when_crating()
    {
        $response = $this->postJson('/api/books', []);

        $response->assertJsonValidationErrors(['name']);
    }

    public function test_it_validates_name_should_be_more_then_3_charactors()
    {
        $response = $this->postJson('/api/books', ['name' => 'ab']);

        $response->assertJsonValidationErrors(['name']);
    }
}

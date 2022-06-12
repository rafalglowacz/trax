<?php

namespace Tests\Feature;

use App\Modules\Cars\Models\Car;
use App\Modules\Trips\Models\Trip;
use App\User;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;

class TripTest extends TestCase
{
    public function test_unauthenticated_user_cannot_create_a_trip()
    {
        $response = $this->post(route('trips.store'));
        $response->assertUnauthorized();
    }

    public function test_user_can_add_a_trip()
    {
        /** @var Car $car */
        $car = factory(Car::class)->create();

        $response = $this->actingAs($car->user)->post(route('trips.store'), [
            'car_id' => $car->id,
            'miles' => 10,
            'date' => '2022-01-01 00:00:00',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('trips', [
            'car_id' => $car->id,
            'miles' => 10,
            'total' => 10,
            'date' => '2022-01-01 00:00:00',
        ]);
    }

    public function test_trip_validation_returns_errors_if_data_invalid()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('trips.store'), [
            'miles' => 'test',
            'date' => 'test',
        ]);

        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors([
            'car_id' => "The car id field is required",
            'miles' => "The miles must be a number",
            'date' => "The date is not a valid date",
        ]);
    }

    public function test_adding_a_trip_calculates_total_miles_based_on_previous_trips()
    {
        /** @var Trip $previousTrip */
        $previousTrip = factory(Trip::class)->create(['date' => '2022-01-01']);

        /** @var Car $car */
        $car = factory(Car::class)->create(['user_id' => $previousTrip->car->user_id]);

        $response = $this->actingAs($car->user)->post(route('trips.store'), [
            'car_id' => $car->id,
            'miles' => 10,
            'date' => '2022-01-02',
        ]);

        $response->assertOk();

        $this->assertDatabaseCount('trips', 2);

        $this->assertDatabaseHas('trips', [
            'miles' => 10,
            'total' => $previousTrip->miles + 10,
            'date' => '2022-01-02',
        ]);
    }

    public function test_adding_a_trip_before_other_trips_updates_total_miles_of_later_trips_and_not_of_previous_ones()
    {
        /** @var Car $car */
        $car = factory(Car::class)->create();

        factory(Trip::class)->create(['date' => '2022-01-01', 'car_id' => $car->id, 'miles' => 10, 'total' => 10]);
        factory(Trip::class)->create(['date' => '2022-01-03', 'car_id' => $car->id, 'miles' => 10, 'total' => 20]);

        $response = $this->actingAs($car->user)->post(route('trips.store'), [
            'car_id' => $car->id,
            'miles' => 10,
            'date' => '2022-01-02',
        ]);

        $response->assertOk();

        $this->assertDatabaseCount('trips', 3);

        $this->assertDatabaseHas('trips', [
            'miles' => 10,
            'total' => 10,
            'date' => '2022-01-01',
        ]);

        $this->assertDatabaseHas('trips', [
            'miles' => 10,
            'total' => 20,
            'date' => '2022-01-02',
        ]);

        $this->assertDatabaseHas('trips', [
            'miles' => 10,
            'total' => 30,
            'date' => '2022-01-03',
        ]);
    }
}

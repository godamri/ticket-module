<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_status' => ['opn', 'cld', 'asn'][rand(0, 2)],
            'ticket_title' => fake()->sentence(),
            'ticket_msg' => fake()->paragraph(),
            'user_id' => rand(1, 9999)
        ];
    }
}

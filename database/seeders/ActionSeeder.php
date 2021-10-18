<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Action;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ActionSeeder extends Seeder
{
    protected Collection $users;

    public function __construct()
    {
        $this->users = User::all();
    }

    public function run(): void
    {
        $this->users
            ->each(
                function ($user) {
                    $this->generateLikes($user)
                        ->each(fn ($action) => Action::create($action));
                }
            );
    }

    /**
     * Generate Like actions for a given user
     *
     * @param User $exceptUser User to avoid
     *
     * @return Collection
     */
    private function generateLikes(User $user): Collection
    {
        $faker = Faker::create();

        return $this->getRandomPeers($user)
            ->map(
                function ($toUser) use ($user, $faker) {
                    return [
                            'from_user_id'  => $user->id,
                            'to_user_id'    => $toUser->id,
                            'name'          => $faker->randomElement(['LIKE', 'DISLIKE', 'SUPERLIKE']),
                            'expiration_at' => $faker->dateTimeBetween('-6 months', '+1 months')->format('Y-m-d'),
                        ];
                }
            );
    }

    /**
     * Return random action user-peers for a given user
     *
     * @param User $exceptUser User to avoid
     * @param integer $max Maximum quantiy of users
     *
     * @return Collection
     */
    private function getRandomPeers(User $exceptUser, int $max = 5): Collection
    {
        return $this->users
            ->random(rand(1, $max))
            ->filter(
                function ($randomUser) use ($exceptUser) {
                    return $randomUser->id !== $exceptUser->id;
                }
            );
    }
}

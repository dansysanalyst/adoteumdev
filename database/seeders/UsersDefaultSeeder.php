<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersDefaultSeeder extends Seeder
{
    protected Collection $skills;

    public function __construct()
    {
        $this->skills = Skill::all();
    }

    public function run(): void
    {
        $this->getUsersData()
            ->each(
                function ($user) {
                    $user =  (object) $user;

                    $user->email = strtolower($user->provider_user_id).'@adoteum.dev';

                    $newUser = User::updateOrCreate(
                        ['email' => $user->email],
                        [
                            'name'      => $user->nickname,
                            'email'     => $user->email,
                            'password'  => bcrypt('password'),
                        ]
                    );

                    $newUser->profile()
                        ->updateOrCreate(
                            ['user_id' => $newUser->id],
                            [
                                'provider'         => 'GITHUB',
                                'provider_user_id' => $user->provider_user_id,
                                'nickname'         => $user->nickname,
                                'avatar'           => 'https://avatars.githubusercontent.com/u/'.$user->avatar_id_url .'?v=4',
                                'data'             => '{}'
                            ]
                        );

                    $newUser->knowledge()->forceDelete();
                    $newUser->interests()->forceDelete();

                    $newUser->knowledge()
                        ->createMany((empty($user->knowledge) ? $this->randomSkills() : $user->knowledge));

                    $newUser->interests()
                        ->createMany((empty($user->interests) ? $this->randomSkills() : $user->interests));
                }
            );
    }

    private function randomSkills(): array
    {
        return $this->skills
            ->random(rand(1, 5))
            ->map(
                function ($skill) {
                    return ['skill_id' => $skill['id'], 'level' => rand(1, 5)];
                }
            )
            ->toArray();
    }

    private function getUsersData(): Collection
    {
        return collect(
            [
                [
                    'provider_user_id' => 'BeerAndCode',
                    'nickname' => 'Beer And Code',
                    'avatar_id_url' => '69223337',
                    'data' => '[]',
                    'knowledge' => [
                        ['skill_id' => 9, 'level' => 5] //php
                    ],
                    'interests' => [
                        ['skill_id' => 42, 'level' => 4] //inglês
                    ]
                ],
                [
                    'provider_user_id' => '33Piter',
                    'nickname' => 'Piter',
                    'avatar_id_url' => '67804835'
                ],
                [
                    'provider_user_id' => 'RafaelBlum',
                    'nickname' => 'Rafael Blum',
                    'avatar_id_url' => '41844692'
                ],
                [
                    'provider_user_id' => 'jailsoncarneiro',
                    'nickname' => 'Jailson Carneiro',
                    'avatar_id_url' => '11988275'
                ],
                [
                    'provider_user_id' => 'patriciomartinns',
                    'nickname' => 'Patrício Martins',
                    'avatar_id_url' => '20000058'
                ],
                [
                    'provider_user_id' => 'Ramaniks',
                    'nickname' => 'Valdecir Neumann',
                    'avatar_id_url' => '1359519'
                ],
                [
                    'provider_user_id' => '12161003677',
                    'nickname' => 'Eliezer Alves',
                    'avatar_id_url' => '23661672'
                ],
                [
                    'provider_user_id' => 'filipeamc',
                    'nickname' => 'Filipe Costa',
                    'avatar_id_url' => '5920120'
                ],
                [
                    'provider_user_id' => 'jbgbruno',
                    'nickname' => 'João Bruno Gomes',
                    'avatar_id_url' => '12560490'
                ],
                [
                    'provider_user_id' => 'Deathpk',
                    'nickname' => 'Michel Versiani',
                    'avatar_id_url' => '40901963'
                ],
                [
                    'provider_user_id' => 'trollfalgar',
                    'nickname' => 'Tiago Oliveira',
                    'avatar_id_url' => '441455'
                ],
                [
                    'provider_user_id' => 'webesistemas',
                    'nickname' => 'Marco Túlio Lacerda',
                    'avatar_id_url' => '7431548'
                ],
                [
                    'provider_user_id' => 'felipe-balloni',
                    'nickname' => 'Felipe Balloni Ferreira',
                    'avatar_id_url' => '19998735'
                ],
                [
                    'provider_user_id' => 'danilosampaioprepara',
                    'nickname' => 'danilosampaioprepara',
                    'avatar_id_url' => '80851888'
                ],
                [
                    'provider_user_id' => 'renatokira',
                    'nickname' => 'Renato Kira',
                    'avatar_id_url' => '10859156'
                ],
                [
                    'provider_user_id' => 'roberto-reis',
                    'nickname' => 'José Roberto',
                    'avatar_id_url' => '39444864'
                ],
                [
                    'provider_user_id' => 'lucenarenato',
                    'nickname' => 'Renato de Oliveira Lucena',
                    'avatar_id_url' => '38870097'
                ],
                [
                    'provider_user_id' => 'aeusteixeira',
                    'nickname' => 'Matheus Teixeira',
                    'avatar_id_url' => '40412362'
                ],
                [
                    'provider_user_id' => 'joaonivaldo',
                    'nickname' => 'Joao Nivaldo',
                    'avatar_id_url' => '4040086'
                ],
                [
                    'provider_user_id' => 'girordo',
                    'nickname' => 'Tarcísio Giroldo Siqueira',
                    'avatar_id_url' => '54643911'
                ],
                [
                    'provider_user_id' => 'vs0uz4',
                    'nickname' => 'Vitor Rodrigues',
                    'avatar_id_url' => '2080547'
                ],
                [
                    'provider_user_id' => 'cpereiraweb',
                    'nickname' => 'Claudio Pereira',
                    'avatar_id_url' => '1045328'
                ],
                [
                    'provider_user_id' => 'luanfreitasdev',
                    'nickname' => 'Luan Freitas',
                    'avatar_id_url' => '33601626'
                ],
                [
                    'provider_user_id' => 'jeffersonsevero',
                    'nickname' => 'Jefferson Severo ',
                    'avatar_id_url' => '37408502'
                ],
                [
                    'provider_user_id' => 'LucasSouzaa',
                    'nickname' => 'Virgu',
                    'avatar_id_url' => '8497589'
                ],
                [
                    'provider_user_id' => 'Reinaldo92',
                    'nickname' => 'Reinaldo Jr',
                    'avatar_id_url' => '39837626'
                ],
                [
                    'provider_user_id' => 'marciojduarte',
                    'nickname' => 'Márcio J. Duarte',
                    'avatar_id_url' => '45566764'
                ],
                [
                    'provider_user_id' => 'josedafonsecajr',
                    'nickname' => 'josedafonsecajr',
                    'avatar_id_url' => '58943299'
                ],
                [
                    'provider_user_id' => 'celsodavid',
                    'nickname' => 'Celso David',
                    'avatar_id_url' => '5132545'
                ],
                [
                    'provider_user_id' => 'guilhermepolicarpo',
                    'nickname' => 'Guilherme Policarpo Silva',
                    'avatar_id_url' => '13804537'
                ],
                [
                    'provider_user_id' => 'onesimodev',
                    'nickname' => 'Onesimo',
                    'avatar_id_url' => '88942470'
                ],
                [
                    'provider_user_id' => 'icarojobs',
                    'nickname' => 'Tio Jobs',
                    'avatar_id_url' => '16943171'
                ],
                [
                    'provider_user_id' => 'dansysanalyst',
                    'nickname' => 'Dan (IA)',
                    'avatar_id_url' => '79267265'
                ],
            ]
        );
    }
}

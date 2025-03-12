<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /** 
     * Valores a serem inseridos na tabela
    */
    private array $fields = [
        [
            'title' => 'Minha primeira anotação',
            'category' => 'Futebol',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula venenatis eros, quis pellentesque metus sodales eu. Quisque id vestibulum mi. Praesent id nulla ut neque suscipit elementum eu non nunc. Sed posuere diam at felis ultricies porta. Ut enim nisl, lobortis id leo id, ultrices mollis magna. Sed eu metus eget metus iaculis sagittis. Aliquam consectetur ultrices felis sed pellentesque. Sed commodo cursus sagittis. Nullam et imperdiet purus, ut faucibus mi. Sed eget blandit lorem. Praesent molestie tortor est, quis ornare orci porttitor sit amet. Integer sagittis nisi ligula, non ultricies augue pulvinar in. Praesent mattis dui ac sapien ullamcorper interdum.

            Maecenas vitae lacus pulvinar, lobortis diam vitae, varius enim. Etiam lacinia congue ipsum, quis pretium eros rhoncus ac. Etiam a interdum nulla. Maecenas vestibulum elit neque, non lacinia dui egestas eu. Sed sagittis condimentum porttitor. Cras ac augue quis ex hendrerit luctus eu id nulla. Sed fermentum tellus a mi placerat convallis id non mauris. Aenean id elit gravida, commodo lacus in, mollis est.',
            'id_user' => '1'
        ],
        [
            'title' => 'Minha segunda anotação',
            'category' => 'Moda',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula venenatis eros, quis pellentesque metus sodales eu. Quisque id vestibulum mi. Praesent id nulla ut neque suscipit elementum eu non nunc. Sed posuere diam at felis ultricies porta. Ut enim nisl, lobortis id leo id, ultrices mollis magna. Sed eu metus eget metus iaculis sagittis. Aliquam consectetur ultrices felis sed pellentesque. Sed commodo cursus sagittis. Nullam et imperdiet purus, ut faucibus mi. Sed eget blandit lorem. Praesent molestie tortor est, quis ornare orci porttitor sit amet. Integer sagittis nisi ligula, non ultricies augue pulvinar in. Praesent mattis dui ac sapien ullamcorper interdum.

            Maecenas vitae lacus pulvinar, lobortis diam vitae, varius enim. Etiam lacinia congue ipsum, quis pretium eros rhoncus ac. Etiam a interdum nulla. Maecenas vestibulum elit neque, non lacinia dui egestas eu. Sed sagittis condimentum porttitor. Cras ac augue quis ex hendrerit luctus eu id nulla. Sed fermentum tellus a mi placerat convallis id non mauris. Aenean id elit gravida, commodo lacus in, mollis est.',
            'id_user' => '1'
        ],
        [
            'title' => 'Nova anotação',
            'category' => 'Video game',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula venenatis eros, quis pellentesque metus sodales eu. Quisque id vestibulum mi. Praesent id nulla ut neque suscipit elementum eu non nunc. Sed posuere diam at felis ultricies porta. Ut enim nisl, lobortis id leo id, ultrices mollis magna. Sed eu metus eget metus iaculis sagittis. Aliquam consectetur ultrices felis sed pellentesque. Sed commodo cursus sagittis. Nullam et imperdiet purus, ut faucibus mi. Sed eget blandit lorem. Praesent molestie tortor est, quis ornare orci porttitor sit amet. Integer sagittis nisi ligula, non ultricies augue pulvinar in. Praesent mattis dui ac sapien ullamcorper interdum.

            Maecenas vitae lacus pulvinar, lobortis diam vitae, varius enim. Etiam lacinia congue ipsum, quis pretium eros rhoncus ac. Etiam a interdum nulla. Maecenas vestibulum elit neque, non lacinia dui egestas eu. Sed sagittis condimentum porttitor. Cras ac augue quis ex hendrerit luctus eu id nulla. Sed fermentum tellus a mi placerat convallis id non mauris. Aenean id elit gravida, commodo lacus in, mollis est.',
            'id_user' => '2'
        ],
        [
            'title' => 'Outra anotação',
            'category' => 'Trem',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula venenatis eros, quis pellentesque metus sodales eu. Quisque id vestibulum mi. Praesent id nulla ut neque suscipit elementum eu non nunc. Sed posuere diam at felis ultricies porta. Ut enim nisl, lobortis id leo id, ultrices mollis magna. Sed eu metus eget metus iaculis sagittis. Aliquam consectetur ultrices felis sed pellentesque. Sed commodo cursus sagittis. Nullam et imperdiet purus, ut faucibus mi. Sed eget blandit lorem. Praesent molestie tortor est, quis ornare orci porttitor sit amet. Integer sagittis nisi ligula, non ultricies augue pulvinar in. Praesent mattis dui ac sapien ullamcorper interdum.

            Maecenas vitae lacus pulvinar, lobortis diam vitae, varius enim. Etiam lacinia congue ipsum, quis pretium eros rhoncus ac. Etiam a interdum nulla. Maecenas vestibulum elit neque, non lacinia dui egestas eu. Sed sagittis condimentum porttitor. Cras ac augue quis ex hendrerit luctus eu id nulla. Sed fermentum tellus a mi placerat convallis id non mauris. Aenean id elit gravida, commodo lacus in, mollis est.',
            'id_user' => '3'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->fields as $value) {
            DB::table('notes')->insert($value);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => 'Tecnology'
        ]);

        Tag::create([
            'name' => 'Career Advice'
        ]);

        Tag::create([
            'name' => 'Motivation'
        ]);

        Tag::create([
            'name' => 'Investing'
        ]);

        Tag::create([
            'name' => 'Finance'
        ]);

        Tag::create([
            'name' => 'Relationships'
        ]);

        Tag::create([
            'name' => 'Learning'
        ]);

        Tag::create([
            'name' => 'Politics'
        ]);

        Tag::create([
            'name' => 'Discoveries'
        ]);
        
        Tag::create([
            'name' => 'Scientific Theories'
        ]);
    }
}

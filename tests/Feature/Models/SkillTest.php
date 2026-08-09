<?php

namespace Tests\Feature\Models;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_fields_can_be_mass_assigned(): void
    {
        $skill = Skill::create([
            'category' => 'Languages',
            'name' => 'PHP',
            'sort_order' => '3',
        ]);

        $this->assertSame('Languages', $skill->category);
        $this->assertSame('PHP', $skill->name);
        $this->assertSame(3, $skill->sort_order);
        $this->assertIsInt($skill->sort_order);
    }
}

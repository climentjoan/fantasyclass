<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Skill;

class SkillsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $skills = $class->skills;

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings['skill_price'] = settings()->get('skill_price', 600);
        $settings['skill_enabled'] = settings()->get('skill_enabled', 0);

        return view('skills.index', compact('class', 'skills', 'settings'));
    }

    public function get($code) {
            $class = Classroom::where('code', $code)->firstOrFail();
            $this->authorize('view', $class);
            
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t1'));
            $images[0]['images'] = $array;
            $images[0]['name'] = "t1";
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t2'));
            $images[1]['images'] = $array;
            $images[1]['name'] = "t2";
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t3'));
            $images[2]['images'] = $array;
            $images[2]['name'] = "t3";
            return $images;
    }
   
    public function importDefault($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        // Active skills
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'question',
            'description' => 'question_desc',
            'icon' => '/img/skills/t1/rpg-priest_active_12.png',
            'type' => 0,
            'properties' => json_encode([
                'type' => 'common',
            ]),
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'music',
            'description' => 'music_desc',
            'icon' => '/img/skills/t1/skills_skill_icon_7.png',
            'type' => 0,
            'properties' => json_encode([
                'type' => 'common',
            ]),
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'heal_self',
            'description' => 'heal_self_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_11.png',
            'type' => 0,
            'properties' => json_encode([
                'hp_min' => 5,
                'hp_max' => 20,
                'type' => 'heal_self',
            ]),
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'heal_group',
            'description' => 'heal_group_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_2.png',
            'type' => 0,
            'properties' => json_encode([
                'hp_min' => 5,
                'hp_max' => 20,
                'type' => 'heal_group',
            ]),
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'heal_classroom',
            'description' => 'heal_classroom_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_3.png',
            'type' => 0,
            'properties' => json_encode([
                'hp_min' => 5,
                'hp_max' => 20,
                'type' => 'heal_classroom',
            ]),
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'steal_money',
            'description' => 'steal_money_desc',
            'icon' => ' /img/skills/t1/rpg-rogue_active12.png',
            'type' => 0,
            'properties' => json_encode([
                'money_min' => 50,
                'money_max' => 150,
                'type' => 'steal_money',
            ]),
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'steal_xp',
            'description' => 'steal_xp_desc',
            'icon' => '/img/skills/t1/rpg-rogue_active10.png',
            'type' => 0,
            'properties' => json_encode([
                'xp_min' => 50,
                'xp_max' => 100,
                'type' => 'steal_xp',
            ]),
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'undo_action',
            'description' => 'undo_action_desc',
            'icon' => '/img/skills/t1/game_skill_17.png',
            'type' => 0,
            'properties' => json_encode([
                'success' => 60,
                'type' => 'undo_action',
            ]),
        ]);

           /* Active types:
                - Ask a question (yes or not) to the teacher in an exam.
                - Heal.
                - Heal group.
                - Heal everybody.
                - Steal random student money.
                - Steal random xp.
                - Undo last lose (50% rate).
            */

            // Passive

            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'heal_passive',
                'description' => 'heal_passive_desc',
                'icon' => '/img/skills/t1/skills_skill_icon_44.png',
                'type' => 1,
                'properties' => json_encode([
                    'success' => 50,
                    'hp_increment' => 50,
                    'type' => 'heal_passive',
                ]),
            ]);

            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'protection',
                'description' => 'protection_desc',
                'icon' => '/img/skills/t1/rpg-knight_active6.png',
                'type' => 1,
                'properties' => json_encode([
                    'success' => 20,
                    'type' => 'protection',
                ]),
            ]);

            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'protection',
                'description' => 'protection_desc',
                'icon' => '/img/skills/t1/rpg-knight_active13.png',
                'type' => 1,
                'properties' => json_encode([
                    'success' => 40,
                    'type' => 'protection',
                ]),
            ]);
            
            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'protection_steal',
                'description' => 'protection_steal_desc',
                'icon' => '/img/skills/t1/rpg-mage_active12.png',
                'type' => 1,
                'properties' => json_encode([
                    'success' => 70,
                    'type' => 'protection_steal',
                ]),
            ]);

            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'cards',
                'description' => 'cards_desc',
                'icon' => '/img/skills/t1/rpg-rogue_active1.png',
                'type' => 1,
                'properties' => json_encode([
                    'cards' => 1,
                    'type' => 'cards',
                ]),
            ]);

            Skill::create([
                'classroom_id' => $class->id,
                'name' => 'protection_death',
                'description' => 'protection_death_desc',
                'icon' => '/img/skills/t1/game_skill_32.png',
                'type' => 1,
                'properties' => json_encode([
                    'success' => 90,
                    'type' => 'protection_death',
                ]),
            ]);

            /* Passive types:
                - Health individual.
                X Health group.
                X Health everybody.
                - Protection. (rate 50%)
                - Protection against steals (rate 70%).
                - Carry 1 more card.
            */

        return $class->fresh()->skills;

    }



    // public function update($code) {
    //     $class = Classroom::where('code', $code)->firstOrFail();
    //     $this->authorize('update', $class);
    
    //     $data = request()->validate([
    //         'monster.id' => ['numeric'],
    //         'monster.name' => ['required', 'string'],
    //         'monster.image' => ['required', 'string'],
    //         'monster.hp' => ['numeric', 'required'],
    //         'monster.reward_xp' => ['numeric', 'required'],
    //         'monster.reward_gold' => ['numeric', 'required'],
    
    //     ]);

    //     $data['monster']['hp'] = max($data['monster']['hp'], 0); 
    //     $data['monster']['hp'] = min($data['monster']['hp'], 100); 

    //     $monster = Monster::find($data['monster']['id']);
    //     if($monster->classroom_id != $class->id)
    //         abort(403, 'What are you trying? :(');
        
    //     $monster->update($data['monster']);
    // }

    // public function battle() {
    //     $monster = Monster::findOrFail(request()->id);
    //     $class = Classroom::findOrFail($monster->classroom_id);
    //     $this->authorize('update', $class);

    //     $monster->update([
    //         'hp' => max(0 , $monster->hp + request()->value), 
    //     ]);

    // }

    public function store($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'skill.name' => ['required', 'string'],
            'skill.description' => ['nullable', 'string'],
            'skill.icon' => ['required', 'string'],
            'skill.type' => ['numeric', 'required'],
            'skill.properties' => ['json', 'nullable'],
        ]);

        $data['skill']['classroom_id'] = $class->id;
        return Skill::create($data['skill']);
    }



    public function destroy($id) {

        $skill = Skill::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $skill->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $skill->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;

    }
}

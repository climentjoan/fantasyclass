<?php

namespace App;

use App\Http\Classes\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Question extends Model
{
    protected $fillable = [
        'name',
        'challenge_id',
        'question_bank_id',
        'type',
        'options',
    ];


    protected $casts = [
        'options' => 'array',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('answer');
    }

    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function getTeacherInfo() {

        $class = Classroom::where('id', '=', $this->challenge->classroom())->first();
        $answered = 0;
        $answeredOK = $answeredKO = $remainning = [];
        $students = $class->students;
        foreach ($students as $student) {
            $info = $this->getStudentInfo($student);
            if(isset($info['answered']) && $info['answered']) {
                $answered++;
                if($info['correct'])
                    $answeredOK[] = $student->name;
                else $answeredKO[]  = $student->name;
            } else $remainning[] = $student->name;
        }
        return ['answered' => $answered, 'answeredOK' => $answeredOK, 'answeredKO' => $answeredKO, 'remainning' => $remainning];
    }

    public function getStudentInfo($student = null)
    {
        $class = Classroom::where('id', '=', $this->challenge->classroom())->first();
        if(!$student)
            $student = Functions::getCurrentStudent($class, []);
        $answers = collect();
        $answer = $student->questions()->where('question_id', '=', $this->id)->first();
        if ($answer) {
            if($this->type == 1) {
                $correct = head(Arr::where($this->options, function ($value, $key) {
                    return isset($value['correctAnswer']);
                }));
                $correctText = Arr::where($this->options, function ($value, $key) use ($correct) {
                    if (isset($value['answer']))
                        return $value['answer']['id'] == $correct['correctAnswer'];
                });
                if ($answer->pivot->answer == $correct['correctAnswer']) {
                    return ['question' => $this['name'], 'type' => $this->type, 'answered' => true, 'correct' => true, 'answerOK' => head($correctText)];
                } else {
                    $incorrect = Arr::where($this->options, function ($value, $key) use ($answer) {
                        if (isset($value['answer']))
                            return $answer->pivot->answer == $value['answer']['id'];
                    });
                    return ['question' => $this['name'], 'type' => $this->type, 'answered' => true, 'correct' => false, 'answerOK' => head($correctText), 'answerKO' => head($incorrect)];
                }
            } else if($this->type == 2) {
                $answers = "";
                foreach ($this->options as $option) {
                    $answers .= $option['answer'] . ". ";
                    if($option['caseSensitive']) {
                        $result = strcmp($answer->pivot->answer, $option['answer']);
                    } else {
                        $result = strcasecmp($answer->pivot->answer, $option['answer']);
                    }
                    if($result === 0) {
                        return ['question' => $this['name'], 'type' => $this->type, 'answered' => true, 'correct' => true, 'answerOK' => $answer->pivot->answer]; 
                    }
                }
                return ['question' => $this['name'], 'type' => $this->type, 'answered' => true, 'correct' => false, 'answerKO' => $answer->pivot->answer, 'answerOK' => $answers]; 

            }
        } else {
            foreach ($this->options as $option) {
                if ($this->type == 1 && isset($option['answer'])) {
                    $answers->add(['id' => $option['answer']['id'], 'answer' => $option['answer']['text']]);
                } else if($this->type == 2) {
                    return ['id' => $this['id'], 'type' => $this->type, 'question' => $this['name']];
                }
            }
            return ['id' => $this['id'], 'question' => $this['name'], 'type' => $this->type, 'answers' => $answers->shuffle()];
        }
    }
}

<?php

namespace App\Models\Parser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * @package App\Models\Parser
 *
 * @property $id
 * @property $group_id
 * @property $day
 * @property $subject
 * @property $number_subject
 * @property $number_week
 * @property $created_at
 * @property $updated_at
 *
 */
class Schedule extends Model
{
    use HasFactory;
    protected array $guarded = [];

    /**
     * @param array $scheduleInfo
     * @return bool|string
     */
    public static function insertSubjects(array $scheduleInfo)
    {
        try{
            foreach ($scheduleInfo['schedule'] as $titleGroup => $scheduleGroup){
                $group = Group::where([['title','=', $titleGroup], ['course','=', $scheduleInfo['course']]])->first();
                if (!empty($group)){
                    foreach ($scheduleGroup as $day => $subjects){
                        $week = (mb_stripos($day,"(2)") !== false) ? 2 : 1;
                        if(!empty($subjects)){
                            foreach ($subjects as $numberSubject => $subject){
                                $schedule = new self;
                                $schedule->day = $day;
                                $schedule->group_id = $group->id;
                                $schedule->subject = $subject;
                                $schedule->number_subject = $numberSubject;
                                $schedule->number_week = $week;
                                $schedule->save();
                            }
                        }
                    }
                }
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

        return true;
    }
}

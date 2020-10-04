<?php

namespace App\Models\Parser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * Class Group
 * @package App\Models\Parser
 * @property $title
 * @property $course
 * @property $faculty_id
 * @property $created_at
 * @property $updated_at
 */
class Group extends Model
{
    use HasFactory;
    protected array $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(Schedule::class, 'group_id', 'id');
    }

    /**
     * @param array $scheduleInfo
     * @return bool
     */
    public static function insertGroups(array $scheduleInfo)
    {
        $faculty = Faculty::where('title', '=', $scheduleInfo['faculty'])->first();

        if (!empty($faculty)){
            foreach ($scheduleInfo['schedule'] as $titleGroup => $Group)
            {
                $group = new self;
                $group->title = $titleGroup;
                $group->course = $scheduleInfo['course'];
                $group->faculty_id = $faculty->id;

                if(!$group->save()){
                    throw new QueryException();
                }
            }
        }

        return true;
    }

}

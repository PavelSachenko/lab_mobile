<?php

namespace App\Models\Parser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\XmlConfiguration\Groups;

/**
 * Class Faculty
 * @package App\Models\Parser
 *
 * @property $id
 * @property $title
 * @property $created_at
 * @property $updated_at
 */
class Faculty extends Model
{
    use HasFactory;
    protected array $guarded = [];

    public function groups()
    {
        return $this->hasMany(Groups::class, 'faculty_id', 'id');
    }
}

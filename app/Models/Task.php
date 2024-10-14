<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $status
 * @property $dueDate
 * @property $created_at
 * @property $updated_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class Task extends Model
{
    use HasFactory;

    public static array $rules = [];

    protected $guarded = [
        '_token',
    ];

    /**
     * returns an array with the text label of the statuses
     */
    public static function statusText()
    {
        return [
            0 => 'Incomplete',
            1 => 'Complete',
        ];
    }

    /**
     * Changes the icon shown after toggling a task's status
     *
     * @param integer $status
     * @return string
     */
    public static function toggleSrc(int $status = 0): string
    {
        return $status === 0 ? 'assets/img/switch-off.svg' : 'assets/img/switch-on.svg';
    }
}

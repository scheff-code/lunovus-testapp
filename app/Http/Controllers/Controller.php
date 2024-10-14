<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $sort = '';
    protected string $sort_icon = '';
    protected static array $skip_columns = ['sort', 'sort_order', 'page'];

    /**
     * @param $model
     * @param int $currentUserOnly
     * @return mixed
     */
    protected function applyFilters($model, int $currentUserOnly = 1): mixed
    {
        $pairs = \request()->query();

        // This ensures the query only includes the current user's tasks
        if ($currentUserOnly) {
            $pairs['user_id'] = Auth::user()->id;
        }

        $models = (new $model())->where([
            [function ($query) use ($pairs) {
                foreach ($pairs as $column => $val) {
                    if ($val != '' && !in_array($column, self::$skip_columns)) {
                        $query->where($column, 'LIKE', '%'.$val.'%')->get();
                    }
                }
            }],
        ]);

        if (isset($pairs['sort'])) {
            $sort_order = 'asc';
            if (isset($pairs['sort_order'])) {
                $sort_order = $pairs['sort_order'];
            }
            $models->orderBy($pairs['sort'], $sort_order);
        }

        return $models;
    }

    protected static function sortIcon($get): string
    {
        if (isset($get['sort_order']) && $get['sort_order'] !== '') {
            if ($get['sort_order'] === 'asc') {
                return 'down';
            }
            return 'up';
        }
        return '';
    }


}

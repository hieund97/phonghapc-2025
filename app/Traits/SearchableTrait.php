<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Nicolaslopezj\Searchable\SearchableTrait as BaseSearchableTrait;

/**
 * nicolaslopezj/searchable gộp binding của global scope hai lần trên Laravel 9+
 * (Eloquent\Builder::getBindings() đã áp global scope), làm paginate() lỗi HY093.
 */
trait SearchableTrait
{
    use BaseSearchableTrait;

    protected function mergeQueries(Builder $clone, Builder $original)
    {
        $tableName = DB::connection($this->connection)->getTablePrefix() . $this->getTable();

        if ($this->isPostgresqlDatabase()) {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as {$tableName}"));
        } else {
            $original->from(DB::connection($this->connection)->raw("({$clone->toSql()}) as `{$tableName}`"));
        }

        $original->withoutGlobalScopes();

        $original->setBindings(array_merge_recursive(
            $clone->getBindings(),
            $original->getBindings()
        ));
    }
}

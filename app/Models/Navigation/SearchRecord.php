<?php

namespace App\Models\Navigation;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SearchRecord extends Model
{
    protected $table = 'navigation_site_search_records';

    protected $fillable = [
        'id',
        'search_id',
        'keyword',
        'ip',
    ];

    public static function getRecordTableName($ym = null)
    {
        if (is_null($ym)) $ym = Carbon::today()->format('Ym');
        $tableName = 'navigation_site_search_records_'.$ym;

        if (!Schema::hasTable($tableName)) {
            $function = self::createRecordTable();
            Schema::create($tableName, $function);
        }

        return $tableName;
    }

    public static function createRecordTable()
    {
        return function (Blueprint $table) {
            $table->increments('id');
            $table->integer('search_id')->nullable()->comment('关联搜索ID');
            $table->string('keyword', 32)->comment('搜索关键字');
            $table->ipAddress('ip')->nullable()->comment('搜索时的IP');
            $table->timestamp('created_at')->nullable();
            $table->index('keyword');
        };
    }
}

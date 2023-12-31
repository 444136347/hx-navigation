<?php

namespace App\Admin\Repositories\Navigation;

use Dcat\Admin\Repositories\QueryBuilderRepository;
use App\Models\Navigation\SearchRecord as SearchRecordModel;

class SearchRecord extends QueryBuilderRepository
{
    // 设置你的主键名称
    protected $keyName = 'id';

    public function __construct(string $ym = null)
    {
        $tableName = SearchRecordModel::getRecordTableName($ym);
        $this->table = $tableName;
        $this->initQueryBuilder();
    }

    // 通过这个方法可以指定查询的字段，默认"*"
    public function getGridColumns()
    {
        return [$this->getKeyName(), 'keyword', 'ip','created_at'];
    }

}

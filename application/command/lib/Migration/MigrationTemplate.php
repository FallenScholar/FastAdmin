<?php

namespace databases;

use think\Db;

/**
 * Class MigrationTemplate
 * @author 流萤慕扇
 * @version 1.0.0
 */
class MigrationTemplate
{
    public function run()
    {
        Db::execute(
<<<SQL
    create table `table_name` (
        `id` bigint NOT NULL auto_increment primary key ,
        `create_time` bigint DEFAULT NULL COMMENT '创建时间',
        `update_time` bigint DEFAULT NULL COMMENT '更新时间'
    ) engine innoDb comment '';
SQL
        );
    }

    public function rollback()
    {
        Db::execute("drop table `table_name`;");
    }
}
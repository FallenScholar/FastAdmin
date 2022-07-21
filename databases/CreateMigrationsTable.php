<?php

namespace databases;

use think\Db;

/**
 * Class CreateMigrationsTable
 * @author 流萤慕扇
 * @version 1.0.0
 */
class CreateMigrationsTable
{
    public function run()
    {
        Db::execute(
<<<SQL
    create table `migrations` (
        `id` bigint NOT NULL auto_increment primary key ,
        `class` varchar(100) not null commit '表名',
        `batch` int not null default 1 commit '批次',
        `create_time` bigint DEFAULT NULL COMMENT '创建时间'
    ) engine innoDb comment '转移记录';
SQL
        );
    }

    public function rollback()
    {
        Db::execute("drop table `migrations`;");
    }
}
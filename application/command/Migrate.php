<?php
/**
 * @author  流萤慕扇
 * @date 2022/7/16
 */
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\exception\DbException;

/**
 * Class Migrate
 * 执行迁移文件
 * @author  流萤慕扇
 * @version 1.0.0
 */
class Migrate extends Command
{
    const MIGRATION_FILE = 'CreateMigrationsTable.php';
    const MIGRATION = APP_PATH . 'command\\lib\\Migration\\' . self::MIGRATION_FILE; // 模板文件

    protected function configure()
    {
        $this->setName('migrate')->setDescription('Running migration file');
    }

    protected function execute(Input $input, Output $output)
    {
        $classes = $this->getClasses(); // 获取批次
        $files = scandir(Migration::DIR); // 获取目录下所有文件
        foreach ($files as $key => $file) { // 清理不相关文件
            if (!strpos($file, '.php')) {
                unset($files[$key]);
                continue;
            }
            $file = str_replace('.php', '', $file);
            if (in_array($file, $classes)) {
                unset($files[$key]);
                continue;
            }
            $files[$key] = $file;
        }

        foreach ($files as $file) {
            $class = 'databases\\' . $file;
            if (class_exists($class)) {
                $output->writeln($file . ' complete.');
            } else {
                $output->error($file . ' not is class.');
            }
        }
    }

    protected function getClasses(): array
    {
        try {
            return Db::table('migrations')->order('id', 'desc')->column('class');
        } catch (DbException $exception) {
            $file = fopen(Migration::DIR . self::MIGRATION_FILE, 'w');
            fwrite($file, file_get_contents(self::MIGRATION));
            fclose($file);
            return [];
        }
    }

    protected function getBatch(): int
    {
        try {
            return Db::table('migrations')->order('id', 'desc')->value('batch');
        } catch (DbException $exception) {
            $file = fopen(Migration::DIR . self::MIGRATION_FILE, 'w');
            fwrite($file, file_get_contents(self::MIGRATION));
            fclose($file);
            return 0;
        }
    }
}
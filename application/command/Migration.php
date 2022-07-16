<?php
/**
 * @author  流萤慕扇
 * @date 2022/7/16
 */
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Exception;

/**
 * Class Migration
 * 生成迁移文件
 * @author  流萤慕扇
 * @version 1.0.0
 */
class Migration extends Command
{
    const PREFIX = 'create'; // 前缀
    const SUFFIX = 'table'; // 后缀
    const TEMPLATE = APP_PATH . 'command\\lib\\Migration\\MigrationTemplate.php'; // 模板文件
    const DIR = ROOT_PATH . 'databases' . DS;

    /**
     * Function configure
     */
    protected function configure()
    {
        $this->setName('migration')
            ->setDescription('Creating migration file')
            ->addArgument('string');
    }

    /**
     * Function execute
     * @param Input $input
     * @param Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        $string = $input->getArgument('string'); // 获取输入字符串
        $array = explode('_', $string); // 转数组
        $count = count($array); // 总数

        // 处理前后缀
        if ($count > 0) {
            if ($array[0] == self::PREFIX) unset($array[0]); // 去除前缀
            if ($array[$count - 1] == self::SUFFIX) unset($array[$count - 1]); // 去除后缀

            $table = implode('_', $array); // 合并表名
        } else $table = $string; // 跳过处理
        unset($string, $array);

        if (empty($table)) $output->error('table name is empty string.');
        else {
            try {
                $template = $this->getTemplate(); // 获取模板内容
                $class = to_big_camel_case(self::PREFIX . '_' . $table . '_' . self::SUFFIX);
                $template = str_replace('MigrationTemplate', $class, $template);
                $template = str_replace('table_name', $table, $template);
                $path = $this->file($class, $template); // 创建文件
                $output->writeln($path);
                $output->writeln('Created successful.');
            } catch (Exception $exception) {
                $output->error($exception->getMessage());
            }
        }
    }

    /**
     * Function file
     * @param string $class
     * @param string $template
     * @return string
     * @throws Exception
     */
    protected function file(string $class, string $template): string
    {
        if (!is_dir(self::DIR)) mkdir(self::DIR); // 目录创建
        $path = self::DIR . $class .'.php';
        if (file_exists($path)) throw new Exception($class . ' is exists.');
        $file = fopen($path, 'w');
        fwrite($file, $template);
        fclose($file);

        return $path;
    }

    /**
     * Function getTemplate
     * @return false|string
     * @throws Exception
     */
    protected function getTemplate()
    {
        if (file_exists(self::TEMPLATE)) return file_get_contents(self::TEMPLATE);
        else throw new Exception('Template file not exists.');
    }
}
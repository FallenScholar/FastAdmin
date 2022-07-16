<?php
/**
 * @author  流萤慕扇
 * @date 2022/7/16
 */
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * Class Migrate
 * 执行迁移文件
 * @author  流萤慕扇
 * @version 1.0.0
 */
class Migrate extends Command
{
    protected function configure()
    {
        $this->setName('migrate')->setDescription('Running migration file');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("TestCommand:");
    }
}
<?php

#[AllowDynamicProperties]
class job_mysql_optimizer
{
    public $id = __CLASS__;
    public $name = 'MySQL Optimizer';
    public $description = 'Defragment your MySQL database';
    public $author = 'SHOPAGG Dev Team';
    public $version = '1.0';
    public $website = 'https://shopagg.org';
    public $priority = 0;

    public function process($force, $last_run)
    {

        if (empty($force)) {
            if (empty($this->settings['status'])) return;

            switch ($this->settings['frequency']) {
                case 'Daily':
                    if (date('Ymd', strtotime($last_run)) == date('Ymd')) return;
                    break;
                case 'Weekly':
                    if (date('W', strtotime($last_run)) == date('W')) return;
                    break;
                case 'Monthly':
                    if (date('Ym', strtotime($last_run)) == date('Ym')) return;
                    break;
            }
        }

        echo 'Optimizing MySQL Tables...' . PHP_EOL . PHP_EOL;

        database::query(
            "select table_name from `information_schema`.`tables`
        where table_schema = '" . DB_DATABASE . "'
        and table_name like '" . DB_TABLE_PREFIX . "%'
        order by table_name;"
        )->each(function ($row) {
            echo '  ' . $row['table_name'] . PHP_EOL;
            database::query("optimize table " . $row['table_name'] . ";");
        });

        echo PHP_EOL . 'Done!';
    }

    function settings()
    {

        return [
            [
                'key' => 'status',
                'default_value' => '1',
                'title' => language::translate(__CLASS__ . ':title_status', 'Status'),
                'description' => language::translate(__CLASS__ . ':description_status', 'Enables or disables the module.'),
                'function' => 'toggle("e/d")',
            ],
            [
                'key' => 'frequency',
                'default_value' => 'Monthly',
                'title' => language::translate(__CLASS__ . ':title_frequency', 'Frequency'),
                'description' => language::translate(__CLASS__ . ':description_frequency', 'How often the job should be processed.'),
                'function' => 'radio("Daily","Weekly","Monthly")',
            ],
            [
                'key' => 'priority',
                'default_value' => '0',
                'title' => language::translate(__CLASS__ . ':title_priority', 'Priority'),
                'description' => language::translate(__CLASS__ . ':description_priority', 'Process this module in the given priority order.'),
                'function' => 'number()',
            ],
        ];
    }
}

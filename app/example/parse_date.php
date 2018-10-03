<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class parse_date extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        error_reporting(0);
        //Парсим по заданной по заданной дате
        //Дата нужна в формате 2018/07/24/
        file_put_contents('storage/ParseArrayDate','');
        $date = date('Y/m/d', strtotime(Carbon::yesterday()));
        $count = 20;
        $bar = $this->output->createProgressBar($count);
        for ($j = 1; $j < $count; $j++ ){
            $html = new \Htmldom('https://www.israbox.ch/'.$date.'/page/'.$j);
            if ($html->size > 0){
                $a_array = $html->find('div.story h2 a');
                foreach($a_array as $one){
                    file_put_contents('storage/ParseArrayDate', $one ->href.PHP_EOL, FILE_APPEND | LOCK_EX);
                }
                $bar->advance();

            } else {
                file_put_contents('storage/ErrorPagesDate', 'https://www.israbox.ch/'.$date.'/page/'.$j.PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            if($j % 50 == 0) {
                sleep(30);
            } else{ sleep(1);}
        }
        $bar->finish();
    
    }
}

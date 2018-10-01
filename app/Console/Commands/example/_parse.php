<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class parse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse';

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
        
        $count = 19773;//реальное число страниц
        //$count = 5;//пробное число страниц
        $bar = $this->output->createProgressBar($count);
        for ($j = 2; $j < $count; $j++ ){
                $html = new \Htmldom('https://www.israbox.win/page/'.$j);
                if ($html->size > 0){
                    $a_array = $html->find('div.story h2 a');
                    foreach($a_array as $one){
                        file_put_contents('storage/ParseArray', $one ->href.PHP_EOL, FILE_APPEND | LOCK_EX);
                    }
                    $bar->advance();

                } else {
                    file_put_contents('storage/ErrorPages', 'https://www.israbox.win/page/'.$j.PHP_EOL, FILE_APPEND | LOCK_EX);
                }
                if($j % 50 == 0) {
                    sleep(30);
                } else{ sleep(1);}
        }
        $bar->finish();
    }
}

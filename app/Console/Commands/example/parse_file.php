<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class parse_file extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse_file';

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
       // $bar = $this->output->createProgressBar($count);
 
        $handle = fopen("storage/ErrorPages", "r"); // открываем файл на чтение
        if ($handle) {
            while (($line = fgets($handle)) !== false) { // цикл пока попытка взять след. строку не закончится неудачей
                //$line = '';
                $html = new \Htmldom($line);
                    if ($html->size > 0){
                        $a_array = $html->find('div.story h2 a');
                        foreach($a_array as $one){
                            file_put_contents('storage/ParseArray1', $one ->href.PHP_EOL, FILE_APPEND | LOCK_EX);
                        }
                        //$bar->advance();
 
                    } else {
                        file_put_contents('storage/ErrorPages1', 'https://www.israbox.win/page/'.$j.PHP_EOL, FILE_APPEND | LOCK_EX);
                    }
                    if($j % 50 == 0) {
                        sleep(120);
                    } else{ sleep(1);}
               
            }
        }
        for ($j = 2; $j < $count; $j++ ){
               
        }
       //$bar->finish();
 
    }
}

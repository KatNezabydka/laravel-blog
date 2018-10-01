<?php
/**
 * Created by PhpStorm.
 * User: aljajazva
 * Date: 01.10.18
 * Time: 09:56
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class Parse extends Command
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
    public function handle(){
        dd('work');
    }
}
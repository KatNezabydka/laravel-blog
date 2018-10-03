<?php
/**
 * Created by PhpStorm.
 * User: aljajazva
 * Date: 01.10.18
 * Time: 09:56
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Yangqi\Htmldom\Htmldom;

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
        $html = new Htmldom('https://www.sahibinden.com/kategori/emlak');
        // Find all images
//        foreach($html->find('img') as $element)
//            echo $element->src . '<br>';
//
//        // Find all links
//        foreach($html->find('a') as $element)
//            echo $element->href . '<br>';
        if ($html->size > 0){
            foreach($html->find('a') as $link){
                file_put_contents('storage/ParseArray', $link ->href.PHP_EOL, FILE_APPEND | LOCK_EX);
            }

        } else {
            file_put_contents('storage/ErrorPages', 'https://www.sahibinden.com/kategori/emlak', FILE_APPEND | LOCK_EX);
        }
    }
}
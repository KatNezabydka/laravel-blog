<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Yangqi\Htmldom\Htmldom;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Parser extends Command
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
//        $date = Carbon::now();
        $path = 'storage/app/public/';
        $fileName = 'ParseArray.json';
        $page = 'https://www.sahibinden.com/kategori/emlak';
//        $page = 'https://www.sahibinden.com/ilan/emlak-konut-satilik-beylikduzunde-genis-mutfak%2Cgenis-salon%2Cemsalsiz-fiyat-205.000-558818573/detay';
        $html = new Htmldom($page);
//        $html->file_get_html($page);
//        dd($html);
        // Find all images
//        foreach($html->find('img') as $element)
//            echo $element->src . '<br>';composer require php-curl-class/php-curl-class
//
//        // Find all links
//        foreach($html->find('a') as $element)
//            echo $element->href . '<br>';
        $result = [];
        dd($html);
        if ($html->size > 0){
//            foreach($html->find('a') as $link){
//                $result[] = $link->href;
//            }
            foreach($html->find('.classifiedInfo .classifiedInfoList strong') as $title){
                $result[] = $title;
            }
            if (Storage::disk('public')->exists($fileName)){
                $file = json_decode(Storage::disk('public')->get('ParseArray.json'));
                unset($file);
                Storage::disk('public')->put($fileName, json_encode($result));
            }else
                Storage::disk('public')->put($fileName, json_encode($result));
//                Storage::disk('public')->put($fileName, json_encode($result));
//            file_put_contents($path, json_encode($result), FILE_APPEND | LOCK_EX);

        } else {
            file_put_contents($path . $fileName, $page, FILE_APPEND | LOCK_EX);
        }
    }
}

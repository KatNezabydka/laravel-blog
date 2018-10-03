<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Album;
use App\Category;
use App\CategoryAlbum;
use App\Type;
Use App\TypeAlbum;
use Carbon\Carbon;

class parse_list_date extends Command
{
    protected $line = 'default';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse_list_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command get all information about one album and download it';

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
        //$this->info('Старт скрипта');
        set_error_handler(array($this, "parseErrorHandler"));
        
        $point_error = false;
        set_time_limit(0); // снимается ограничение на время работы скрипта
        // Достаем массив всех категорий - жанров, для того чтоб в каждом альбоме по названию составить массив id для записи нашему альбому
        $categ = Category::all();
        $categories = [];
        foreach ($categ as $one) {
            $categories[$one->name] = $one -> id;
        }
        //$this->info('Достаем массив всех категорий - жанров');
        $all_types = Type::all();
        $types = [];
        foreach ($all_types as $one) {
            $types[$one->name] = $one -> id;
        }
        //$this->info('Достаем массив всех категорий - типов');
        $step = 1;// нумерация шагов
        $handle = fopen("storage/ParseArrayDate", "r"); // открываем файл на чтение
        if ($handle) { 
            while (($line = fgets($handle)) !== false) { // цикл пока попытка взять след. строку не закончится неудачей
                //$line = 'https://www.israbox.ch/3137648360-buster-williams-audacity-2018.html';//TODO: заглушка для тестирования и дебага 
                //$this->info('Старт цикла');
                $this->line = $line;
            
                $this -> one_page($line, $categories, $types);                       
                
                sleep(2); 
                $step++;
            };
                
            fclose($handle); // закрываем файл
        } else {
            // не получилось открыть файл вообще
        }
        // $line = 'https://www.israbox.ch/3137644458-hatchie-sugar-and-spice-2018.html';
        // $this -> one_page($line);          
    }
    
    function one_page($line, $categories, $types)
    {
        $html = new \Htmldom($line);       
        if ($html->size > 0){
            //$this->info('Получили содержимое страницы');

            $type_string_array = explode(' | ',$html->find('dt[itemprop="genre"]',0) -> content);
            

            if($html->find('div.quote span a', 0) != NULL) {
                $box_download_link = $html->find('div.quote span a', 0)->href;
                //$this -> info($box_download_link);
                $box_download_link = $this -> decode_isra_links($box_download_link);
                //$this -> info($box_download_link);
                $point_error = false;
            } else {
                $point_error = true;
                $box_download_link = '';
            }
           
            
            if ($html->find('span[itemprop="name"]', 0) -> innertext != NULL) {
                $albumName = $html->find('span[itemprop="name"]', 0) -> innertext;
                
                $point_error = false;
            } else {$point_error = true;}
            //$this->info('$albumName = '.$albumName);

            if ($html->find('span[itemprop="author"]', 0) != NULL) {
                $artist = $html->find('span[itemprop="author"]', 0) -> innertext;                
                $album_isset = Album::where('title', $albumName) -> where('artist', $artist) -> first();
                //$album_isset = Album::where('title', $albumName) -> where('artist', $artist) -> get();
                
                $point_error = false;
            } else {$point_error = true;}
            //$this->info('$point_error = '.$point_error);
                        
            //проверка на наличие ссылки на нужный ресурс и на отсутствие такого альбома у нас в БД
           
            if ((stripos($box_download_link, 'isra.cloud') != false) 
                        && ($album_isset != 'NULL')
                )
            {
                $description_old = $html->find('div.quote',0)-> innertext;
                $description = preg_replace('/<a.*?>.*?<\/a>/m', '', $description_old);

                $timeAndSizeFinder = explode('<b>',$html->find('div[itemscope]',0)-> outertext);
                
        
                $finalTime = explode('<br/>', explode('</b>: ',$timeAndSizeFinder[7])[1]);                    
                $finalSize = explode('<br/>', explode('</b>: ',$timeAndSizeFinder[8])[1]);
                
                //Список треков
                //$this->info('Список треков');
                $trackListParse = explode('<br><br><br>',$html->find('span[itemprop="description"]',0)-> innertext);  
                $elem = explode('<br><br>',$trackListParse[0]); 
                $trackList = $elem[1];
                
                //Загрузка картинки
                $imageURL = $html->find('div[itemprop=thumbnailUrl] img', 0)->src;
                //$path = 'https://www.israbox.ch'.$imageURL;
                $path = $imageURL;
                $new_image_url = 'images/albums/album_image_'.Carbon::now().'.jpg';
                $image = file_get_contents($path);               
                file_put_contents(getcwd().'/public/'.$new_image_url, $image);
    
                //$this->info('сбор массива для БД');
                // массив для записи в базу данных
                $array_to_db = [
                    'title' => $html->find('span[itemprop="name"]', 0) -> innertext,
                    'artist' => $artist,
                    'image' => $new_image_url, 
                    'year_of_release' => explode(' ',$html->find('span[itemprop="releasedEvent"]', 0) -> innertext)[0],
                    'tracklist' => $trackList,
                    'description' => $description,
                    'label' => $html->find('span[itemprop="producer"]', 0) -> innertext,
                    'quality' => $html->find('span[itemprope="quality"]', 0) -> innertext,
                    'total_time' => $finalTime[0], 
                    'total_size' => $finalSize[0], 
                    'download_link' => $box_download_link,//первоначально устанавливаем ссылку  с исрабокс, для сохранения и дальнейшего использования
                    'show_in_slider' => 0,
                    'big_image' => $new_image_url,
                    'web_site' => $html->find('span[itemprop="url"]', 0) -> innertext
                ];
               
                
                if ($point_error == false){
                    $album = new Album();
                    $album -> fill($array_to_db);
                    $album -> save();

                    //после того как вставили в бд общую информацию у нас есть id фльбома
                    $type_string = $html->find('span[itemprop="genre"]', 0);
                    
                    $genres = explode(', ',$html->find('span[itemprop="genre"]', 0) -> innertext);    
    
                    $insertArray = [];
                    $insertArrayTypes = [];

                    foreach ($type_string_array as $genre){
                        if(array_key_exists($genre, $categories)){  
                            $insertArray[] = ['album_id' => $album -> id, 'category_id' => $categories[$genre]];
                        }
                        //  else {                        
                        //     $category = new Category(); 
                        //     $category -> fill(['name' => $genre]);
                        //     $category -> save();
                        //     $insertArray[] = ['album_id' => $album -> id, 'category_id' => $category -> id];
                        //     $categories[$genre] = $category -> id;
                        // } 
                        if(array_key_exists($genre, $types)){                        
                            $insertArrayTypes[] = ['album_id' => $album -> id, 'type_id' => $types[$genre]];
                        }           
                    }
                    CategoryAlbum::insert($insertArray);
                    TypeAlbum::insert($insertArrayTypes);
                } else {
                    file_put_contents('storage/ErrorAlbumsListDate', $line.PHP_EOL, FILE_APPEND | LOCK_EX);
                }   
            }
        
        }

    }
    
    
    function decode_isra_links($encoded_link) 
    {
        // Extract URL part needs to be decoded
        try {
            preg_match('/([?&;]url=|\/leech_out\.php\?.:)([^&]+)(&|$)/i', $encoded_link, $matches);
            if (count($matches) >= 2) {
                $encoded_link = $matches[2];
            } else {
                return $encoded_link;
            }
            $link = base64_decode(urldecode($encoded_link));
        } catch(Exception $e) {
            $link = $encoded_link;
        }
    
        // Some special characters' codes
        $impCodes = '%3B%2C%2F%3F%3A%40%26%3D%2B%24%23';
        $impRegex = '/%3B|%2C|%2F|%3F|%3A|%40|%26|%3D|%2B|%24|%23/i';
        $impDecoded = urldecode($impCodes);
    
        // Decode important %-encoded parts of a link
        $link = preg_replace_callback($impRegex,
                    function($ch) use(&$impDecoded, &$impCodes) {
                        $index = array_search(strtoupper($ch), $impCodes);
                        return $impDecoded[ $index / 3];
                    },
                    $link);
    
        return $link;
    }

    public function parseErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return false;
        }
        // Делаешь свое черное дело: запоминаешь, на какой ссылке лажанули, логируешь и проч.
       
        file_put_contents('storage/ErrorAlbumsList', $this->line, FILE_APPEND | LOCK_EX);
        echo $errstr.PHP_EOL;
        
        return true; // Это обязательно, чтобы стандратный PHP обработчик не возбудился
    }
}

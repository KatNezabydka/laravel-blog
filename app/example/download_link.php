<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Album;
use App\Category;
use App\CategoryAlbum;
use Carbon\Carbon;


class download_link extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:download_link';

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
        //вытаскиваем из БД все ссылки на альбомы
        $albums = Album::all();
        //проходим циклом по массиву, выкачивая архив в каждой ссылке

            // $url = 'https://isra.cloud/i4mdl72anli9/The_Jef_Gilson_Nonet_-_New_Call_From_France.rar.html';
            // $array = explode('.', explode('/', $url)[4]);
            // $name = explode('.', explode('/', $url)[4])[0].'.'.explode('.', explode('/', $url)[4])[1];
            
        foreach ($albums as $album) {
            $url = $album->download_link;
            $name = explode('.', explode('/', $url)[4])[0].'.'.explode('.', explode('/', $url)[4])[1];
            $this->one_link($url, $name);
            $url = '/public/albums/'.$name;//ссылка на архив на нашем сервере
            // перепаковываем архив таким образом, чтоб получить в итоге  zip  без текстовых файлов
            
            // if (preg_match('rar',  $name)) {
            //     $this -> convert_to_clean_zip($name, '');
            // } else {
            //     $this -> zip_cliner($name);
            // }
            


            $album->download_link = api_download_one_album($url);
        }
    }    

    public function one_link($link, $name)
    {     
        $url = $link;    
        //$url = 'https://isra.cloud/i4mdl72anli9/The_Jef_Gilson_Nonet_-_New_Call_From_France.rar.html';
        set_time_limit(0); // снимается ограничение на время работы скрипта
        $fp = fopen(getcwd().'/public/albums/'.$name, 'w+'); // куда писать скачиваемый файл
        $log = fopen('curl.log', 'w'); // открываем файл для лога, можно закомментировать
        $ch = curl_init($url); // инициализация curl
        //var_dump(file_get_contents(getcwd().'/public/cookie.txt'));die;
        $options = array(
          CURLOPT_FOLLOWLOCATION => true, // следовать за перенаправлением сервера
          CURLOPT_SSL_VERIFYHOST => '0', // не проверять сертификаты защищенного соединения
          CURLOPT_SSL_VERIFYPEER => '0', // не проверять сертификаты защищенного соединения
          CURLOPT_STDERR => $log, // куда печатать лог, можно закомментировать
          CURLOPT_VERBOSE => true, // печать лога, можно закомментировать
          CURLOPT_COOKIEFILE => getcwd().'/public/cookie.txt',  
          CURLOPT_TIMEOUT => 600, // таймаут соединения (в  секундах)
          CURLOPT_FILE => $fp, // говорим, что пишем в файл, а не строку
        );
        curl_setopt_array($ch, $options); // устанавливаем параметры все сразу
        curl_exec($ch); // собственно, запрос к серверу
        curl_close($ch); // закрытие соединения
        fclose($fp); // закрытие файла
        fclose($log); // закрытие файла лога, можно закомментировать
    }

    protected function api_download_one_album($url)
    {
        $new_link = ''; //линк на архив на файлообменник
        // //тут должен быть скрипт для перелива на файлообменник используя апи
        $api = new FileCatApi("https://api.fc.4crp.com", "1000016_fceizJI9Gyly2J5g2iou");
        $new_link = $api->upload($url);

        return $new_link;
    }

    function convert_to_clean_zip($rar_archive_name, $storage = "/tmp") {
		$rar = rar_open($rar_archive_name);
		if ($rar !== false) {
			$entries = $rar->getEntries();
			if (count($entries) > 0) {
				$archive_dir = preg_replace('/\.rar$/i', '', basename($rar_archive_name));		
				$filtered_entries = array();
				foreach($entries as $entry) {
					if (preg_match('/.\.txt/i', $entry->getName()) != true) {
						$filtered_entries[] = $entry->getName();
						$entry->extract($storage . "/" . $archive_dir);
					}
				}			
				if (count($filtered_entries) > 0) {
					$zip = new ZipArchive;
					$result = $zip->open($storage . "/" . $archive_dir . ".zip", ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
					if ($result === true) {
						foreach($filtered_entries as $entry) {
							$zip->addFile($storage . "/" . $archive_dir. "/" . $entry);
						}
						$zip->close();						
						
						foreach($filtered_entries as $entry) {
							unlink($storage . "/" . $archive_dir. "/" . $entry);
						}
						rmdir($storage . "/" . $archive_dir. "/");
					}
				}
			}
			$rar->close();
		}		
    }
    
    function zip_cliner($archive_path){
        $zip = new ZipArchive;
        $zip->open($archive_path);
        $entries_count = $zip->count();	
        $need_to_be_exterminated = array();
        for($i = 0; $i < $entries_count; $i++) {
            if (preg_match('/.\.txt/i', $zip->getNameIndex($i)) == true) {
                $need_to_be_exterminated[] = $zip->getNameIndex($i);
            }
        }
        foreach($need_to_be_exterminated as $target_entry) {
            $zip->deleteName($target_entry);
        }
        $zip->close();
    }
}

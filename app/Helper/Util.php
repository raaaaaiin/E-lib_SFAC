<?php

namespace App\Helper;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use App\Models\Book;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Utils;
use stringEncode\Exception;
use voku\helper\UTF8;

class Util
{
    private $extension_allowed = ["csv", "pdf", "jpeg", "jpg", "png", "doc", "docx"]; //Safe extension
    private $amz_host = ["Australia" => "webservices.amazon.com.au", "Brazil" => "webservices.amazon.com.br",
        "Canada" => "webservices.amazon.ca", "France" => "webservices.amazon.fr", "Germany" => "webservices.amazon.de",
        "India" => "webservices.amazon.in", "Italy" => "webservices.amazon.it", "Japan" => "webservices.amazon.co.jp",
        "Mexico" => "webservices.amazon.com.mx", "Netherlands" => "webservices.amazon.nl", "Singapore" => "webservices.amazon.sg"
        , "Saudi Arabia" => "webservices.amazon.sa", "Spain" => "webservices.amazon.es", "Sweden" => "webservices.amazon.se",
        "Turkey" => "webservices.amazon.com.tr", "United Arab Emirates" => "webservices.amazon.ae", "United Kingdom" => "webservices.amazon.co.uk",
        "United States" => "webservices.amazon.com"
    ];
    private $amz_region = ["us-west-2", "us-east-1", "eu-west-1"];

    public function getAmazonHosts()
    {
        return $this->amz_host;
    }

    public function getAmazonRegions()
    {
        return $this->amz_region;
    }

    /**
     * Strips the characters and keep only digits.
     * @param $string
     * @return string|string[]|null
     */
    public function keepNumbers($string)
    {
        return preg_replace('/\D/', '', $string);
    }

    /**
     * Gives php files name and strips extensions and other non required things
     * @param $text string
     * @return string
     */
    public function cleanTemplateName($string)
    {
        return Str::replaceFirst(".blade.php", "", $string);
    }

    /**
     * Strips all the digits and keep only characters
     * @param $string
     * @return string|string[]
     */
    public function removeNumbers($string)
    {
        $num = range(0, 9);
        return str_replace($num, null, $string);
    }

    /**
     * Use to generate html option from the supplied parameters
     * @param $obj object eloquent object
     * @param $face string Give property name which should be present in the eloquent object to make a face
     * @param $value string Give property name which should be present in the eloquent object to make a value
     * @param null $default if the default is not supplied will generate its own --select--
     * @param string $selected [Optional] Can give a value which can be shown as selected
     * @return string|null
     */
    public function generateOptions($obj, $face, $value, $default = null, $selected = "")
    {
        if ($default === null) {
            $default .= "<option value=''>--Select--</option>";
        } else {
            $default = "<option value=''>" . $default . "</option>";
        }
        $rawHtml = $default;
        foreach ($obj as $item) {
            if (isset($item->$value) && isset($item->$face)) {
                if ($selected == $item->$value) {
                    $rawHtml .= "<option value='" . $item->$value . "' selected>" . $item->$face . "</option>";
                } else {
                    $rawHtml .= "<option value='" . $item->$value . "'>" . $item->$face . "</option>";
                }
            }
        }
        return $rawHtml;
    }

    /**
     * Gives the ip address
     * @return string Ip Address
     */
    public function getRealIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))                 //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))     //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Search the given text and return bool if it finds a match
     * [strpos in action]
     * @param $in string String which needs to be search
     * @param $find string Looking for text
     * @return bool
     */
    public function contains($in, $find)
    {
        if (strpos($in, $find) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Search an items in array and returns boolean.
     * @param $array array Array to be searched
     * @param $find string Item to be searched
     * @return bool
     */
    public function containsInArray($array, $find)
    {
        foreach ($find as $val) {
            if (strpos($array, $val) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Searches and Removes the element in an array by value
     * @param $array array
     * @param $remove_element string
     * @return array
     */
    public function removesFromArrayByValue($array, $remove_element)
    {
        if (($key = array_search($remove_element, $array)) !== false) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * Genarates random string of alphanumeric type
     * @param int $nos No of random string to output
     * @return string
     */
    public function generateRandomString($nos = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $nos; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    /**
     * Saves link image to upload folder
     * @param string $url http://.....
     * @param string $type .jpg|.png|.* The type of file you are downloading
     * @return bool|string on success will return filename else false
     */
    public function saveFileFromUrl($url, $type)
    {
        if (!empty($url)) {
            $imageContent = file_get_contents($url);
            $name = self::generateRandomString() . $type;
            if (Storage::disk('custom')->put($name, $imageContent)) {
                return $name;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Return filenames inside the given path inside the view folder
     * @param string $folder_name Folder to search inside a view folder
     * @return array return list of file names as array inside specified folder
     */
    public function getTemplateInFolder($folder_name = '/templates/')
    {
        $path = Config::get('view.paths')[0] . $folder_name;
        return array_diff(scandir($path), array('.', '..'));
    }

    /** Creates file in the root of the project
     * Can mostly be used to create to create .evn file on the go
     * @param $content string Content for the file
     * @param $filename string Filename of file
     */
    public function createFileRoot($content, $filename)
    {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $filename, "wb");
        fwrite($fp, $content);
        fclose($fp);
    }

    /**
     * Accepts date as string and converts it to d-m-Y format
     * @param $data_string string Any Format
     * @return string Return 31-12-2000
     */
    public function goodDate($data_string)
    {
        return Carbon::parse($data_string)->format('m-d-Y');
    }

    /**
     * Set the data passed to the old session.
     * @param $data array Accepts array of data in key value pair
     */
    public function flashToOldSession($data)
    {
        foreach ($data as $k => $v) {
            Session::flash('_old_input.' . $k, $v);
        }
    }

    /**
     * Use to search in eloquent object collection
     * [Eg: if say you enter name-property and value required it will give you single eloquent model by searching in collection]
     * @param $collections object Eloquent Object Collection
     * @param $property string Property Name from the object
     * @param $value string Search for property
     * @param $return_property string Search for property id [default :id ]
     * @return mixed Returns Eloquent Single Object
     */
    public function searchCollections($collections, $property, $value, $return_property = "id")
    {
        if ($value) {
            foreach ($collections as $collection) {
                if ($collection->$property == $value) {
                    return $collection->$return_property;
                }
            }
        }
        return null;
    }

    /**
     * If anything exist and not empty then it will be returned else the default supplied object will be returned
     * @param $main mixed if anything exist and not empty then return main
     * @param $default mixed fall back object to be returned
     * @return mixed
     */
    public function fallBack($main, $default)
    {
        if (empty($main)) {
            return $default;
        }
        return $main;
    }

    /**
     * Gives the file names plus its size as array from bck_dbs folder
     * [Consumed in setting page to list backup files]
     * @return array
     */
    public function getDbBackupFiles()
    {
        $project_name = Str::lower(\config('app.APP_NAME', 'laravel-backup'));
        $bck_folder = storage_path() . DIRECTORY_SEPARATOR . "bck_dbs" . DIRECTORY_SEPARATOR;
        
        $path = $bck_folder . Str::of($project_name)->replace(" ", "-") . "/";
        if (!self::folderExist($bck_folder)) {
            mkdir($bck_folder);
        }
        if (!self::folderExist($path)) {
            mkdir($path);
        }
        $file_names = array_diff(scandir($path), array('.', '..'));
        $actual_files = array();
        foreach ($file_names as $filename) {
            $file_loc = $path . $filename;
            if (file_exists($file_loc)) {
                $actual_files[$filename] = array(round(filesize($file_loc) / 1024 / 1024, 2) . " MB", date("F d Y H:i:s.", filemtime($file_loc)));
            }
        }
        return array_slice(array_reverse($actual_files), 0, 10);
    }

    /** Check if the given folder exist
     * @param $folder string Folder Path
     * @return bool|false|string
     */
    public function folderExist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);
        // If it exist, check if it's a directory
        return ($path !== false and is_dir($path)) ? $path : false;
    }

    /**
     * Get files in a directory as array
     * @param $path string
     * @return array
     */
    public function getFilesInDir($path)
    {
        return array_diff(scandir($path), array('.', '..'));
    }

    /**
     * Check if we are on localhost by looking at the  ip address
     * @param array $whitelist
     * @return bool
     */
    public function isLocalhost($whitelist = ['127.0.0.1', '::1'])
    {
        return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
    }

    /**
     * Helps to unzip a file to directory specified
     * @param $file_to_unzip string Filename to be unzip
     * @param $unzip_loc string Location to where unzip
     * @return bool
     */
    public function unzip($file_to_unzip, $unzip_loc)
    {
        $zip = new \ZipArchive();
        $res = $zip->open($file_to_unzip);
        if ($res === TRUE) {
            $zip->extractTo($unzip_loc);
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete directory
     * @param $path string Folder location to delete
     * @return bool
     */
    public function deleteDir($path)
    {
        if (!is_dir($path)) {
            return false;
        }
        if (substr($path, strlen($path) - 1, 1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $files = glob($path . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($path);
    }

    /**
     * Returns age in human format
     * @param $dob string Date as string
     * @return string return 14 years,1 months and 3 days
     */
    public function getActualDOb($dob)
    {
        return Carbon::parse($dob)->diff(Carbon::now())
            ->format('%y years, %m months and %d days');
    }

    /**
     * Stores file object in upload folder and returns filename
     * @param $file_obj object
     * @param $new_name string Filename [Optional]
     * @return string Return new generated filename
     * @throws \Exception
     */
    public function uploadFile(UploadedFile $file_obj, $new_name = "")
    {
        if (empty($new_name)) {
            $new_name = uniqid() . '.' . $file_obj->getClientOriginalExtension();
        }
        $extension = $file_obj->getClientOriginalExtension();
        if (in_array($extension, $this->extension_allowed)) {
            $file_obj->move(public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR, $new_name);
        } else {
            if ($extension == "php") {
                throw new \Exception("No shells please.Try finding any other exploit.");
            } else {
                throw new \Exception("Na na this extension is not allowed.");
            }
        }
        return $new_name;
    }

    /**
     * Extract to key value pair from given eloquent collection
     * @param $id string Property Name [Which you want as a id] Note: Slugify is applied to it
     * @param $value string  Property Name [Which you want as value]
     * @return array Return a array made up of given property name in  key value format
     */
    public function toArrayFromEloquentCollection($collection, $id, $value, $slugify = true)
    {
        $tmp = array();
        foreach ($collection as $item) {
            if (isset($item->$id) && isset($item->$value)) {
                if ($slugify) {
                    $tmp[\App\Facades\Common::utf8Slug($item->$id)] = $item->$value;
                } else {
                    $tmp[$item->$id] = $item->$value;
                }

            }
        }
        return $tmp;
    }

    /**
     * Strip all non alphanumeric and join them with underscore
     *  Usage : Could be used in creating acceptable ids and class from html perspective
     * @param $string
     * @return \Illuminate\Support\Stringable
     */
    public function cleanString($string)
    {
        return Str::of(\App\Facades\Common::utf8Slug($string))->replace("-", "_")->__toString();
    }

    /**
     * Returns and array of the matched parameters supplied.
     * @param $str String String to work on
     * @param $startDelimiter string Start character to begin the match
     * @param $endDelimiter string End character to begin the match
     * @return array Return an array of matched items.
     */
    public function getBetween($str, $startDelimiter, $endDelimiter)
    {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        return $contents;
    }

    /**
     * Return matched values for the keys specified in key value format
     * Or You could toggle the combined value to search in both [&]
     * @param array $contentToSearch Keys=>Value Pair to be searched
     * @param array $toBeSearchedArray The array to be searched
     * @param boolean $partialMatchKey False is the default. Turn on to search partial keys
     * @param boolean $partialMatchValue False is the default. Turn on to search partial values
     * @param boolean $combinedSearch False is the default. Turn on to combined search of key and value
     * @return array Returns a list of found array in the supplied array else an empty array
     */
    public function searchArray($contentToSearch = array(), $toBeSearchedArray = array(), $partialMatchKey = false, $partialMatchValue = false, $combinedSearch = false)
    {
        if (count($toBeSearchedArray)) {
            return array_filter($toBeSearchedArray, function ($value, $key) use ($contentToSearch, $partialMatchKey, $partialMatchValue, $combinedSearch) {
                if ($combinedSearch) {
                    return boolval(array_filter($contentToSearch, function ($s_value, $s_key) use ($partialMatchValue, $partialMatchKey, $key, $value) {
                        return ($partialMatchKey ? Str::contains($key, $s_key) : $key == $s_key) && ($partialMatchValue ? Str::contains($value, $s_value) : $value == $s_value);
                    }, ARRAY_FILTER_USE_BOTH));
                } else {
                    return boolval(array_filter($contentToSearch, function ($s_value, $s_key) use ($partialMatchValue, $partialMatchKey, $key, $value) {
                        return ($partialMatchKey ? Str::contains($key, $s_key) : $key == $s_key) || ($partialMatchValue ? Str::contains($value, $s_value) : $value == $s_value);
                    }, ARRAY_FILTER_USE_BOTH));
                }
            }, ARRAY_FILTER_USE_BOTH);
        }
        return array();
    }

    /**
     * Converts and string array into real array
     * @param $passed_data string String of associative array
     * @return array Return an associate array or an empty array
     */
    public function getCleanedLiveArray($passed_data)
    {
        $cleanedStringArray = Str::of($passed_data)->replace("'", "\"")->__toString();
        if (empty($cleanedStringArray)) {
            $cleanedStringArray = "{}";
        }
        return json_decode($cleanedStringArray, true);
    }

    /**
     * Return the upcoming auto incremented id.
     * @param object $modelName ModelName
     * @return int Return the upcoming auto increment id.
     */
    public function getUpcomingIncrementId($modelName)
    {
        return DB::select("SHOW TABLE STATUS LIKE '" . $modelName->getTable() . "'")[0]->Auto_increment;
    }

    /**
     * Return value of given key | partial matching Eg: std
     * @param $request_obj \Request Object Request
     * @param $key string Partial name of the key to match
     * @return mixed
     */
    public function getValuePartialMatchKey($request_obj, $key)
    {
        foreach ($request_obj->all() as $mkey => $mpart) {
            if (Str::contains($mkey, $key)) {
                return ["key" => $mkey, "value" => $mpart];
            }
        }
        return null;
    }

    /**
     * Returns html content after reading a page.
     * @param $url string Http:// link to post data to
     * @param $post_data string In format "phone=1234567890&roll_no=2&std_id=2&div_id=1"
     * @param $headers array Default is none. You can pass in format ["User-Agent:Microsoft...."]
     * @param $type string Default is GET. You can any send supported type request
     * @param $caching bool Default is False. [5 min default] You can any set it to true so it caches the request for some amount of time.
     * @return string Return read html content.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function curlPost($url, $post_data, $headers = [], $type = "GET", $caching = false)
    {
        if ($caching && Cache::has($url)) {
            return Cache::get($url);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($type == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        if (is_countable($headers) && count($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        if ($caching) {
            Cache::set($url, $server_output, now()->addMinutes(5));
        }
        return $server_output;

    }

    /**
     * Converts an eloquent builder to sql along with bindings.
     * @param $query
     * @return string SQl generated
     */
    public function toSql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }

    /**
     * Return the count of key and its value supplied
     * @param $items array The array needs to be a basic array.
     * @param $key string The key name to look for.
     * @param $value string The value to match.
     * @return int Return the count of items config supplied.
     */
    public function countProperty($items, $key, $value)
    {
        return array_reduce($items, function ($response, $data) use ($key, $value) {
            if (isset($data[$key]) && $data[$key] == $value) {
                $response = $response + 1;
            }
            return $response;
        }, 0);

    }

    /**
     * Use to search in eloquent object collection
     * [Eg: if say you enter name-property and value required it will give you single eloquent model by searching in collection]
     * @param $collections object Eloquent Object Collection
     * @param $property string Property Name from the object
     * @param $value string Search for property
     * @param $return_property string Search for property id [default :id ]
     * @return mixed Returns Eloquent Collection Object
     */
    public function searchCollectionsAndReturnCollection($collections, $property, $value, $return_property = "id")
    {
        $temp = [];
        if ($value) {
            foreach ($collections as $collection) {
                if ($collection->$property == $value) {
                    $temp[] = $collection->$return_property;
                }
            }
        }
        return $temp;
    }


    /**
     * Get a paginator object of the given sql
     * @param string $sql sql query
     * @param int $per_page Default is 10 items per page
     * @param Request $request request object
     * @return LengthAwarePaginator
     */
    public function getPaginatorObject(Request $request, string $sql, int $per_page = null)
    {
        if (is_null($per_page)) {
            $per_page = 10;
        }
        $perPage = $request->input("per_page", $per_page);
        $page = $request->input("page", 1);
        $skip = $page * $perPage;
        $take = 0;
        if ($take < 1) {
            $take = 1;
        }
        if ($skip < 0) {
            $skip = 0;
        }

        $basicQuery = DB::select(DB::raw($sql));
        $totalCount = $basicQuery->count();
        $results = $basicQuery
            ->take($perPage)
            ->skip($skip)
            ->get();
        $paginator = new LengthAwarePaginator($results, $totalCount, $take, $page);
        return $paginator;
    }

    /**
     * Return a fake image created by placeholder.com
     * @param int $height
     * @param int $width
     * @param bool $with_src
     * @return string
     */
    public function fakeImage(int $height, int $width, bool $with_src = null)
    {
        if (is_null($with_src)) {
            $with_src = false;
        }
        if ($with_src) {
            return "<img src='https://via.placeholder.com/" . $width . "X" . $height . "'/>";
        }
        return "https://via.placeholder.com/" . $width . "X" . $height;
    }

    /**
     * Checks if the given string is a url.
     * @param $uri string
     * @return bool Returns true or false.
     */
    function isUrl(string $uri)
    {
        if (preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri)) {
            return $uri;
        } else {
            return false;
        }
    }

    /**
     * Return all available locale in existence.
     * @return array
     */
    public function giveAllLocale()
    {
        return array(
            'en' => 'English [Default]',
            'aa_DJ' => 'Afar (Djibouti)',
            'aa_ER' => 'Afar (Eritrea)',
            'aa_ET' => 'Afar (Ethiopia)',
            'af_ZA' => 'Afrikaans (South Africa)',
            'sq_AL' => 'Albanian (Albania)',
            'sq_MK' => 'Albanian (Macedonia)',
            'am_ET' => 'Amharic (Ethiopia)',
            'ar_DZ' => 'Arabic (Algeria)',
            'ar_BH' => 'Arabic (Bahrain)',
            'ar_EG' => 'Arabic (Egypt)',
            'ar_IN' => 'Arabic (India)',
            'ar_IQ' => 'Arabic (Iraq)',
            'ar_JO' => 'Arabic (Jordan)',
            'ar_KW' => 'Arabic (Kuwait)',
            'ar_LB' => 'Arabic (Lebanon)',
            'ar_LY' => 'Arabic (Libya)',
            'ar_MA' => 'Arabic (Morocco)',
            'ar_OM' => 'Arabic (Oman)',
            'ar_QA' => 'Arabic (Qatar)',
            'ar_SA' => 'Arabic (Saudi Arabia)',
            'ar_SD' => 'Arabic (Sudan)',
            'ar_SY' => 'Arabic (Syria)',
            'ar_TN' => 'Arabic (Tunisia)',
            'ar_AE' => 'Arabic (United Arab Emirates)',
            'ar_YE' => 'Arabic (Yemen)',
            'an_ES' => 'Aragonese (Spain)',
            'hy_AM' => 'Armenian (Armenia)',
            'as_IN' => 'Assamese (India)',
            'ast_ES' => 'Asturian (Spain)',
            'az_AZ' => 'Azerbaijani (Azerbaijan)',
            'az_TR' => 'Azerbaijani (Turkey)',
            'eu_FR' => 'Basque (France)',
            'eu_ES' => 'Basque (Spain)',
            'be_BY' => 'Belarusian (Belarus)',
            'bem_ZM' => 'Bemba (Zambia)',
            'bn_BD' => 'Bengali (Bangladesh)',
            'bn_IN' => 'Bengali (India)',
            'ber_DZ' => 'Berber (Algeria)',
            'ber_MA' => 'Berber (Morocco)',
            'byn_ER' => 'Blin (Eritrea)',
            'bs_BA' => 'Bosnian (Bosnia and Herzegovina)',
            'br_FR' => 'Breton (France)',
            'bg_BG' => 'Bulgarian (Bulgaria)',
            'my_MM' => 'Burmese (Myanmar [Burma])',
            'ca_AD' => 'Catalan (Andorra)',
            'ca_FR' => 'Catalan (France)',
            'ca_IT' => 'Catalan (Italy)',
            'ca_ES' => 'Catalan (Spain)',
            'zh_CN' => 'Chinese (China)',
            'zh_HK' => 'Chinese (Hong Kong SAR China)',
            'zh_SG' => 'Chinese (Singapore)',
            'zh_TW' => 'Chinese (Taiwan)',
            'cv_RU' => 'Chuvash (Russia)',
            'kw_GB' => 'Cornish (United Kingdom)',
            'crh_UA' => 'Crimean Turkish (Ukraine)',
            'hr_HR' => 'Croatian (Croatia)',
            'cs_CZ' => 'Czech (Czech Republic)',
            'da_DK' => 'Danish (Denmark)',
            'dv_MV' => 'Divehi (Maldives)',
            'nl_AW' => 'Dutch (Aruba)',
            'nl_BE' => 'Dutch (Belgium)',
            'nl_NL' => 'Dutch (Netherlands)',
            'dz_BT' => 'Dzongkha (Bhutan)',
            'en_AG' => 'English (Antigua and Barbuda)',
            'en_AU' => 'English (Australia)',
            'en_BW' => 'English (Botswana)',
            'en_CA' => 'English (Canada)',
            'en_DK' => 'English (Denmark)',
            'en_HK' => 'English (Hong Kong SAR China)',
            'en_IN' => 'English (India)',
            'en_IE' => 'English (Ireland)',
            'en_NZ' => 'English (New Zealand)',
            'en_NG' => 'English (Nigeria)',
            'en_PH' => 'English (Philippines)',
            'en_SG' => 'English (Singapore)',
            'en_ZA' => 'English (South Africa)',
            'en_GB' => 'English (United Kingdom)',
            'en_US' => 'English (United States)',
            'en_ZM' => 'English (Zambia)',
            'en_ZW' => 'English (Zimbabwe)',
            'eo' => 'Esperanto',
            'et_EE' => 'Estonian (Estonia)',
            'fo_FO' => 'Faroese (Faroe Islands)',
            'fil_PH' => 'Filipino (Philippines)',
            'fi_FI' => 'Finnish (Finland)',
            'fr_BE' => 'French (Belgium)',
            'fr_CA' => 'French (Canada)',
            'fr_FR' => 'French (France)',
            'fr_LU' => 'French (Luxembourg)',
            'fr_CH' => 'French (Switzerland)',
            'fur_IT' => 'Friulian (Italy)',
            'ff_SN' => 'Fulah (Senegal)',
            'gl_ES' => 'Galician (Spain)',
            'lg_UG' => 'Ganda (Uganda)',
            'gez_ER' => 'Geez (Eritrea)',
            'gez_ET' => 'Geez (Ethiopia)',
            'ka_GE' => 'Georgian (Georgia)',
            'de_AT' => 'German (Austria)',
            'de_BE' => 'German (Belgium)',
            'de_DE' => 'German (Germany)',
            'de_LI' => 'German (Liechtenstein)',
            'de_LU' => 'German (Luxembourg)',
            'de_CH' => 'German (Switzerland)',
            'el_CY' => 'Greek (Cyprus)',
            'el_GR' => 'Greek (Greece)',
            'gu_IN' => 'Gujarati (India)',
            'ht_HT' => 'Haitian (Haiti)',
            'ha_NG' => 'Hausa (Nigeria)',
            'iw_IL' => 'Hebrew (Israel)',
            'he_IL' => 'Hebrew (Israel)',
            'hi_IN' => 'Hindi (India)',
            'hu_HU' => 'Hungarian (Hungary)',
            'is_IS' => 'Icelandic (Iceland)',
            'ig_NG' => 'Igbo (Nigeria)',
            'id_ID' => 'Indonesian (Indonesia)',
            'ia' => 'Interlingua',
            'iu_CA' => 'Inuktitut (Canada)',
            'ik_CA' => 'Inupiaq (Canada)',
            'ga_IE' => 'Irish (Ireland)',
            'it_IT' => 'Italian (Italy)',
            'it_CH' => 'Italian (Switzerland)',
            'ja_JP' => 'Japanese (Japan)',
            'kl_GL' => 'Kalaallisut (Greenland)',
            'kn_IN' => 'Kannada (India)',
            'ks_IN' => 'Kashmiri (India)',
            'csb_PL' => 'Kashubian (Poland)',
            'kk_KZ' => 'Kazakh (Kazakhstan)',
            'km_KH' => 'Khmer (Cambodia)',
            'rw_RW' => 'Kinyarwanda (Rwanda)',
            'ky_KG' => 'Kirghiz (Kyrgyzstan)',
            'kok_IN' => 'Konkani (India)',
            'ko_KR' => 'Korean (South Korea)',
            'ku_TR' => 'Kurdish (Turkey)',
            'lo_LA' => 'Lao (Laos)',
            'lv_LV' => 'Latvian (Latvia)',
            'li_BE' => 'Limburgish (Belgium)',
            'li_NL' => 'Limburgish (Netherlands)',
            'lt_LT' => 'Lithuanian (Lithuania)',
            'nds_DE' => 'Low German (Germany)',
            'nds_NL' => 'Low German (Netherlands)',
            'mk_MK' => 'Macedonian (Macedonia)',
            'mai_IN' => 'Maithili (India)',
            'mg_MG' => 'Malagasy (Madagascar)',
            'ms_MY' => 'Malay (Malaysia)',
            'ml_IN' => 'Malayalam (India)',
            'mt_MT' => 'Maltese (Malta)',
            'gv_GB' => 'Manx (United Kingdom)',
            'mi_NZ' => 'Maori (New Zealand)',
            'mr_IN' => 'Marathi (India)',
            'mn_MN' => 'Mongolian (Mongolia)',
            'ne_NP' => 'Nepali (Nepal)',
            'se_NO' => 'Northern Sami (Norway)',
            'nso_ZA' => 'Northern Sotho (South Africa)',
            'nb_NO' => 'Norwegian Bokmål (Norway)',
            'nn_NO' => 'Norwegian Nynorsk (Norway)',
            'oc_FR' => 'Occitan (France)',
            'or_IN' => 'Oriya (India)',
            'om_ET' => 'Oromo (Ethiopia)',
            'om_KE' => 'Oromo (Kenya)',
            'os_RU' => 'Ossetic (Russia)',
            'pap_AN' => 'Papiamento (Netherlands Antilles)',
            'ps_AF' => 'Pashto (Afghanistan)',
            'fa_IR' => 'Persian (Iran)',
            'pl_PL' => 'Polish (Poland)',
            'pt_BR' => 'Portuguese (Brazil)',
            'pt_PT' => 'Portuguese (Portugal)',
            'pa_IN' => 'Punjabi (India)',
            'pa_PK' => 'Punjabi (Pakistan)',
            'ro_RO' => 'Romanian (Romania)',
            'ru_RU' => 'Russian (Russia)',
            'ru_UA' => 'Russian (Ukraine)',
            'sa_IN' => 'Sanskrit (India)',
            'sc_IT' => 'Sardinian (Italy)',
            'gd_GB' => 'Scottish Gaelic (United Kingdom)',
            'sr_ME' => 'Serbian (Montenegro)',
            'sr_RS' => 'Serbian (Serbia)',
            'sid_ET' => 'Sidamo (Ethiopia)',
            'sd_IN' => 'Sindhi (India)',
            'si_LK' => 'Sinhala (Sri Lanka)',
            'sk_SK' => 'Slovak (Slovakia)',
            'sl_SI' => 'Slovenian (Slovenia)',
            'so_DJ' => 'Somali (Djibouti)',
            'so_ET' => 'Somali (Ethiopia)',
            'so_KE' => 'Somali (Kenya)',
            'so_SO' => 'Somali (Somalia)',
            'nr_ZA' => 'South Ndebele (South Africa)',
            'st_ZA' => 'Southern Sotho (South Africa)',
            'es_AR' => 'Spanish (Argentina)',
            'es_BO' => 'Spanish (Bolivia)',
            'es_CL' => 'Spanish (Chile)',
            'es_CO' => 'Spanish (Colombia)',
            'es_CR' => 'Spanish (Costa Rica)',
            'es_DO' => 'Spanish (Dominican Republic)',
            'es_EC' => 'Spanish (Ecuador)',
            'es_SV' => 'Spanish (El Salvador)',
            'es_GT' => 'Spanish (Guatemala)',
            'es_HN' => 'Spanish (Honduras)',
            'es_MX' => 'Spanish (Mexico)',
            'es_NI' => 'Spanish (Nicaragua)',
            'es_PA' => 'Spanish (Panama)',
            'es_PY' => 'Spanish (Paraguay)',
            'es_PE' => 'Spanish (Peru)',
            'es_ES' => 'Spanish (Spain)',
            'es_US' => 'Spanish (United States)',
            'es_UY' => 'Spanish (Uruguay)',
            'es_VE' => 'Spanish (Venezuela)',
            'sw_KE' => 'Swahili (Kenya)',
            'sw_TZ' => 'Swahili (Tanzania)',
            'ss_ZA' => 'Swati (South Africa)',
            'sv_FI' => 'Swedish (Finland)',
            'sv_SE' => 'Swedish (Sweden)',
            'tl_PH' => 'Tagalog (Philippines)',
            'tg_TJ' => 'Tajik (Tajikistan)',
            'ta_IN' => 'Tamil (India)',
            'tt_RU' => 'Tatar (Russia)',
            'te_IN' => 'Telugu (India)',
            'th_TH' => 'Thai (Thailand)',
            'bo_CN' => 'Tibetan (China)',
            'bo_IN' => 'Tibetan (India)',
            'tig_ER' => 'Tigre (Eritrea)',
            'ti_ER' => 'Tigrinya (Eritrea)',
            'ti_ET' => 'Tigrinya (Ethiopia)',
            'ts_ZA' => 'Tsonga (South Africa)',
            'tn_ZA' => 'Tswana (South Africa)',
            'tr_CY' => 'Turkish (Cyprus)',
            'tr_TR' => 'Turkish (Turkey)',
            'tk_TM' => 'Turkmen (Turkmenistan)',
            'ug_CN' => 'Uighur (China)',
            'uk_UA' => 'Ukrainian (Ukraine)',
            'hsb_DE' => 'Upper Sorbian (Germany)',
            'ur_PK' => 'Urdu (Pakistan)',
            'uz_UZ' => 'Uzbek (Uzbekistan)',
            've_ZA' => 'Venda (South Africa)',
            'vi_VN' => 'Vietnamese (Vietnam)',
            'wa_BE' => 'Walloon (Belgium)',
            'cy_GB' => 'Welsh (United Kingdom)',
            'fy_DE' => 'Western Frisian (Germany)',
            'fy_NL' => 'Western Frisian (Netherlands)',
            'wo_SN' => 'Wolof (Senegal)',
            'xh_ZA' => 'Xhosa (South Africa)',
            'yi_US' => 'Yiddish (United States)',
            'yo_NG' => 'Yoruba (Nigeria)',
            'zu_ZA' => 'Zulu (South Africa)'
        );
    }

    /**
     * Checks if the given url is a internal one
     * @param $url string Any url
     * @return bool
     */
    function isInternalUrl($url)
    {
        if (Str::contains($url, [str_replace("https://", "", Config::get("app.APP_URL")),
            str_replace("http://", "", Config::get("app.APP_URL"))])) {
            return true;
        }
        return false;
    }

    /**
     * @param $url string Should be url that end with some file name '.jpg|.php' or so pass false to strict mode to get the last path from the url
     * @param bool $strict_mode Default is true so will return the filename eg : filname.jpg
     * @param null $default_name If nothing is found you can pass in the default name that you would like to have
     * @return string A filename or the default filename that was passed
     * @throws \Exception If url is not passed this will throw a Exception
     */
    function getFileNameFromUrl($url, $strict_mode = true, $default_name = null)
    {
        if ($this->isUrl($url)) {
            $tp = explode("/", $url);
            if (is_array($tp)) {
                $tp_name = end($tp);
                if (Str::contains($tp_name, ".") && $strict_mode) {
                    return $tp_name;
                } else {
                    return $tp_name;
                }
            }
        } else {
            throw new \Exception("It's not a url");
        }
        return $default_name;
    }

    /**
     * Check for empty|null and not " " and if its not then returns the value
     * Mostly will be used by ternary operator [??] PHP 7.1 >
     * Was written as ?? considers space and return space with trim it works properly
     * @param $item string|array item to verify
     * @return string|null Return given parameter else null
     */
    function getIfNotEmpty($item)
    {
        if (empty(is_string($item) ? trim($item) : (is_array($item) ? count($item) : 0))) {
            return null;
        }
        return $item;
    }

    /**
     * Get all the available translation [These looks for folder which has a common.php]
     * Note this looks for all the files in the lang folder and gets the folder name
     * @return array List of all transalation available
     */
    public function getAllAvailableTrans()
    {
        $all_available_folder = array_filter(glob(base_path('resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR) . "*"), 'is_dir');
        $all_available_folder = array_filter($all_available_folder, function ($folder_path) {
            if (!File::exists($folder_path . DIRECTORY_SEPARATOR . "common.php")) {
                return false;
            }
            return true;
        });
        return array_map(function ($folder) {
            return File::basename($folder);
        }, array_unique($all_available_folder));
    }

    /**
     * Function to keep folders safe.
     * @param array $folders
     */
    public function keepFolderSafe(array $folders)
    {
        foreach ($folders as $folder) {
            $work_on = public_path($folder) . "\\";
            if (File::isDirectory($work_on)) {
                $file_name = $work_on . ".htaccess";
                if (!file_exists($file_name)) {
                    $file_handle = fopen($file_name, 'a') or die("From Safety Function");
                    $content_string = '<FilesMatch "\.(php|php1|php2|php3|php4|php5|php6|php7|php8|phtml|cgi|asp)$">' . PHP_EOL;
                    fwrite($file_handle, $content_string);
                    $content_string = "deny from all" . PHP_EOL;
                    fwrite($file_handle, $content_string);
                    $content_string = "</FilesMatch>" . PHP_EOL;
                    fwrite($file_handle, $content_string);
                    fclose($file_handle);
                }
            }
        }
    }

    /**
     * if the supplied php version is greater than the running version then it will return the current version
     * @param string $version Pass php version
     * @return bool|string Current Running Version Or False if Lesser version was supplied
     */
    function phpVersion($version = '7.0.0')
    {
        if (version_compare(PHP_VERSION, $version) >= 0) {
            return PHP_VERSION;
        }
        return false;
    }

    /**
     * Check for file existence and return filename on success or return the default # or the default value that you have supplied
     * @param $file_path string Path of the file that you want to test for.
     * @param $file_name string File that you like to check existence of.
     * @param string $default "#"
     * @return string Return the filename|default parameter that you have passed.
     */
    function fileChecker($file_path, $file_name, $default = "#")
    {
        if (File::exists($file_path . "/" .  UTF8::cleanup($file_name)) && !empty($file_name)) {
            return UTF8::cleanup($file_name);
        }
        return UTF8::cleanup($default);
    }

    /**
     * Checks license by pinging Parent Server
     * @param null $license_code
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function checkLicense($license_code = null, $request = null)
    {
        $url_to_test = "";
        if ($license_code) {
            $url_to_test = config('app.PARENT_WEBSITE') . "/check-purchase/" . $license_code;
        } else {
            if (!empty(\App\Facades\Common::getSiteSettings("purchase_code"))) {
                $url_to_test = config('app.PARENT_WEBSITE') . "/check-purchase/" . \App\Facades\Common::getSiteSettings("purchase_code");
            } else {
                return false;
            }
        }
        $product_status = $this->curlPost($url_to_test, "");
        if ($product_status) {
            $obj = json_decode($product_status, true);
            if (isset($obj["message"])) {
                Setting::updateOrCreate(["option_key" => "expired_on"], ["option_key" => "expired_on", "option_value" => ""]);
                Setting::updateOrCreate(["option_key" => "bought_on"], ["option_key" => "bought_on", "option_value" => ""]);
                if ($request) {
                    $request->merge(["expired_on" => ""]);
                    $request->merge(["bought_on" => ""]);
                }
            } else {
                if (isset($obj["status"]) && $obj["status"]) {
                    Setting::updateOrCreate(["option_key" => "expired_on"], ["option_key" => "expired_on", "option_value" => ""]);
                    Setting::updateOrCreate(["option_key" => "bought_on"], ["option_key" => "bought_on", "option_value" => isset($obj["bought_on"]) ? $obj["bought_on"] : ""]);
                    if ($request) {
                        $request->merge(["bought_on" => isset($obj["bought_on"]) ? $obj["bought_on"] : ""]);
                        $request->merge(["expired_on" => ""]);
                    }
                } else {
                    Setting::updateOrCreate(["option_key" => "expired_on"], ["option_key" => "expired_on", "option_value" => isset($obj["expired_on"]) ? $obj["expired_on"] : ""]);
                    Setting::updateOrCreate(["option_key" => "bought_on"], ["option_key" => "bought_on", "option_value" => ""]);
                    if ($request) {
                        $request->merge(["expired_on" => isset($obj["expired_on"]) ? $obj["expired_on"] : ""]);
                        $request->merge(["bought_on" => ""]);
                    }
                }
            }
        }
        if ($request) {
            return $request;
        }
    }

    /**
     * Checks if system is installed
     * @return bool
     */
    function checkIfSystemInstalled()
    {
        if (File::exists(storage_path() . DIRECTORY_SEPARATOR . "installed")) {
            return true;
        }
        return false;
    }

    /**
     *  It basically deletes the file called installed from the storage paths.
     */
    function removeInstallTrace()
    {
        if (File::exists(storage_path() . DIRECTORY_SEPARATOR . "installed")) {
            File::delete(storage_path() . DIRECTORY_SEPARATOR . "installed");
        }
    }

    /**
     * It basically creates a file called installed in the storage paths.
     */
    function installedSystem()
    {
        $f = fopen(storage_path() . DIRECTORY_SEPARATOR . "installed", "w");
        fwrite($f, "Done Installing");
        fclose($f);
    }

    /**
     * Returns the array of items mapped to ASIN
     *
     * @param array $items Items value.
     * @return array of \Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item mapped to ASIN.
     */
    function parseResponse($items)
    {
        $mappedResponse = [];
        foreach ($items as $item) {
            $mappedResponse[$item->getASIN()] = $item;
        }
        return $mappedResponse;
    }

    /**
     * @param array $asin Should be an array of asin of amazon.
     * @param bool $getBasic [Gets a collection of images,url,title,asin]
     * @param null $requestData [We can control what data we need from api]
     * @return array|null
     * @throws Exception "Error forming the request | Error calling PA-API 5.0!"
     */
    function getAmazonResponse($asin = [], $getBasic = false, $requestData = null)
    {
        $config = new Configuration();
        $config->setAccessKey($this->fallBack(\App\Facades\Common::getSiteSettings("amz_access_key"), config("app.ACCESS_KEY")));
        $config->setSecretKey($this->fallBack(\App\Facades\Common::getSiteSettings("amz_secret_key"), config("app.SECRET_KEY")));
        $partnerTag = $this->fallBack(\App\Facades\Common::getSiteSettings("amz_tag"), config("app.AMAZON_TAG"));
        /*
         * https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
         */
        $config->setHost($this->fallBack(\App\Facades\Common::getSiteSettings("amz_host"), config("app.AMAZON_HOST")));
        $config->setRegion($this->fallBack(\App\Facades\Common::getSiteSettings("amz_region"), config("app.AMAZON_REGION")));

        if (empty(trim($config->getAccessKey())) || empty(trim($config->getSecretKey())) || empty(trim($partnerTag)) || empty(trim($config->getHost()))
            || empty(trim($config->getRegion()))) {
            throw new Exception("Some of amazon api setting are missing. kindly check.");
        }

        $apiInstance = new DefaultApi(
            new \GuzzleHttp\Client(),
            $config
        );
        # Choose item id(s)
        $itemIds = $asin; // which is the isbn nos

        /*
         * Choose resources you want from GetItemsResource enum
         * For more details, refer: https://webservices.amazon.com/paapi5/documentation/get-items.html#resources-parameter
         */
        $resources = [
            GetItemsResource::ITEM_INFOTITLE,
            GetItemsResource::IMAGESPRIMARYLARGE,
        ];
        if ($requestData && is_array($requestData)) {
            $resources = $requestData;
        }
        # Forming the request
        $getItemsRequest = new GetItemsRequest();
        $getItemsRequest->setItemIds($itemIds);
        $getItemsRequest->setPartnerTag($partnerTag);
        $getItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
        $getItemsRequest->setResources($resources);

        # Validating request
        $invalidPropertyList = $getItemsRequest->listInvalidProperties();
        $length = count($invalidPropertyList);
        if ($length > 0) {
            throw new Exception("Error forming the request");
        }
        # Sending the request
        try {
            $getItemsResponse = $apiInstance->getItems($getItemsRequest);
            # Parsing the response
            $item = $getItemsResponse->getItemsResult();
            if ($item !== null) {
                if ($item->getItems() !== null) {
                    $responseList = $this->parseResponse($item->getItems());
                    if ($getBasic) {
                        $dataToSend = [];
                        foreach ([$asin] as $itemId) {
                            $item = $responseList[$itemId] ?? null;
                            if ($item !== null) {
                                if ($item->getASIN()) {
                                    $dataToSend["asin"][] = $item->getASIN();
                                }
                            }
                            if ($item->getItemInfo() !== null and $item->getItemInfo()->getTitle() !== null
                                and $item->getItemInfo()->getTitle()->getDisplayValue() !== null) {
                                $dataToSend['title'][] = $item->getItemInfo()->getTitle()->getDisplayValue();
                            }
                            if ($item->getImages() !== null) {
                                $image_name = \Util::saveFileFromUrl($item->getImages()->getPrimary()->getLarge()->getURL(), ".jpg");
                                $dataToSend['cover_img'][] = asset("uploads/" . $image_name,false);
                            }
                            if ($item->getImages() !== null) {
                                $image_name = \Util::saveFileFromUrl($item->getImages()->getPrimary()->getLarge()->getURL(), ".jpg");
                                $dataToSend['cover_img'][] = asset("uploads/" . $image_name,false);
                            }
                            if ($item->getDetailPageURL()) {
                                $dataToSend['page_url'][] = $item->getDetailPageURL();
                            }

                        }
                        return $dataToSend;
                    } else {
                        return $responseList;
                    }
                }
            } else {
                if (!is_null($item) && is_array($item->getErrors()) && count($item->getErrors())) {
                    throw new Exception("Item inaccessible by amazon");
                }
            }
        } catch (\Exception $exception) {
            throw  $exception;
        }
        return null;
    }

    /**
     * @param array $models Collection of any model instances
     * @param $property string Property name to target
     * @param $path string Location of the folder where to look for models
     * @return bool Returns true even if one file is deleted.
     */
    public function smartDelete($property, $path, $models = array(), $decompress = false)
    {
        $delete_status = false;
        if (is_countable($models) && count($models) && !empty($path) && !empty($path)) {
            if ($decompress) {
                foreach ($models as $model_obj) {
                    if (isset($model_obj->$property) && !empty($model_obj->$property)) {
                        $files_to_remove = $model_obj->files_attached;
                        // If there are no unboxing happening automatically then lets unbox it manually.
                        if (is_string($files_to_remove)) {
                            $files_to_remove = json_decode($files_to_remove, true);
                        }
                        if (is_array($files_to_remove)) {
                            if ($files_to_remove) {
                                foreach ($files_to_remove as $file) {
                                    $file_loc = $path . '/' . $file;
                                    if ($file_loc) {
                                        //File::delete($file_loc);
                                        $delete_status = true;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                foreach ($models as $model_obj)
                    if ($model_obj) {
                        if (isset($model_obj->$property) && !empty($model_obj->$property)) {
                            $file_loc = $path . "/" . $model_obj->$property;
                            if (File::exists($file_loc)) {
                                //File::delete($file_loc);
                                $delete_status = true;
                            }
                        }
                    }
            }
        }
        return $delete_status;
    }

    /**
     * Clean and return some good looking url
     * @param $badLookingUrl string url Give any url http://|https:// and i will do it www.
     * @return string return good looking url
     */
    function goodUrl($badLookingUrl)
    {
        if ($badLookingUrl && filter_var($badLookingUrl, FILTER_VALIDATE_URL)) {
            $tmp = Str::of($badLookingUrl)->replace("https://", "")->replace("http://", "");
            if ($tmp->startsWith("www")) {
                return $tmp->__toString();
            } else {
                return "www." . $tmp->__toString();
            }
        }
    }


    /**
     * Returns a good formatted html for address
     * @param $m_address string Address String
     * @return string Return a good formatted address.
     */
    function goodFormatAddress($m_address)
    {
        $address_html = "";
        if (Str::of($m_address)->contains(",")) {
            try {
                $address_lst = explode(",", $m_address);
                if (is_countable($address_lst)) {
                    $address_html .= "<p><strong>" . $address_lst[0] . "</strong>, ";
                    unset($address_lst[0]);
                    foreach ($address_lst as $address) {
                        if (Str::of($address)->contains("-")) {
                            $tmp = explode("-", $address);
                            $tmp_raw_html = "";
                            if (is_countable($tmp)) {
                                $tmp_raw_html .= isset($tmp[0]) ? $tmp[0] : "";
                                $tmp_raw_html .= isset($tmp[1]) && is_numeric($tmp[1]) ? " <strong>" . $tmp[1] . "</strong>" : "";
                                unset($tmp[0]);
                                unset($tmp[1]);
                                if (count($tmp) > 2) {
                                    $tmp_raw_html = implode(",", $tmp);
                                }
                            }
                            $address_html .= $tmp_raw_html;
                        } else {
                            $address_html .= $address . ",";
                        }
                    }
                    $address_html = rtrim($address_html, ",");
                    $address_html .= "</p>";
                    return $address_html;
                }
            } catch (Exception $e) {
                return $m_address;
            }
        }
    }

    /**
     * Return a random number of the supplied length.
     * This ensure that we always has a unique number.
     * @param $length int Nos of digits you require
     * @param $model \Eloquent Eloquent Model which need to be scanned
     * @param $property string Property that needs to be tested
     * @return string Return the random number of the specified length
     */
    function generateRandomNumber($length, $model = null, $property = null)
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        if (isset($model) && !$model::where($property, $result)->exists()) {
            return $result;
        } else {
            $this->generateRandomNumber($length, $model, $property);
        }
    }


    /**
     * Return ids collection of uncleaned ids to be inserted.
     * Creates ids for not found data and sends it back.
     * @param $working_array array
     * @param $property string
     * @param $model
     * @return array
     */
    function smartEnteriesCreator($working_array, $property, $model)
    {
    Log::info($working_array);
        $dato_to_send = [];
        foreach ($working_array as $item) {
            if (is_numeric($item)) {
                $dato_to_send[] = $item;
            } else {
                $tmp = $model::firstOrCreate([$property => $item]);
                if ($tmp) {
                    $dato_to_send[] = $tmp->id;
                }
            }
        }
        return $dato_to_send;
    }

    /**
     * Clears All Kind Of Caches And Unwanted Backups
     */
    public function clearCache()
    {
        try {
            $command = ["cache:clear", "view:clear", "route:clear",
                "clear-compiled", "config:clear", "config:cache", "permission:cache-reset", "backup:clean"];
            foreach ($command as $cmd) {
                Artisan::call($cmd);
            }
        }catch (\Exception $e){}
    }
}

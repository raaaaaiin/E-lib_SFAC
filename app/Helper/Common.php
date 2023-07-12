<?php

namespace App\Helper;


use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\Book;
use App\Models\BookTag;
use App\Models\BookMedtype;
use App\Models\Borrowed;
use App\Models\Category;
use App\Models\CourseYear;
use App\Models\DeweyDecimal;
use App\Models\IssueBookReq;
use App\Models\Publisher;
use App\Models\BookPublisher;
use App\Models\Setting;
use App\Models\Course;
use App\Models\SubBook;
use App\Models\Medtype;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserDataMeta;
use App\Models\UserMeta;
use App\Models\VisitorTracking;
use App\Models\Year;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use \App\Facades\Util;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Self_;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use stringEncode\Exception;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ProductAdvertisingAPIClientException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use voku\helper\UTF8;


class Common
{
    private $working_year;
    private $first_working_date;
    private $last_working_date;
    private $admin_email;
    private $system_email;
    private $admin_page_name;
    private $org_name;

    private $default_role;

    private $all_roles;
    private $all_users;
    private $all_course_year;
    private $all_course;
    private $all_permissions;
    private $user_collection = array();
    private $role_collection = array();
    private $course_year_collection = array();
    private $course_collection = array();
    private $author_collection = array();
    private $publisher_collection = array();
    private $dewey_collection = array();
    private $shelf_collection = array();

    private $setting_collection = array();
    private $year_collection = array(); #Working Year
    private $permission_collection = array();
    private $all_categorys;
    private $all_authors;
    private $all_publishers;
    private $all_tags;
    private $all_parent_category;
    private $all_medtype;

    private $tag_collection;
    private $category_collection;
    public $default_roles = ["super admin", "teacher", "student"];
    public $default_permissions = ["mng-setting", "mng-user", "mng-subscriber", "mng-notice", "mng-role-permission", "mng-slider"
        , "mng-class", "mng-book", "mng-enquiry", "mng-lib-stat", "mng-graph-stat", "mng-borrow-book", "mng-transaction",
        "mng-note", "mng-translation", "mng-author", "mng-tag", "mng-publisher", "mng-report", "mng-classification"];

    /**
     * Initialize all the variable | Constructor
     */
    public function __construct()
    {

        if (!Util::checkIfSystemInstalled() && request()->is("install-db")) {
            DB::unprepared(file_get_contents(storage_path("dummy.sql")));
            Util::installedSystem();
            echo "System has been installed. Clear cache -> <a href='" . config('app.APP_URL') . "'>Clear Cache</a>";
        } else {
            if((\Schema::hasTable("users") || \Schema::hasTable("books")) & !Util::checkIfSystemInstalled())
            {Util::installedSystem();}
            $this->working_year = $this->getSiteSettings("working_year");
            $this->default_role = $this->getSiteSettings("default_role");
            $this->last_working_date = $this->getSiteSettings("last_working_date");
            $this->admin_email = $this->getSiteSettings("admin_email");
            $this->system_email = $this->getSiteSettings("system_email");
            $this->admin_page_name = $this->getSiteSettings("admin_page_name");
            $this->org_name = $this->getSiteSettings("org_name");
            $this->all_roles = Role::all();
            $this->all_users = User::all();
            $this->all_course_year = CourseYear::all();
            $this->all_course = Course::all();
            $this->all_years = Year::all();
            $this->all_permissions = Permission::all();
            $this->all_parent_category = DeweyDecimal::where("parent", 0)->get();
            $this->all_categorys = DeweyDecimal::all();
            $this->all_authors = Author::all();
            $this->all_publishers = Publisher::all();
            $this->all_tags = Tag::all();
            $this->all_medtype = Medtype::all();

            foreach ($this->all_tags as $tag) {
                $this->tag_collection[$tag->id] = $tag->name;
            }

            foreach ($this->all_authors as $author) {
                $this->author_collection[$author->id] = $author->name;
            }
            foreach ($this->all_publishers as $publisher) {
                $this->publisher_collection[$publisher->id] = $publisher->name;
            }

            foreach ($this->all_categorys as $cat) {
                $this->category_collection[$cat->id] = $cat->cat_name;
                $this->dewey_collection[$cat->id] = $cat->dewey_no;
                $this->shelf_collection[$cat->id] = $cat->shelf_no;
            }
            foreach ($this->all_roles as $role) {
                $this->role_collection[$role->id] = $role->name;
            }

            foreach ($this->all_course as $course) {
                $this->course_collection[$course->id] = $course->name;
            }
            foreach ($this->all_course_year as $course_year) {
                $this->course_year_collection[$course_year->id] = $course_year->year;
            }
            foreach ($this->all_years as $year) {
                $this->year_collection[$year->id] = $year->year_from;
            }

            foreach ($this->all_users as $user) {
                $this->user_collection[$user->id] = $user->name;
            }
            foreach (Setting::all() as $setting_obj) {
                if (Str::endsWith($setting_obj->option_key, "_list")) {
                    $this->setting_collection[$setting_obj->option_key] = json_decode($setting_obj->option_value);
                } else {
                    if (in_array($setting_obj->option_key, ["toggles", "contacts", "testimonials", "books",
                        "faqs", "toi", "pp"])) {
                        $contents = (array)json_decode($setting_obj->option_value);
                        $this->setting_collection = array_merge($this->setting_collection, $contents);
                        $demo = 0;
                    } else {
                        $this->setting_collection[$setting_obj->option_key] = $setting_obj->option_value;
                    }
                }
            }

            Util::keepFolderSafe(["uploads"]);
        }
    }

    /**
     * Return Tag Name from Tag Id
     * @return string
     */
     public function getMostClickedBook(){

     }
     public function getSuggestion(){

     }
     public function getAchieverStudent(){

     }
     public function getMostRecentBorrowed(){

     }
     public function getMostAchiever(){

     }
     public function getMostViewedperweek(){

     }
     public function getRecentborrow(){

     }
     public function getAwards(){

     }

    public function getTagName($tag_id)
    {
        return isset($this->tag_collection[$tag_id]) ? $this->tag_collection[$tag_id] : "--";
    }


     public function getAllMedtypes(){
        return $this->all_medtype;
    }
     public function getMedtypesInArray()
    {
        return $this->all_medtype->pluck("name", "id")->toArray();
    }
    /**
     * Return Tags collection
     * @return Collection Tag Collection
     */
    public function getAllTags()
    {
        return $this->all_tags;
    }
   
    /**
     * Return Tags Array
     * @return array
     */
    public function getTagsInArray()
    {
        return $this->all_tags->pluck("name", "id")->toArray();
    }

    /**
     * Return Dewey No from Cat Id
     * @return string
     */
    public function getDeweyNos($cat_id)
    {
        return isset($this->dewey_collection[$cat_id]) ? $this->dewey_collection[$cat_id] : "--";
    }

    /**
     * Return Shelf No from Cat Id
     * @return string
     */
    public function getShelfNo($cat_id)
    {
        return isset($this->shelf_collection[$cat_id]) ? $this->shelf_collection[$cat_id] : "--";
    }

    /**
     * Return Authors Collection
     * @return Collection
     */
    public function getAllAuthors()
    {
        return $this->all_authors;
    }

    /**
     * Return Authors In Array
     * @return array
     */
    public function getAllAuthorsInArray()
    {
        return $this->all_authors->pluck("name", "id")->toArray();
    }

    /**
     * Return Authors Name
     * @return string
     */
    public function getAuthorName($author_id)
    {
        return isset($this->author_collection[$author_id]) ? $this->author_collection[$author_id] : "--";
    }

    /**
     * Return Publishers Collection
     * @return Collection
     */
    public function getAllPublishers()
    {
        return $this->all_publishers;
    }

    /**
     * Return Authors In Array
     * @return array
     */
    public function getAllPublishersInArray()
    {
        return $this->all_publishers->pluck("name", "id")->toArray();
    }

    /**
     * Return Publisher Name
     * @return string
     */
    public function getPublisherName($publisher_id)
    {
        return isset($this->publisher_collection[$publisher_id]) ? $this->publisher_collection[$publisher_id] : "--";
    }



    /**
     * Return ParentCats from Dewey System
     * @return array
     */
    public function getAllParentCats()
    {
        return $this->all_parent_category;
    }

    /**
     * Get Category Name from cat id
     * @param $cat_id int
     * @return string Category Name
     */
    public function getCatName($cat_id)
    {

        return isset($this->category_collection[$cat_id]) ? $this->category_collection[$cat_id] : "--";
    }

    /**
     * Get Parent Category Name from cat id
     * @return array Parent Category Collection In Array
     */
    public function getAllParentCatInArray()
    {
        return $this->all_parent_category->pluck("cat_name", "id");
    }

    /**
     * Get All Category Collection
     * @return Collection All Category Collection In Array
     */
    public function getAllCatInArray()
    {
        return $this->category_collection;
    }

    /**
     * Get parent category of given sub_category id
     * @return int|null Get parent cat of the given sub cat or null if not found.
     */
    public function getParentCatOfSubCat($sub_cat_id)
    {
        $tmp = DeweyDecimal::find($sub_cat_id);
        if ($tmp) {
            return $tmp->parent;
        } else {
            return null;
        }
    }


    /**
     * Return Setting In Array
     * @return array
     */
    public function getAllSettingInArray()
    {
        return $this->setting_collection;
    }

    /**
     * Return Permission Collection
     * @return Permission[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllPermissions()
    {
        return $this->all_permissions;
    }


    /**
     * Return Working Year Collection
     * @return Year[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllYears()
    {
        return $this->all_years;
    }

    /**
     * Get User Name from user id
     * @param $user_id int
     * @return string User Name
     */
    public function getUserName($user_id)
    {

        return isset($this->user_collection[$user_id]) ? $this->user_collection[$user_id] : "--";
    }

    /**
     * Return User Collection
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->all_users;
    }

    /**
     * Return an array of std=>div collection in which the current logged in assigned to.
     * @return array|mixed Most probably it will return an array.
     */
    public function getStandardDivisionAssignedToLoggedInUser($v_id = null)
    {
    if(empty($v_id)){
     if (Auth::check()) {
            $user_meta = UserMeta::where("user_id", Auth::id())->first();
            if ($user_meta) {
                return json_decode($user_meta->get_assign());
            }
        }
    }else{
            $user_meta = UserMeta::where("user_id", $v_id)->first();
            if ($user_meta) {
                return json_decode($user_meta->get_assign());
            }
    }
       
        return [];
    }
    public function getTotalFines($v_id = null)
    {
    if(empty($v_id)){
     if (Auth::check()) {
            $user_meta = UserMeta::where("user_id", Auth::id())->where("meta_key","fines")->first();
            if ($user_meta) {
                return $user_meta->meta_value;
            }
        }
    }else{
            $user_meta = UserMeta::where("user_id", $v_id)->where("meta_key","fines")->first();
            
            if ($user_meta) {
                return $user_meta->meta_value;
            }
    }
       
        return [];
    }
    public function CreateTotalFines($v_id = null,$fines)
    {

     $user_meta = UserMeta::where("user_id", $v_id)->where("meta_key","fines")->first();
            
            $value = $user_meta->meta_value() ? $user_meta->meta_value() : 0;
            $value = $value + $fines;
             UserMeta::updateOrCreate(["meta_key" => "fines", "user_id" => Auth::id()], ["meta_value" => $value]);
           
    }
    /**
     * Return Role Collection
     * @return Role[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return $this->all_roles;
    }

    /**
     * Return Course Collection
     * @return Course[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllCourses()
    {
        return $this->all_course;
    }

    /**
     * Return CourseYear COllection
     * @return CourseYear[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllCourseYears()
    {
        return $this->all_course_year;
    }

    /**
     * Return first working date
     * @return string Date Format
     */
    public function getFirstWorkingDate()
    {
        return $this->first_working_date;
    }

    /**
     * Returns last working date
     * @return string Date Format
     */
    public function getLastWorkingDate()
    {
        return $this->last_working_date;
    }

    /**
     * Returns Admin Email Id
     * @return string|null
     */
    public function getAdminEmailId()
    {
        return $this->admin_email;
    }

    /**
     * Returns System Email Id [Mostly use to send emails]
     * @return string|null
     */
    public function getSystemEmailId()
    {
        return $this->system_email;
    }

    /**
     * Returns Admin Page Name
     * @return string|null
     */
    public function getAdminPageName()
    {
        return $this->admin_page_name;
    }

    /**
     * Returns Organisation Name
     * @return string|null
     */
    public function getOrgName()
    {
        return $this->org_name;
    }


    /**
     * if the user is logged in then will return the current user object else false
     * @return mixed bool|user
     */
    public function getCurrentUser()
    {

        if (Auth::check()) {
            return User::find(Auth::id());
        } else {
            return false;
        }
    }

    /**
     *  if the user is logged in and the property name is supplied will return property
     *  if it exist in either table [user/usermeta]  else will return false
     * @param $property string name
     * @return mixed bool|property-value
     */
    public function getCurrentUserDetails($property)
    {

        if (Auth::check()) {
            $current_user = $this->get_current_user();
            if (isset($current_user->$property)) {
                return $current_user->$property;
            }
            $user_meta_obj = UserMeta::where("meta_key", $property)->first();
            if ($user_meta_obj) {
                return $user_meta_obj->meta_value;
            }
            return false;
        }
    }


    /**
     * Access the setting
     * @param $prop_name string Property name
     * @param null $default Return defaults if property is empty
     * @return mixed|null Returns property value in [string|array] or default/null
     */
    public function getSiteSettings($prop_name, $default = null)
    {

        if (isset($this->setting_collection[$prop_name])) {
            return $this->setting_collection[$prop_name];
        }
        $prop_obj = Setting::select("option_value")->where("option_key", $prop_name);
        $prop_obj = $prop_obj->first();
        if ($prop_obj) {
            if (Str::endsWith($prop_name, "_list")) {
                return json_decode($prop_obj->option_value);
            }
            return $prop_obj->option_value;
        }
        return $default;
    }

    /**
     * Check if the logged in user is Either Admin|Super Admin
     * @return bool
     */
    public function isAnyAdmin()
    {

        if (Auth::check()) {
            $current_user = User::find(Auth::id());
            return $current_user::check_if_user_has_role("admin") || $current_user::check_if_user_has_role("super admin");
        }
        return false;
    }

    /**
     * Check if logged in user is Admin
     * @return mixed
     */
    public function isAdmin()
    {

        $current_user = User::find(Auth::id());
        return $current_user::check_if_user_has_role("admin");
    }

    /**
     * Check if logged in user is super admin
     * @return mixed
     */
    public function isSuperAdmin()
    {
        $current_user = User::find(Auth::id());
        return $current_user::check_if_user_has_role("super admin");
    }


    /**
     * Cleans the error message.
     * @param $message string Error string
     * @return string Gives you cleaned error message which can be displayed
     */
    public function reformatErrorMsg($message)
    {

        return Str::ucfirst(Str::of(
            Str::replaceFirst("or phone", "other phone",
                Str::replaceFirst("The", "",
                    Str::replaceFirst("the", "",
                        Str::replaceFirst("The current", "",
                            Str::replaceFirst("guard 2 ", "",
                                Str::replaceFirst("guard 1 ", "",
                                    Str::replaceFirst("field ", "",
                                        Str::replaceFirst("The app", "", $message)))))))))->trim());
    }


    /**
     * Get Role Name from role id
     * @param $role_id int
     * @return string Role Name
     */
    public function getRoleName($role_id)
    {

        return isset($this->role_collection[$role_id]) ? $this->role_collection[$role_id] : "--";
    }

    /**
     * Get CourseName
     * @param $course_id int
     * @return string Course Name
     */
    public function getCourseName($course_id)
    {
        return isset($this->course_collection[$course_id]) ? $this->course_collection[$course_id] : "--";
    }

    /**
     * Get Default Role
     * @return int Role Id
     */
    public function getDafaultRole()
    {
        return $this->default_role;
    }

    /**
     * Get CourseYear name
     * @param $course_year_id int
     * @return string CourseYear Name
     */
    public function getCourseYearName($course_year_id)
    {
        return isset($this->course_year_collection[$course_year_id]) ? $this->course_year_collection[$course_year_id] : "--";
    }

    /**
     * Get Year name from year id
     * @param $year_id int
     * @return string Year Name
     */
    public function getYearName($year_id)
    {
        return isset($this->year_collection[$year_id]) ? $this->year_collection[$year_id] : "--";
    }

    /**
     * Return working year id
     * @return integer
     */
    public function getWorkingYear()
    {
        return $this->working_year;
    }


    /**
     * Analyse and convert the junk details of google book api to cleaned arrays
     * @param $datas mixed Requires the object of google api
     * @return array Return array of cleaned objects
     */
    public function analyseBookDetails($datas)
    {
        if (is_string($datas) && !empty($datas)) {
            $book['publisher'] = "";
            $book["isbn_10"] = "";
            $book["isbn_13"] = "";
            $book['author_name'] = "";
            $book['title'] = "";
            $book['cover_img'] = "";
            $book['preview_url'] = "";
            $book['publishedDate'] = "";
            $book['preview_url'] = "";
            $book['price'] = "";
            # Sending the request
            try {
                $responseList = Util::getAmazonResponse([$datas]);
                if ($responseList !== null) {
                    foreach ([$datas] as $itemId) {
                        $item = $responseList[$itemId];
                        if ($item !== null) {
                            if ($item->getASIN()) {
                                $book["isbn_10"] = $item->getASIN();
                            }
                            if ($item->getItemInfo() !== null and $item->getItemInfo()->getTitle() !== null
                                and $item->getItemInfo()->getTitle()->getDisplayValue() !== null) {
                                $book['title'] = $item->getItemInfo()->getTitle()->getDisplayValue();
                               

                            }
                           
                            if ($item->getImages() !== null) {
                                $image_name = \Util::saveFileFromUrl($item->getImages()->getPrimary()->getLarge()->getURL(), ".jpg");
                                $book['cover_img'] = asset("uploads/" . $image_name,false);
                            }
                            if ($item->getDetailPageURL()) {
                                $book['preview_url'] = $item->getDetailPageURL();
                            }
                        }
                    }
                }
            } catch (Exception $exception) {
                throw  $exception;
            }
            return $book;
        }

        if (!isset($datas["bib_key"])) {
            $book = [];
            $book['author_name'] = isset($datas["items"][0]["volumeInfo"]["authors"]) ? implode(",", $datas["items"][0]["volumeInfo"]["authors"]) : "";

            $book['unique_id'] = isset($datas["items"][0]["id"]) ? $datas["items"][0]["id"] : 'R-' . \App\Facades\Util::generateRandomString(5);
            $book['title'] = isset($datas["items"][0]["volumeInfo"]["title"]) ? $datas["items"][0]["volumeInfo"]["title"] : "--";
            $book['publishedDate'] = isset($datas["items"][0]["volumeInfo"]["title"]) ? $datas["items"][0]["volumeInfo"]["publishedDate"] : "--";
            $book['publisher'] = isset($datas["items"][0]["volumeInfo"]["publisher"]) ? $datas["items"][0]["volumeInfo"]["publisher"] : "--";
            if (isset($datas["items"][0]["volumeInfo"]["industryIdentifiers"])) {
                foreach ($datas["items"][0]["volumeInfo"]["industryIdentifiers"] as $identifier) {
                    if ($identifier["type"] == "ISBN_10") {
                        $book['isbn_10'] = $identifier["identifier"];
                    }
                    if ($identifier["type"] == "ISBN_13") {
                        $book['isbn_13'] = $identifier["identifier"];
                    }
                }
            }
            $book['desc'] = isset($datas["items"][0]["volumeInfo"]["description"]) ? $datas["items"][0]["volumeInfo"]["description"] : "";
            $book['cover_img'] = isset($datas["items"][0]["volumeInfo"]["imageLinks"]["thumbnail"]) ? $datas["items"][0]["volumeInfo"]["imageLinks"]["thumbnail"] :
                (isset($datas["items"][0]["volumeInfo"]["imageLinks"]["smallThumbnail"]) ? $datas["items"][0]["volumeInfo"]["imageLinks"]["smallThumbnail"] : null);
            $book['preview_url'] = isset($datas["items"][0]["volumeInfo"]["previewLink"]) ? $datas["items"][0]["volumeInfo"]["previewLink"] : "";
            return $book;
        } else {
            $book = [];
            $isbn_tmp = str_replace("ISBN:", "", str_replace("-", "", isset($datas['bib_key']) ? $datas['bib_key'] : ""));
            if ($isbn_tmp) {
                $book["isbn_13"] = $isbn_tmp;
            }
            if ($isbn_tmp && strlen($isbn_tmp) == 10) {
                $book["isbn_10"] = $isbn_tmp;
            } else {
                $book["isbn_13"] = "";
            }
            $title_tmp = isset($datas['info_url']) ? $datas['info_url'] : "";
            if (\Util::isUrl($title_tmp)) {
                $title_tmp = explode("/", isset($datas['info_url']) ? $datas['info_url'] : "");
                $title = end($title_tmp);
                if ($title) {
                    $book['title'] = str_replace("_", " ", $title);
                }
            }
            $preview_tmp = isset($datas['preview_url']) ? $datas['preview_url'] : "";
            if (Util::isUrl($preview_tmp)) {
                $book['preview_url'] = $preview_tmp;
            }
            $openLibImgTmp = isset($datas['thumbnail_url']) ? $datas['thumbnail_url'] : "";
            if (Util::isUrl($openLibImgTmp)) {
                $openLibImgTmp = str_replace("S.", "L.", $openLibImgTmp);
                $image_name = \Util::saveFileFromUrl($openLibImgTmp, ".jpg");
                $book['cover_img'] = elib("uploads/" . $image_name,true);
            }
            return $book;
        }
    }

    public function getPopularBooks()
    {
        $data = DB::select('select MIN(br.sub_book_id) AS SBID , COUNT(br.sub_book_id) AS CNT , MIN(bo.title) AS TITLE , MIN(bo.id) AS BID
        from `borroweds` br JOIN books bo ON br.book_id = bo.id group by book_id');
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        $data = array_map(function ($tmp) {
            return (array)$tmp;
        }, $data);
        return $data;
    }

    /**
     * Return tracked stats
     * @return mixed
     */
    public function getVisitorStats()
    {
        return VisitorTracking::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'),
            DB::raw('count(distinct(ip_address)) as cnt'))->groupBy('date')->orderBy("date", "desc")->take(30)->get()->toArray();
    }

    /**
     * Get available book count of the give main book id.
     * @param $mb_id int Mian Book Id
     * @return int Return available book count
     */
    public function getAvailableBooks($mb_id)
    {
        return SubBook::where("borrowed", 0)->where("book_id", $mb_id)->count();
    }

    /**
     * Returns data for the front end table formation.
     * @return bool|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getBooksDetailsForFrontEnd()
    {

        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
            $datas = DB::select("SELECT min(b.title) AS TITLE,
count(b.title) AS QTY,
MIN(b.category) AS CATEGORY ,
b.id AS MBID,
count(ibr.id) as Request,
sum(sb.borrowed) AS BORROWED,
COUNT(DISTINCT sb.sub_book_id) AS TBOOKS,
  MIN(cover_img) as CIMG ,
 MIN(sb.active) as ACTIVE,
Concat('[',group_concat(DISTINCT a.author_id separator ','),']') as AUTHOR,
Concat('[',group_concat(DISTINCT c.publisher_id separator ','),']') as PUBLISHER,
Concat('[',group_concat(DISTINCT d.Tag_id separator ','),']') as TAG,
Concat('[',group_concat(DISTINCT e.id separator ','),']') as MEDTYPE,
f.parent as PARENT_CAT,
f.shelf_no  as SHELF_NO
                
FROM books b 
JOIN sub_books sb ON b.id = sb.book_id 
left Join book_author a on b.id = a.book_id
left Join book_publisher c on b.id = c.book_id
left join book_tag d on b.id = d.book_id
left join medtypes e on b.id = e.book_id
left join dewey_decimals f on b.category = f.id
left Join issue_book_reqs ibr on ibr.sub_book_id = sb.sub_book_id
where sb.active=1 
GROUP BY b.category,b.id,sb.book_id");
                
            $datas = array_map(function ($tmp) {
                $tmp = (array)$tmp;
                
                    $tmp["PARENT_CAT"] =  $tmp["PARENT_CAT"];
                      $tmp["SHELF_NO"] =  $tmp["SHELF_NO"];
                
                $tmp["AUTHOR"] =  $tmp["AUTHOR"] ? json_decode($tmp["AUTHOR"]) :  [] ;
                $tmp["PUBLISHER"] = $tmp["PUBLISHER"] ? json_decode($tmp["PUBLISHER"]) :  [] ;
                $tmp["TAG"] = $tmp["TAG"] ? json_decode($tmp["TAG"]) :  [] ;
                $tmp["MEDTYPE"] =$tmp["MEDTYPE"] ? json_decode($tmp["MEDTYPE"]) :  [] ;
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }public function getBooksDetailsForFrontEndCopy()
    {

        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 GROUP BY b.category,b.id,sb.book_id ");
                
            $datas = array_map(function ($tmp) {
                $tmp = (array)$tmp;
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                      $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }public function getBooksDetailsForFrontEndNew()
    {
     
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
            $datas = DB::select("SELECT min(b.title) AS TITLE, 
count(b.title) AS QTY,
count(ibr.id) as Request,
MIN(b.category) AS CATEGORY ,
b.id AS MBID,
sum(sb.borrowed) AS BORROWED,
COUNT(sb.sub_book_id) AS TBOOKS,
MIN(cover_img) as CIMG ,
MIN(sb.active) as ACTIVE,CONCAT('New Arrival') as Frm
FROM books b 
JOIN sub_books sb ON b.id = sb.book_id 
left Join issue_book_reqs ibr on ibr.sub_book_id = sb.sub_book_id
where sb.active=1 GROUP BY b.category,b.id,sb.book_id Order by b.id desc LIMIT 20");
                
            $datas = array_map(function ($tmp) {
                $tmp = (array)$tmp;
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
               
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));

            return $datas;

        }

    }
    public function getBooksDetailsForFrontEndPersonalPreff()
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        $data= DB::select("Select b.id as cat_id,meta_value as cat_name, count(meta_value) 
as Amount, meta_key
from User_DataMetas as A JOIN dewey_decimals as B on A.meta_value = B.cat_name
where meta_key 
in ('VisitCategories') 
and user_id = $id 
group by meta_value 
order by amount 
desc limit 10");

        foreach($data as $prefe){
            array_push($pref,$prefe->cat_id);
        }
        
        $final = empty($data) ? "" : "and b.category in ('".implode("','", $pref)."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,count(ibr.id) as Request,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE
                FROM books b JOIN sub_books sb ON b.id = sb.book_id left Join issue_book_reqs ibr on ibr.sub_book_id = sb.sub_book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id order by rand()  LIMIT 60");

                
            $datas = array_map(function ($tmp) {
            
                $tmp = (array)$tmp;
                $tmp["From"] = "New Arrival";
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }


    public function getBooksDetailsForFrontEndPreffTrendCateg()
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        $data= DB::select("Select b.id as cat_id,meta_value as cat_name, count(meta_value) 
as Amount, meta_key
from User_DataMetas as A JOIN dewey_decimals as B on A.meta_value = B.cat_name
where meta_key 
in ('VisitCategories') 
group by meta_value 
order by amount 
desc limit 5");

        foreach($data as $prefe){
            array_push($pref,$prefe->cat_id);
        }
        
        $final = empty($data) ? "" : "and b.category in ('".implode("','", $pref)."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE,CONCAT('Featured') as Frm 
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id  LIMIT 5");

                
            $datas = array_map(function ($tmp) {
           
                $tmp = (array)$tmp;
                
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }public function getBooksDetailsForFrontEndPreffTrendCategYearly()
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        $year = date("Y");
        $data= DB::select("Select b.id as cat_id,meta_value as cat_name, count(meta_value) 
as Amount, meta_key
from User_DataMetas as A JOIN dewey_decimals as B on A.meta_value = B.cat_name
where meta_key 
in ('VisitCategories') AND
YEAR(a.created_at) = $year
group by meta_value 
order by amount 
desc limit 5 ");

        foreach($data as $prefe){
            array_push($pref,$prefe->cat_id);
        }
        
        $final = empty($data) ? "" : "and b.category in ('".implode("','", $pref)."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE,CONCAT('Featured') as Frm 
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id  LIMIT 5");

                
            $datas = array_map(function ($tmp) {
           
                $tmp = (array)$tmp;
                
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }public function getBooksDetailsForFrontEndPreffTrendCategMonthly()
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        $year = date("Y");
        $data= DB::select("Select b.id as cat_id,meta_value as cat_name, count(meta_value) 
as Amount, meta_key
from User_DataMetas as A JOIN dewey_decimals as B on A.meta_value = B.cat_name
where meta_key 
in ('VisitCategories') AND
YEAR(a.created_at) = $year AND
MONTH(a.created_at) = MONTH(CURRENT_DATE())
group by meta_value 
order by amount 
desc limit 5 ");

        foreach($data as $prefe){
            array_push($pref,$prefe->cat_id);
        }
        
        $final = empty($data) ? "" : "and b.category in ('".implode("','", $pref)."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE,CONCAT('Featured') as Frm 
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id  LIMIT 5");

                
            $datas = array_map(function ($tmp) {
           
                $tmp = (array)$tmp;
                
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }public function getBooksDetailsForFrontEndPreff()
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        $data= DB::select("Select b.id as cat_id,meta_value as cat_name, count(meta_value) 
as Amount, meta_key
from User_DataMetas as A JOIN dewey_decimals as B on A.meta_value = B.cat_name
where meta_key 
in ('VisitCategories') 
group by meta_value 
order by amount 
desc limit 5");

        foreach($data as $prefe){
            array_push($pref,$prefe->cat_id);
        }
        
        $final = empty($data) ? "" : "and b.category in ('".implode("','", $pref)."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE,CONCAT('Featured') as Frm 
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id  LIMIT 10");

                
            $datas = array_map(function ($tmp) {
           
                $tmp = (array)$tmp;
                
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }



    public function getBooksDetailsForFrontEndPreffSoloCateg($cat_id)
    {
    
        if (Cache::has("temp_front")) {
            return Cache::get("temp_front");
        } else {
        $pref = [];
        $id = Auth::id();
        
        $final = empty($cat_id) ? "" : "and b.category in ('".$cat_id."')";
        
            $datas = DB::select("SELECT min(b.title) AS TITLE, count(b.title) AS QTY, MIN(b.category) AS CATEGORY ,b.id AS MBID,
                sum(sb.borrowed) AS BORROWED,COUNT(sb.sub_book_id) AS TBOOKS,  MIN(cover_img) as CIMG , MIN(sb.active) as ACTIVE,CONCAT('Featured') as Frm 
                FROM books b JOIN sub_books sb ON b.id = sb.book_id where sb.active=1 $final GROUP BY b.category,b.id,sb.book_id order by Rand() LIMIT 12 ");
             
               if(count($datas) <=4 ){
               return "";
               }

            $datas = array_map(function ($tmp) {
           
                $tmp = (array)$tmp;
                
                $check = DeweyDecimal::find($tmp["CATEGORY"]);
                if ($check) {
                    $tmp["PARENT_CAT"] = $check->parent;
                   
                    $tmp["SHELF_NO"] = $check->shelf_no;
                }
                
                $tmp["AUTHOR"] = BookAuthor::where("book_id", $tmp["MBID"])->pluck("author_id")->toArray();
                $tmp["PUBLISHER"] = BookPublisher::where("book_id", $tmp["MBID"])->pluck("publisher_id")->toArray();
                $tmp["TAG"] = BookTag::where("book_id", $tmp["MBID"])->pluck("tag_id")->toArray();
                $tmp["MEDTYPE"] = BookMedtype::where("book_id", $tmp["MBID"])->pluck("medtype_id")->toArray();
                return $tmp;
            }, $datas);
            //return Cache::put("temp_front", $tmp, now()->addMinutes(10));
            return $datas;

        }

    }
    /**
     * Check for the role linkage for the supplied user id and return boolean value if the role exists.
     * @param $role_name string Should be a role name
     * @param null $user_id User id to check for . If not passed the default logged in user id will be taken
     * @return bool Returns true if it found that the user has the particular role that was been given
     */
    public function checkIfUserHasRole($role_name, $user_id = null)
    {
        //$user_obj = User::find(Auth::id());
//        if ($user_obj) {
//            $user_obj = User::find($user_id);
//        }
//        if ($user_obj && in_array($role_name, $user_obj->roles)) {
//            return true;
//        }
//        return false;
        if ($user_id) {
            return User::check_if_user_has_role($role_name);
        } else {
            return User::check_if_give_user_has_role($user_id, $role_name);
        }
    }


    /**
     * Return the nos of book limit for the user id.
     * @param $uid int User id
     * @return int|mixed|null
     */
    public function getLimitOfBookAssigned($uid)
    {
        if (User::check_if_give_user_has_role($uid, "student")) {
            return intval($this->getSiteSettings("student_book_limit", 1));
        }
        if (User::check_if_give_user_has_role($uid, "teacher")) {
            return intval($this->getSiteSettings("teacher_book_limit", 1));
        }else{
        return intval($this->getSiteSettings("teacher_book_limit", 1));
        }
        return 0;
    }

    /**
     * Return No of books that the given user id has borrowed currently.
     * @param $uid int user id
     * @return int return no of book that her has currently borrowed.
     */
    public function getNoOfBooksBorrowedCurrently($uid)
    {
        $user_obj = User::find($uid);
        if ($user_obj) {
            return Borrowed::where("user_id", $uid)->whereNull("date_returned")->count();
        }
        return 0;
    }

    /**
     * Return No of books that the given user id has borrowed till now.
     * @param $uid int user id
     * @return int return no of book that he has borrowed till now from the system.
     */
    public function getNoOfBooksBorrowedTillNow($uid)
    {
        $user_obj = User::find($uid);
        if ($user_obj) {
            return Borrowed::where("user_id", $uid)->count();
        }
        return 0;
    }

    /**
     * Return default language
     * @return string
     */
    public function getDefaultLang()
    {
        return $this->getSiteSettings("default_lang", "en");
    }

    /**
     * Returns a list of default roles
     * @param $ids bool if true is passed it returns the list of default id related to the roles
     * @return string[]
     */
    public function getListOfDefaultRoles($ids = false)
    {
        if ($ids) {
            return Role::whereIn("name", $this->default_roles)->pluck("id")->toArray();
        } else {
            return $this->default_roles;
        }
    }

    /**
     * Return a list of default permissions.
     * @param $ids bool if true is passed it returns the list of default id related to the permissions
     * @return string[]
     */
    public function getListOfDefaultPermissions($ids = false)
    {
        if ($ids) {
            return Permission::whereIn("name", $this->default_permissions)->pluck("id")->toArray();
        } else {
            return $this->default_permissions;
        }
    }

    public function getWeeklyBorrowedStats()
    {
        $datas = DB::select(DB::raw("SELECT COUNT(b.date_borrowed) AS Borrowed,
        MIN(b.date_borrowed) AS DBorrowed
        FROM borroweds b  GROUP BY DATE(b.date_borrowed) having DBorrowed > DATE_SUB(CURDATE(), INTERVAL 4 WEEK);"));
        $datas = array_map(function ($tmp) {
            return (array)$tmp;
        }, $datas);
        return $datas;
    }

    public function getWeeklyReturnedStats()
    {
        $datas = DB::select(DB::raw("SELECT COUNT(b.date_returned) AS Returned,
        MIN(b.date_returned) AS DReturned
        FROM borroweds b  GROUP BY DATE(b.date_returned) having DReturned > DATE_SUB(CURDATE(), INTERVAL 4 WEEK);"));
        $datas = array_map(function ($tmp) {
            return (array)$tmp;
        }, $datas);
        return $datas;
    }

    public function getMonthBorrowedStats()
    {
        $datas = DB::select(DB::raw("SELECT MONTH(b.date_borrowed) AS Closing_Month, COUNT(b.date_borrowed) AS Borrowed,
        MIN(b.date_borrowed) AS DBorrowed
        FROM borroweds b  GROUP BY MONTH(b.date_borrowed)"));
        $datas = array_map(function ($tmp) {
            return (array)$tmp;
        }, $datas);
        return $datas;
    }

    public function getMonthlyReturnedStats()
    {
        $datas = DB::select(DB::raw("SELECT MONTH(b.date_returned) AS Closing_Month, COUNT(b.date_returned) AS Returned,
        MIN(b.date_returned) AS DReturned
        FROM borroweds b  GROUP BY MONTH(b.date_returned)"));
        $datas = array_map(function ($tmp) {
            return (array)$tmp;
        }, $datas);
        return $datas;
    }

    /**
     * Format dewey numbering
     * @param $number
     * @return string
     */
    public function formatDeweyNo($number)
    {
        return sprintf("%08.4f", $number);;
    }

    /**
     * Format sheft numbering
     * @param $number
     * @return string
     */
    public function formatShelfNo($number)
    {
        return sprintf("%02d", $number);
    }

    /**
     * Check if the book is in the request pool
     * @param $sub_book_id string
     * @param $user_id int
     * @return bool Return true if it's in request pool
     */
    public function checkIfInBorrowed($sub_book_id, $user_id)
    {
        if (Borrowed::where("sub_book_id", $sub_book_id)->whereNull('date_returned')->exists()) {
            return true;
        }
        return false;
    }public function checkIfInBorrowedRequest($sub_book_id, $user_id)
    {
        if (IssueBookReq::where("user_id", $user_id)->where("sub_book_id", $sub_book_id)->exists()) {
            return true;
        }
        return false;
    }
    public function checkIfInBorrowedRequestsolo($sub_book_id)
    {
        if (IssueBookReq::where("sub_book_id", $sub_book_id)->exists()) {
            return true;
        }
        return false;
    }
    public function checkIfInBorrowedRequestsoloData($sub_book_id)
    {
       $data = IssueBookReq::where("sub_book_id", $sub_book_id)->pluck("expectedborrow")->toArray();

        return json_encode($data);
    }public function checkIfInBorrowedRequestsoloDataBookID($sub_book_id)
    {
       $data = IssueBookReq::where("book_id", $sub_book_id)->pluck("expectedborrow")->toArray();

        return json_encode($data);
    }public function checkIfInBorrowedsoloData($sub_book_id)
    {
       $data = Borrowed::where("sub_book_id", $sub_book_id)->whereNull("date_returned")->pluck("date_borrowed")->toArray();
       

        return json_encode($data);
    }
    public function checkIfInBorrowedRequestAllData($book_id)
    {
       $data = IssueBookReq::where("book_id", book_id)->pluck("expectedborrow")->toArray();

        return json_encode($data);
    }

    public function checkIfInBorrowedRequestsolousingid($sub_book_id)
    {
        if (IssueBookReq::where("book_id", $sub_book_id)->exists()) {
            return true;
        }
        return false;
    }
    public function checkIfInBorrowedRequestsoloDatausingid($sub_book_id)
    {
       $data = IssueBookReq::where("book_id", $sub_book_id)->pluck("expectedborrow")->toArray();

        return json_encode($data);
    }

   

    /* To tackle utf-8 strings */
    function utf8Slug($string) {
        return preg_replace('/\s+/u', '-', trim($string));
    }

    /**
     * getting CSV array with UTF-8 encoding
     *
     * @param resource    &$handle
     * @param integer $length
     * @param string $separator
     *
     * @return  array|false
     */
    public function fgetcsvUTF8(&$handle, $separator = ',')
    {
        if (($buffer = fgets($handle)) !== false) {
            $buffer = UTF8::cleanup($buffer);
            return str_getcsv($buffer, $separator);
        }
        return false;
    }

}



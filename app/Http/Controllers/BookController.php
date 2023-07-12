<?php

namespace App\Http\Controllers;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\Book;
use App\Models\SubBook;
use App\Models\Newsfeed;
use http\Encoding\Stream\Enbrotli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use voku\helper\UTF8;

class BookController extends Controller
{
    //
    public $bk_file_header = array("UNIQUEID", "ISBN10", "ISBN13", "TITLE", "SBID", "PRICE", "ACTIVE");

    public function __construct()
    {
        $this->middleware('auth');
        $this->bk_file_header = array_map(function ($item) {
            return UTF8::cleanup($item);
        }, $this->bk_file_header);
    }

    public function index()
    {
        $book_title = "Harry Potter";
$book_data = $this->get_wikipedia_data($book_title);
dd( $book_data);
        return view("back.book.index");
    }

    public function edit($id)
    {
        return view("back.book.index", compact("id"));
    }
public function get_wikipedia_data($book_title) {
        $url = "https://en.wikipedia.org/w/api.php";

        $params = array(
            "action" => "query",
            "format" => "json",
            "prop" => "info|categories|links|images|langlinks|coordinates|extlinks|extracts|pageimages",
            "exintro" => "",
            "explaintext" => "",
            "titles" => $book_title
        );

        try {
            $ch = curl_init($url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            $pages = $data["query"]["pages"];
            $article = reset($pages);  // Get the first (and only) article
            return $article;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function importBooks(Request $request)
    {

        if (!$request->has("file")) {
            Session::flash("alert-warning", __("common.no_file_selected"));
            return \redirect()->back();
        }
        $extension = File::extension($request->file->getClientOriginalName());
        if ($extension != "csv") {
            Session::flash("alert-danger", __("common.only_csv"));
            return redirect()->back();
        }
        \Artisan::call("backup:run"); // Creates a backup
        $new_filename = Util::uploadFile($request->file('file'));
        //$new_filename = "rDo_template.csv";
        $file_loc = "uploads/" . $new_filename;
        $header = array();
        $file = fopen($file_loc, "r");
        //Getting all the header in the file into array to compare it with the system db columns
        while (($data = Common::fgetcsvUTF8($file)) !== FALSE) {
            //while (($data = fgetcsv($file)) !== FALSE) {
            // Lets read the header so as to get the column name
            for ($i = 0; $i < 60; $i++) {
                if (!empty($data[$i])) {
                    array_push($header, UTF8::cleanup($data[$i]));
                } else {
                    break;
                    // We now have the headers
                }
            }
            break;
        }
        if ($this->bk_file_header != $header) {
            Session::flash("alert-danger", __("common.colm_miss_match"));
            return \redirect()->back();
        }
        //fseek($file, 1, SEEK_CUR);
        $dm_status = false;
        while (($data = Common::fgetcsvUTF8($file)) !== FALSE) {
            //while (($data = fgetcsv($file)) !== FALSE) {
            try {
                $data = array_map("strval", $data);
            } catch (\Exception $e) {
            }
            //$data = array_map("utf8_encode", $data); //added
            $data = array_map("strval", $data);
            $unq_id = Util::getIfNotEmpty($data[0]) ?? Util::generateRandomString(5);
            $isbn_10 = str_replace("-", "", $data[1]);
            if (is_numeric($isbn_10)) {
                $isbn_10 = strval(intval($isbn_10));
            }
            $isbn_13 = str_replace("-", "", $data[2]);
            if (is_numeric($isbn_13)) {
                $isbn_13 = strval(intval($isbn_13));
            }
            $title = $data[3];
            $sb_id = $data[4];
            $sb_price = $data[5];
            $sb_active = $data[6];
            $temp = null;
            if ($isbn_10 || $isbn_13) {
                $temp = \App\Models\Book::where(function ($query) use ($isbn_10, $isbn_13) {
                    $query->where("isbn_10", $isbn_10)->orWhere("isbn_13", $isbn_13);
                })
                    ->where("unique_id", $unq_id)->first();
            }
            // one last change before we go and look for book details online
            if ($title) {
                $temp = Book::where("title", $title)->first();
            }
            if ($temp) {
                $tmp = SubBook::updateOrCreate(["sub_book_id" => Str::lower($sb_id), "book_id" => $temp->id, "price" => $sb_price, "active" => $sb_active ? $sb_active : '0']);
                if ($tmp) {
                    $dm_status = true;
                }
            } else {
                // New books has been found
                $found = false;
                $datas = null;


                if ($isbn_10) {
                    $datas = Util::curlPost("https://www.googleapis.com/books/v1/volumes?q=isbn:" .
                        $isbn_10, "", ["Content-Type:application/json"], "GET", false);
                    if (!empty($datas)) {
                        $datas = json_decode($datas, true);
                        if ($datas["totalItems"] == 1) {
                            $found = true;
                        }
                    }
                }
                if ($isbn_13 && !$found) {
                    $datas = Util::curlPost("https://www.googleapis.com/books/v1/volumes?q=isbn:" .
                        $isbn_13, "", ["Content-Type:application/json"], "GET", false);
                    if (!empty($datas)) {
                        $datas = json_decode($datas, true);
                        if ($datas["totalItems"] == 1) {
                            $found = true;
                        }
                    }
                }

                if (($isbn_13 || $isbn_10) && !$found) {
                    $datas = Util::curlPost("https://openlibrary.org/api/books?bibkeys=" .
                        Util::getIfNotEmpty($isbn_10) ?? $isbn_13 . "&format=json", "", ["Content-Type:application/json"], "GET", true);
                    $datas = json_decode($datas, true);
                    $datas = isset($datas[key(Util::getIfNotEmpty($datas) ?? [])]) ? $datas[key($datas)] : "";
                    if (isset($datas["info_url"])) {
                        $found = true;
                    }
                }
                $author_name = "";
                $unique_id = 'R-' . Util::generateRandomString(5);
                $publisher = "";
                $desc = "";
                $preview_url = "";
                $cover_img = "";
                if ($found && $datas) {
                    if (!empty($datas)) {
                        if (isset($datas["totalItems"]) && $datas["totalItems"] == 1) {
                            $book = Common::analyseBookDetails($datas);
                            $author_name = $book["author_name"];
                            $unique_id = $book["unique_id"];
                            $title = $book["title"];
                            $publisher = $book['publisher'];
                            $isbn_10 = $book['isbn_10'];
                            $isbn_13 = $book['isbn_13'];
                            $desc = $book["desc"];
                            try {
                                $cover_img = Util::saveFileFromUrl($book["cover_img"], ".jpg");
                            } catch (\Exception $e) {
                            }
                            $preview_url = $book["preview_url"];
                        }

                        if (isset($datas["info_url"])) {
                            $book = Common::analyseBookDetails($datas);
                            $title = Util::getIfNotEmpty($book["title"]) ?? "";
                            $isbn_10 = Util::getIfNotEmpty($book['isbn_10']) ?? "";
                            $isbn_13 = Util::getIfNotEmpty($book['isbn_13']) ?? "";
                            $cover_img = Util::getIfNotEmpty($book["cover_img"]) ?? "";
                            $preview_url = Util::getIfNotEmpty($book["preview_url"]) ?? "";
                        }
                    }
                }
                if ($title) {
                    $book_main_id = \App\Models\Book::updateOrCreate(["unique_id" => $unique_id],
                        ["unique_id" => $unique_id, "isbn_10" => $isbn_10, "isbn_13" => $isbn_13,
                            "title" => $title, "desc" => $desc, "author" => $author_name
                            , "publisher" => $publisher, "preview_url" => $preview_url,
                            "cover_img" => Util::isUrl($cover_img) ? Util::getFileNameFromUrl($cover_img) : $cover_img]);
                    if ($book_main_id) {
                        $dm_status = true;
                        if ($sb_id) {
                            $lst_id = \App\Models\SubBook::updateOrCreate(["sub_book_id" => $sb_id, "book_id" => $book_main_id->id],
                                ["sub_book_id" => Str::lower($sb_id),
                                    "price" => $sb_price, "active" => $sb_active
                                ]);
                        }
                    }
                }
            }
        }
        if ($dm_status) {
            Session::flash("alert-success", __("common.book_imported"));
        } else {
            Session::flash("alert-info", __("common.nothing_imported"));
        }
        return \redirect()->back();
    }

    public
    function exportBooks(Request $request)
    {
        //SELECT b.isbn_10,b.isbn_13,sb.sub_book_id FROM books b JOIN sub_books sb ON b.id=sb.book_id
        $headers = array(
            "Content-type" => "text/csv;charset=UTF-8",
            "Content-Disposition" => "attachment; filename=books_list.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $books = DB::select("SELECT b.unique_id as UNIQUEID, b.isbn_10 as ISBN10,b.isbn_13 as ISBN13,b.title as TITLE,sb.sub_book_id as SBID,
        sb.price as Price,sb.active as Active FROM books b JOIN sub_books sb ON b.id=sb.book_id");

        $callback = function () use ($books) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $this->bk_file_header);
            foreach ($books as $result) {
                $tmp = (array)$result;
                $tmp = array_map("strval", $tmp);
                fputcsv($file, $tmp);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}

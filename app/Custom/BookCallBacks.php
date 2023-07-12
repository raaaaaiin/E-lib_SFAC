<?php


namespace App\Custom;


class BookCallBacks
{
    public function __construct()
    {

    }

    /**
     * If you have some added custom data that you want to push into db then you can use the request() helper
     * to tamper the given collection before insert. This is the place if you want to add some code before the
     * main book is inserted into system.
     * @param $data_collected_for_insert
     * @return array
     */
    public function beforeMainBookSaved($data_collected_for_insert)
    {
        return array($data_collected_for_insert);
    }

    /**
     * Here you will be getting the main book id details  which you can use for your processing. PLus the sub books collection. which you can tamper with
     * before they are inserted into db
     * @param $main_book_id
     * @param $books_collections
     * @return array
     */
    public function afterMainBookSaved($main_book_id, $books_collections)
    {
        return array($main_book_id, $books_collections);
    }

    /**
     * Hook before the system deletes the main book
     * @param $book_id
     * @return array
     */
    public function beforeMainBookDelete($book_id)
    {
        return array($book_id);
    }
    public function afterMainBookDelete(){

    }

    /**
     * You can hooks into these codes to do any action that you wish before the actions are done
     */
    public function beforeSubBookDeleted()
    {

    }

    public function afterSubBookDeleted()
    {

    }

    /**
     * You can use this to tamper the code before its beign passed into db.
     * Note this is called after only all the validations are passed.
     * @param $sel_sb_id
     * @param $sel_mb_id
     * @param $sel_uid
     * @param $sel_issue_date
     * @param $sel_return_date
     * @return array
     */
    public function beforeBookIsIssued($sel_sb_id, $sel_mb_id, $sel_uid, $sel_issue_date, $sel_return_date)
    {
        return array($sel_sb_id, $sel_mb_id, $sel_uid, $sel_issue_date, $sel_return_date);
    }

    public function afterBookIsIssued()
    {

    }

    /**
     * Hook before a book is received by the system.
     * These gives you a borrowed obj so you could use this for you custom code if any ,
     * or you could write your own implementation and then die();
     * @param $borrowed_obj
     * @return array
     */
    public function beforeBookIsReceived($borrowed_obj)
    {

        return array($borrowed_obj);
    }

    public function afterBookIsReceived()
    {

    }

}

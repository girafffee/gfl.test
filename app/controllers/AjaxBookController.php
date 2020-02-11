<?php


namespace App\controllers;


use App\Base\BaseController;
use App\Lib\Mailer;
use App\models\Books;

class AjaxBookController extends BaseController
{

    public function ajaxOrder()
    {
        if(empty($_POST))
            return false;

        $data = $_POST['inp'];
        $book = $_POST['book'];
        $this->filterData($data);

        $table = new Books;

        $book = $table
            ->SelectWhat([
                'title'     =>'title',
                'desc_short' => 'desc_short',
            ])
            ->WhereEqually('id', $book)
            ->Get()
            ->fetch(\PDO::FETCH_ASSOC);

        $mail = new Mailer();
        $mail_info = [
            'subject'   => 'New order',
            'body'      => self::render('mail/book_order.php', [
                'book' => $book,
                'customer' => $data
            ]),
            'altBody'   => ''
        ];

        if($mail->sendEmailAdmin($mail_info))
            echo (int)TRUE;
    }

}
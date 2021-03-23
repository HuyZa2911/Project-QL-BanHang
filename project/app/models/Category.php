<?php
class Category extends Db
{
    //goi category
    public function getCategory()
    {
        $sql = parent::$connection->prepare('SELECT * FROM categories');
        return parent::select($sql);
    }
}

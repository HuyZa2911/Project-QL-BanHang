<?php
class ProductModel extends Db
{
    public function getProduct($perpage,$page)
    {
        $star = ($page - 1)*$perpage;
        $sql = parent::$connection->prepare("SELECT * FROM products LIMIT $star, $perpage");
        return parent::select($sql);
    }
    public function setProduct()
    {
        $sql = parent::$connection->prepare("SELECT * FROM products");
        return parent::select($sql);
    }
    //lay so luong sp
    public function getTotalRow()
    {
        $sql = parent::$connection->prepare("SELECT COUNT(product_id) FROM products ");
        return parent::select($sql)[0]['COUNT(product_id)'];
    }
     //Lấy sp theo ID
     public function getProductById($id)
     {
         $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_id=?');
         $sql->bind_param('i', $id);
         return parent::select($sql)[0];
     }
     //lấy thông tin các hãng xe
     public function getCompany()
     {
         $sql = parent::$connection->prepare("SELECT * FROM company");
         return parent::select($sql);
     }
     //tìm kiếm sp theo tên
     public function searchProduct($keyword)
    {
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare('SELECT * FROM products WHERE product_name LIKE ?');
        $sql->bind_param('s', $search);
        return parent::select($sql);
    }
       //lay so luong sp tìm kiếm
    public function getSeachTotalRow($keyword)
    {
        $search = "%{$keyword}%";
        $sql = parent::$connection->prepare('SELECT COUNT(product_id) FROM products WHERE product_name LIKE ?');
        $sql->bind_param('s', $search);
        return parent::select($sql)[0]['COUNT(product_id)'];
    }
    //Láy sp theo danh mục
    public function getProductByCategory($catId)
    {
        $sql = parent::$connection->prepare('SELECT *FROM products INNER JOIN products_category ON products.product_id = products_category.product_id WHERE products_category.category_id = ?');
        $sql->bind_param('i', $catId);
        return parent::select($sql);
    }
       //Lấy thông tin company theo ID Company
       public function getCompanyById($id)
       {
           $sql = parent::$connection->prepare('SELECT * FROM company WHERE company_id=?');
           $sql->bind_param('i', $id);
           return parent::select($sql)[0];
       }
    //    lấy Thông tin user
    public function getUser()
    {
       $sql = parent::$connection->prepare('SELECT * FROM user');
       return parent::select($sql);
    }
    // lấy thông tin theo username
    public function getUserByUserName($Username)
    {
        $sql = parent::$connection->prepare("SELECT * FROM user WHERE user_name = ?");
        $sql->bind_param('i', $Username);
        return parent::select($sql)[0];
    }
    // đăng kí tài khoản
    public function getSingup($user_name,$user_pass,$user_email,$user_rol)
    {
        $sql = parent::$connection->prepare("INSERT INTO `user` (`user_name`, `user_pass`, `user_email`, `user_rol`) VALUES (?,?,?,?)");
        $sql->bind_param('sssd',$user_name,$user_pass,$user_email,$user_rol);
        return $sql->execute();
    }
    //lấy Thông tin comment theo id
    public function getComment($id)
    {
        $sql = parent::$connection->prepare("SELECT *FROM comment INNER JOIN products ON comment.product_id =products.product_id WHERE products.product_id = ?");
        $sql->bind_param('i', $id);
        return parent::select($sql);
    }
    //Thêm comment
    public function addComment($product_id,$user_name,$comment_text,$comment_time)
    {
        $sql = parent::$connection->prepare("INSERT INTO `comment` (`product_id`, `user_name`, `comment_text`, `comment_time`) VALUES (?,?,?,?)");
        $sql->bind_param('dsss',$product_id,$user_name,$comment_text,$comment_time);
        return $sql->execute();
    }
    // update lượt xem
    public function updateView($id,$viewNew)
    {
        $sql = parent::$connection->prepare("UPDATE `products` SET `product_view` = ? WHERE `products`.`product_id` = $id");
        $sql->bind_param('d',$viewNew);
        return $sql->execute();
    
    }
    //them san pham
    public function addProduct($productName, $productPrice, $productDescription, $productImage,$productView)
    {
        $sql = parent::$connection->prepare('INSERT INTO `products` (`product_name`, `product_price`, `product_description`, `product_image`,`product_view`) VALUES (?, ?, ?, ?,?)');
        $sql->bind_param('sdssd', $productName, $productPrice, $productDescription, $productImage,$productView);
        return $sql->execute();
    }
    //update san pham
    public function updateProduct($productName, $productPrice, $productDescription, $productImage, $productId)
    {
        $sql = parent::$connection->prepare('UPDATE `products` SET `product_name` = ?, `product_price` = ?, `product_description` = ?, `product_image` = ? WHERE `products`.`product_id` = ?');
        $sql->bind_param('sdssi', $productName, $productPrice, $productDescription, $productImage, $productId);
        return $sql->execute();
    }
    //Xoa sp
    public function deleteProduct($productId)
    {
        $sql = parent::$connection->prepare('DELETE FROM `products` WHERE `products`.`product_id` = ?');
        $sql->bind_param('i', $productId);
        return $sql->execute();
    }
    //them thong tin san pham
    public function setCategory($productId,$categoryId)
    {
        $sql = parent::$connection->prepare('INSERT INTO `products_category` (`product_id`, `category_id`) VALUES (?, ?);');
        $sql->bind_param('ii', $productId,$categoryId);
        return $sql->execute();
    }
    public function getCategoryById($id)
     {
         $sql = parent::$connection->prepare('SELECT * FROM products_category WHERE product_id=?');
         $sql->bind_param('i', $id);
         return parent::select($sql)[0];
     }
     //update category
     public function updateCategory($p,$productId, $categoryId)
     {
         $sql = parent::$connection->prepare('UPDATE `products_category` SET `product_id` = ? WHERE `products_category`.`product_id` = ? AND `products_category`.`category_id` = ?');
         $sql->bind_param('iii',$p, $productId, $categoryId);
         return $sql->execute();
     }
     //delete category
     public function deleteCategory($productId)
     {
        $sql = parent::$connection->prepare('DELETE FROM `products_category` WHERE `products_category`.`product_id` = ?');
        $sql->bind_param('i', $productId);
        return $sql->execute();
     }
}

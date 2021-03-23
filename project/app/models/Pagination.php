<?php
class Pagination{
    public function creatPageLinlks($url,$totalRow, $perPage,$page)    
    {
       $disabled='';
       if($page ==1){ $disabled='disabled';}
       $lui=(int)$page-1;
        $output='<nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">';
         $output .= "<li class='page-item $disabled'>";
        $output .='<a class="page-link" href="';
        $output .="$url?page=$lui";
        $output .='" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>';
          
        for ($i=1;$i <= ceil($totalRow/$perPage) ;  $i++)   { 
            $active='';
            if($i==$page){
                $active='active';
            }
                $output .= "<li   class='page-item $active'><a class='page-link' href='$url?page=$i'> $i </a></li>";
            }
        $next='';
        if($page == ceil($totalRow/$perPage)){ $next='disabled'; }
        $output .="<li class='page-item $next'>";
        $output .='<a class="page-link" href="';
        $clicknext=(int)$page+1;
        $output .="$url?page=$clicknext";
        $output .='" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
            </a>
             </li>
            </ul>
            </nav>';
        return $output;
    }
}
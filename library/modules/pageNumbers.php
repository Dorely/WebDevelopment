<ul>
        <?php
        
        $total_pages = ceil($row_count / 50);
        $current_page = $page;
        $pageurl = '.?action=ChangePage&amp;searchtype='.implode(',', $searchtype).'&amp;search='.$searchstring.'&amp;colors='.implode(',', $colors).'&amp;colortype='.$colortype.'&amp;set_id='.$set_id.'&amp;searchbyset='.$searchbyset;
        //var_dump($row_count[0]);
        //var_dump($total_pages);
        if($current_page == 1){
            echo '<li>[First]&lt;&lt;</li>';
        }else{
            echo '<li><a href="'.$pageurl.'&amp;page=1">[First]&lt;&lt;</a></li>';
        }
        if ($current_page < 5 || $total_pages <= 10) {
            //if at the beginning or if 10 pages or less
            $first_page = 1;
            $last_page = 10;
            if($last_page > $total_pages){
                $last_page = $total_pages;
            }
            for ($count = $first_page; $count <= $last_page; $count++) {
                //echo 'beginning';
                //echo $count.'<br>';
                if($current_page == $count){
                    echo '<li>['.$count.']</li>';
                }else{
                    echo '<li><a href="'.$pageurl.'&amp;page='.$count.'">['.$count.']</a></li>';
                }
            }
        }elseif($current_page +5 >= $total_pages){
            //if at the end and greater than 10 pages
            $first_page = $current_page - 5;
            if($first_page < 1){
                $first_page = 1;
            }
            $last_page = $total_pages;
            for ($count = $first_page; $count <= $last_page; $count++) {
                //echo 'end';
                //echo $count.'<br>';
                if($current_page == $count){
                    echo '<li>['.$count.']</li>';
                }else{
                    echo '<li><a href="'.$pageurl.'&amp;page='.$count.'">['.$count.']</a></li>';
                }
               
            }
        }else{
            //if in the middle
            $first_page = $current_page - 5;
            if($first_page < 1){
                $first_page = 1;
            }
            $last_page = $current_page +5;
            if($last_page > $total_pages){
                $last_page = $total_pages;
            }
            for ($count = $first_page; $count < $last_page; $count++) {
                //echo 'middle';
                //echo $count.'<br>';
                if($current_page == $count){
                    echo '<li>['.$count.']</li>';
                }else{
                    echo '<li><a href="'.$pageurl.'&amp;page='.$count.'">['.$count.']</a></li>';
                }
            }
        }
        if($current_page == $total_pages){
            echo '<li>&gt;&gt;[Last]</li>';
        }else{
            echo '<li><a href="'.$pageurl.'&amp;page='.$total_pages.'">&gt;&gt;[Last]</a></li>';
        }
        

        //<li>[<?php echo $count;]</li>
        ?>        
    </ul>
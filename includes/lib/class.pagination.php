<?php

class Pagination {

    public $total_results;
    public $records_per_page;
    public $url;

    private $offset; 
    private $total_pages;
    private $boostrap_colum;
    private $current_page;

function __construct($total_results, $url, $boostrap_colum = 'col-md-12', $records_per_page = 10) {
    $this->total_results = $total_results;
    $this->records_per_page = $records_per_page;
    $this->boostrap_colum = $boostrap_colum;
    $this->url = $url;

    //get current page
    if (!empty($_GET['p']) && is_numeric($_GET['p'])) {
        $this->current_page = $_GET['p'];
    } 
    else {
        $this->current_page = 1;
    }

    //set private vars
    $this->offset = ($this->current_page-1) * $this->records_per_page;
    $this->total_pages = ceil($this->total_results / $this->records_per_page);
}

function get_page() {
    return $this->current_page;
}

function get_offset() {
    return $this->offset;
}

function get_records_per_page() {
    return $this->records_per_page;
}

function print() {
    echo '<!-- Pagination Container -->';
    echo '<div class="row fs-listings">';
        echo '<div class="'.$this->boostrap_colum.'">';

            echo '<!-- Pagination -->';
            echo '<div class="clearfix"></div>';
            echo '<div class="pagination-container margin-top-10 margin-bottom-45">';
                echo '<nav class="pagination">';
                    echo '<ul>';

                            if($this->total_pages > 1 ) {
                                
                                //First page
                                if($this->current_page != 1) {
                                    echo "<li><a href=\"?p=1&{$this->url}\">1</a></li>\n";
                                }

                                //Place holder
                                //We don't show it in the first 3 pages
                                if($this->current_page != 1 && $this->current_page != 2 && $this->current_page != 3) {
                                    echo "<li class=\"blank\">...</li>\n";
                                }

                                //Backward pages
                                if( ($this->current_page-2)>=2 ) {
                                    echo "<li><a href=\"?p=".($this->current_page-2)."&{$this->url}\">".($this->current_page-2)."</a></li>\n";
                                }
                                if( ($this->current_page-1)>1 ) {
                                    echo "<li><a href=\"?p=".($this->current_page-1)."&{$this->url}\">".($this->current_page-1)."</a></li>\n";
                                }

                                //Show current page
                                echo "<li class=\"blank\">".($this->current_page)."</li>\n";                             

                                //Foward pages
                                if( ($this->current_page+1)<$this->total_pages ) {
                                    echo "<li><a href=\"?p=".($this->current_page+1)."&{$this->url}\">".($this->current_page+1)."</a></li>\n";
                                }
                                if( ($this->current_page+2)<$this->total_pages ) {
                                    echo "<li><a href=\"?p=".($this->current_page+2)."&{$this->url}\">".($this->current_page+2)."</a></li>\n";
                                }

                                //Place holder
                                //We don't show it is its the last 3 pages
                                if($this->current_page != $this->total_pages && $this->current_page != ($this->total_pages-1) && $this->current_page != ($this->total_pages-2)) {
                                    echo "<li class=\"blank\">...</li>\n";
                                }
                                
                                //Last page
                                if($this->current_page != $this->total_pages) {
                                    echo "<li><a href=\"?p=".($this->total_pages)."&{$this->url}\">".($this->total_pages)."</a></li>\n";
                                }
                                
                            }

                    echo '</ul>';
                echo '</nav>';

                echo '<nav class="pagination-next-prev">';
                    echo '<ul>';
                        
                            if($this->current_page > 1) {
                                echo '<li><a href="?p='.($this->current_page-1).'&'.$this->url.'" class="prev">Previous</a></li>';
                            }
                            
                            if($this->current_page < $this->total_pages) {
                                echo '<li><a href="?p='.($this->current_page+1).'&'.$this->url.'" class="next">Next</a></li>';
                            }
                        
                    echo '</ul>';
                echo '</nav>';
            echo '</div>';

        echo '</div>';
    echo '</div>';
    echo '<!-- Pagination Container / End -->';
}

}
?>
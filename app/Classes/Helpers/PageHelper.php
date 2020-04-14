<?php

namespace App\Classes;

class PageHelper
{

    /**
     * set the number of items per page.
     *
     * @var numeric
     */
    private $_perPage;

    /**
     * set get parameter for fetching the page number
     *
     * @var string
     */
    private $_instance;

    /**
     * sets the page number.
     *
     * @var numeric
     */
    private $_page;

    /**
     * set the limit for the data source
     *
     * @var string
     */
    private $_limit;

    /**
     * set the total number of records/items.
     *
     * @var numeric
     */
    private $_totalRows = 0;


    /**
     *  __construct
     *
     *  pass values when class is istantiated
     *
     * @param numeric $_perPage sets the number of iteems per page
     * @param numeric $_instance sets the instance for the GET parameter
     */
    public function __construct($perPage, $instance)
    {
        $this->_instance = $instance;
        $this->_perPage = $perPage;
        $this->set_instance();
    }

    /**
     * get_start
     *
     * creates the starting point for limiting the dataset
     * @return numeric
     */
    public function get_start()
    {
        return ($this->_page * $this->_perPage) - $this->_perPage;
    }
    public function get_start_end_record()
    {
        $start = (($this->_page * $this->_perPage) - $this->_perPage) + 1;
        $end = ( ($this->_page + 1) * $this->_perPage ) - $this->_perPage;
        if($this->_totalRows < $end){
            $end = $this->_totalRows;
        }
        return $start.' to '.$end;
    }

    /**
     * set_instance
     *
     * sets the instance parameter, if numeric value is 0 then set to 1
     *
     * @var numeric
     */
    private function set_instance()
    {
        $this->_page = (int)(!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]);
        $this->_page = ($this->_page == 0 ? 1 : $this->_page);
    }

    /**
     * set_total
     *
     * collect a numberic value and assigns it to the totalRows
     *
     * @var numeric
     */
    public function set_total($_totalRows)
    {
        $this->_totalRows = $_totalRows;
    }

    /**
     * get_limit
     *
     * returns the limit for the data source, calling the get_start method and passing in the number of items perp page
     *
     * @return string
     */
    public function get_limit()
    {
        return "LIMIT " . $this->get_start() . ",$this->_perPage";
    }

    /**
     * page_links
     *
     * create the html links for navigating through the dataset
     *
     * @var sting $path optionally set the path for the link
     * @var sting $ext optionally pass in extra parameters to the GET
     * @return string returns the html menu
     */
    public function page_links($path = '?', $ext = null)
    {
        $adjacents = "2";
        $prev = $this->_page - 1;
        $next = $this->_page + 1;
        $lastpage = ceil($this->_totalRows / $this->_perPage);
        $lpm1 = $lastpage - 1;
        $pagination ="";

        if ($lastpage > 1) {
            $pagination .= "<nav class='mt-5 mb-4'><ul class='data-pagination justify-content-center flex-wrap'>

				<li><a aria-label='Next' href='" . $path . "$this->_instance=1" . "$ext'><span aria-hidden='true'>First</span>
                                <span class='sr-only'>First</span></a></li>";

            if ($this->_page > 1)
                $pagination .= "<li><a aria-label='Previous' href='" . $path . "$this->_instance=$prev" . "$ext'><span aria-hidden='true'>«</span><span class='sr-only'>Previous</span></a></li>";
            else
                $pagination .= "<li class='disabled'><a href='javascript:void(0);' aria-label='Previous'><span aria-hidden='true'>«</span><span class='sr-only'>Previous</span></a></li>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $this->_page)
                        $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a  href='" . $path . "$this->_instance=$counter" . "$ext'>$counter</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($this->_page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $this->_page)
                            $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                        else
                            $pagination .= "<li><a  href='" . $path . "$this->_instance=$counter" . "$ext'>$counter</a></li>";
                    }
                    $pagination .= '<li><a href="javascript:void(0);">...</a></li>';
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=$lpm1" . "$ext'>$lpm1</a></li>";
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=$lastpage" . "$ext'>$lastpage</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2)) {
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=1" . "$ext'>1</a></li>";
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=2" . "$ext'>2</a></li>";
                    $pagination .= '<li><a href="javascript:void(0);">...</a></li>';
                    for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++) {
                        if ($counter == $this->_page)
                            $pagination .= "<span class='active'>$counter</span>";
                        else
                            $pagination .= "<li><a  href='" . $path . "$this->_instance=$counter" . "$ext'>$counter</a></li>";
                    }
                    $pagination .= '<li><a href="javascript:void(0);">...</a></li>';
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=$lpm1" . "$ext'>$lpm1</a></li>";
                    $pagination .= "<li><a  href='" . $path . "$this->_instance=$lastpage" . "$ext'>$lastpage</a></li>";
                } else {
                    $pagination .= "<li><a href='" . $path . "$this->_instance=1" . "$ext'>1</a></li>";
                    $pagination .= "<li><a href='" . $path . "$this->_instance=2" . "$ext'>2</a></li>";
                    $pagination .= '<li><a href="javascript:void(0);">..</a></li>';
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $this->_page)
                            $pagination .= "<span class='active'>$counter</span>";
                        else
                            $pagination .= "<li><a  href='" . $path . "$this->_instance=$counter" . "$ext'>$counter</a></li>";
                    }
                }
            }

            if ($this->_page < $counter - 1)
                $pagination .= "<li><a aria-label='Next' href='" . $path . "$this->_instance=$next" . "$ext'><span aria-hidden='true'>»</span>
                                <span class='sr-only'>Next</span></a></li>";
            else
                $pagination .= "<li class='disabled'><a href='javascript:void(0);' aria-label='Next'><span aria-hidden='true'>»</span>
                                <span class='sr-only'>Next</span></a></li>";


            $pagination .= "<li><a aria-label='Next' href='" . $path . "$this->_instance=$lastpage" . "$ext'><span aria-hidden='true'>Last</span>
                                <span class='sr-only'>Next</span></a></li>
								</ul></nav>\n";
        }
        return $pagination;
    }
}



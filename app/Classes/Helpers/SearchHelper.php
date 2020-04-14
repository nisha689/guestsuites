<?php
namespace App\Classes\Helpers;

class SearchHelper{
    
	public $_page = -1;
    public $_perPage = -1;
    public $_selectColumns = ['*'];
    public $_filter = [];
    public $_sortOrder = [];
    public $_groupBy = [];

	public function __construct($page = -1, $perPage = -1, $selectColumns = ['*'], $filter = [],$sortOrder = [], $groupBy = []){
		$this->_page = $page;
		$this->_perPage = $perPage;
		$this->_selectColumns = $selectColumns;
		$this->_filter = $filter;
        $this->_sortOrder = $sortOrder;
        $this->_groupBy = $groupBy;
	}
}
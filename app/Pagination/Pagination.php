<?php 

namespace App\Pagination;

use Landish\Pagination\Pagination as BasePagination;

class Pagination extends BasePagination 
{
	/**
     * Pagination wrapper HTML.
     *
     * @var string
     */
    protected $paginationWrapper = '<div class="pagination-extended-css-class">%s %s %s</div>';

}
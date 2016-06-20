<?php 

namespace App\Pagination;

use Landish\Pagination\Simple\Pagination as BasePagination;

class SimplePagination extends BasePagination 
{
    /**
     * Pagination wrapper HTML.
     *
     * @var string
     */
    protected $paginationWrapper = '<ul class="my-pagination">%s %s %s</ul>';

    /**
     * Available page wrapper HTML.
     *
     * @var string
     */
    protected $availablePageWrapper = '<li><a href="%s">%s</a></li>';

    /**
     * Get active page wrapper HTML.
     *
     * @var string
     */
    protected $activePageWrapper = '<li class="active"><span>%s</span></li>';

    /**
     * Get disabled page wrapper HTML.
     *
     * @var string
     */
    protected $disabledPageWrapper = '<li class="disabled"><span>%s</span></li>';

    /**
     * Previous button text.
     *
     * @var string
     */
    protected $previousButtonText = '前の20件を表示';

    /**
     * Next button text.
     *
     * @var string
     */
    protected $nextButtonText = '次の20件を表示';

    /***
     * "Dots" text.
     *
     * @var string
     */
    protected $dotsText = '...';

}


// using in view
// {!! (new App\Pagination\SimplePagination($items))->render() !!}
//{!! $items->appends(['key' => 'value'])->render(new App\Pagination\SimplePagination($items))  !!}
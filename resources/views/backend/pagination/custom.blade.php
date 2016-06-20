<div class="my_pagination">
	{{ with(new App\Pagination\CustomPresenter($paginator))->appends(['sort' => 'votes'])->render() }}
</div>
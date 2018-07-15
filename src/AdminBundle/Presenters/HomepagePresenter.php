<?php declare(strict_types = 1);

namespace Thunbolt\Administration\AdminBundle\Presenters;

use Thunbolt\Administration\AdminPresenter;
use Ublaboo\DataGrid\DataGrid;

class HomepagePresenter extends AdminPresenter {

	public function formatLayoutTemplateFiles(): array {
		$list = parent::formatLayoutTemplateFiles();
		$list[] = __DIR__ . '/../templates/@layout.latte';

		return $list;
	}

	protected function createComponentTestGrid() {
		$grid = new DataGrid();

		$grid->setDataSource([
			['id' => 1, 'name' => 'Foo 1', 'desc' => 'Bar 1'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
			['id' => 2, 'name' => 'Foo 2', 'desc' => 'Bar 2'],
		]);

		$grid->addColumnText('name', 'Foo')
			->setSortable()
			->setFilterText();
		$grid->addColumnText('desc', 'Bar');
		$grid->addActionCallback('delete', 'Delete', function () {
			bdump('xxx');
		});

		return $grid;
	}

	public function renderDefault(): void {
		$template = $this->getTemplate();

		$template->setFile($parentFile = __DIR__ . '/templates/Homepage/default.latte');
		$template->parentFile = $parentFile;
	}

}

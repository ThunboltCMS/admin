<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Menu;

use Nette\Application\UI\Control;

class MenuComponent extends Control {

	/** @var Menu[] */
	private $items;

	public function addItem(Menu $menu) {
		$this->items[] = $menu;

		return $this;
	}

	public function render(): void {
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/menu.latte');

		$template->items = $this->items;

		$template->render();
	}

}

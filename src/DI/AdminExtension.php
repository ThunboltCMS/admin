<?php declare(strict_types = 1);

namespace Thunbolt\Administration\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\Utils\Validators;
use Thunbolt\Administration\Components\Menu\Menu;
use Thunbolt\Administration\Components\Menu\MenuChild;
use Thunbolt\Administration\Components\Menu\MenuComponent;
use Thunbolt\Administration\Routers\AdminRouter;
use Thunbolt\Application\PresenterMapping;

class AdminExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'router' => true,
		'menu' => [],
	];

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		if ($config['router']) {
			$builder->addDefinition($this->prefix('router'))
				->setType(AdminRouter::class)
				->addTag('router');
		}

		$builder->addDefinition($this->prefix('menu'))
			->setType(MenuComponent::class);

		if ($config['menu']) {
			$this->createMenu($config['menu']);
		}
	}

	private function createChildren(array $items): array {
		$children = [];
		foreach ($items as $item) {
			$args = [];
			Validators::assertField($item, 'name', 'string');
			Validators::assertField($item, 'url');

			$args[] = $item['name'];
			$args[] = (array) $item['url'];
			$args[] = $item['allows'] ?? null;
			$args[] = $this->createChildren($item['children'] ?? []);

			$children[] = new Statement(MenuChild::class, $args);
		}

		return $children;
	}

	private function createMenu(array $menu): void {
		$builder = $this->getContainerBuilder();

		$setup = [];
		foreach ($menu as $item) {
			$args = [];
			Validators::assertField($item, 'name', 'string');
			Validators::assertField($item, 'url');

			$args[] = $item['name'];
			$args[] = (array) $item['url'];
			$args[] = $item['icon'] ?? null;
			$args[] = $item['color'] ?? null;
			$args[] = $item['allows'] ?? null;
			$args[] = $this->createChildren($item['children'] ?? []);

			$setup[] = new Statement('addItem', [new Statement(Menu::class, $args)]);
		}

		$builder->getDefinition($this->prefix('menu'))
			->setSetup($setup);
	}

	public function beforeCompile() {
		$builder = $this->getContainerBuilder();

		$builder->getDefinition('application.presenterFactory')
			->addSetup('addMapping', ['Admin', new PresenterMapping('Admin')])
			->addSetup('addMapping', ['Admin', new PresenterMapping('Admin', 'Thunbolt\\Administration')]);
	}

}

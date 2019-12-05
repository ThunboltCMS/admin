<?php declare(strict_types = 1);

namespace Thunbolt\Administration\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Thunbolt\Administration\Components\Menu\Menu;
use Thunbolt\Administration\Components\Menu\MenuChild;
use Thunbolt\Administration\Components\Menu\MenuComponent;
use Thunbolt\Administration\Components\Navbar\NavbarOptionsFactory;
use Thunbolt\Application\PresenterMapping;

class AdminExtension extends CompilerExtension {

	public function getConfigSchema(): Schema {
		return Expect::structure([
			'menu' => Expect::arrayOf(Expect::structure([
				'name' => Expect::string()->required(),
				'icon' => Expect::string(),
				'url' => Expect::type('array|string'),
				'allows' => Expect::array(),
				'children' => Expect::arrayOf(Expect::structure([
					'name' => Expect::string()->required(),
					'icon' => Expect::string(),
					'url' => Expect::type('array|string'),
					'allows' => Expect::array(),
				]))
			])),
			'navbar' => Expect::string(NavbarOptionsFactory::class)
		]);
	}

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('menu'))
			->setType(MenuComponent::class);

		$builder->addDefinition($this->prefix('navbarOptionsFactory'))
			->setType(NavbarOptionsFactory::class);

		if ($config->menu) {
			$this->createMenu($config->menu);
		}
	}

	private function createChildren(array $items): array {
		$children = [];
		foreach ($items as $item) {
			$args = [];

			$args[] = $item->name;
			$args[] = (array) $item->url;
			$args[] = $item->allows ?? null;
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

			$args[] = $item->name;
			$args[] = (array) $item->url;
			$args[] = $item->icon;
			$args[] = null; // color
			$args[] = $item->allows;
			$args[] = $this->createChildren($item['children'] ?? []);

			$setup[] = new Statement('addItem', [new Statement(Menu::class, $args)]);
		}

		$builder->getDefinition($this->prefix('menu'))
			->setSetup($setup);
	}

	public function beforeCompile() {
		$builder = $this->getContainerBuilder();

		if (class_exists(PresenterMapping::class)) {
			$builder->getDefinition('application.presenterFactory')
				->addSetup('addMapping', ['Admin', new PresenterMapping('Admin')])
				->addSetup('addMapping', ['Admin', new PresenterMapping('Admin', 'Thunbolt\\Administration')]);
		}
	}

}

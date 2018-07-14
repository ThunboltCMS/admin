<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Routers;

use Nette\Application\Routers\Route;
use WebChemistry\Routing\IRouter;
use WebChemistry\Routing\RouteManager;

class AdminRouter implements IRouter {

	public function createRouter(RouteManager $manager): void {
		$admin = $manager->getModule('Admin');

		$admin[] = new Route('admin/<presenter>[/<action>][/<id [0-9]+>[-<name [0-9a-zA-Z\-]+>]]', [
			'presenter' => 'Homepage',
			'action' => 'default',
		]);
	}

}

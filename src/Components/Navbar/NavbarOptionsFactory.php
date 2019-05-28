<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Navbar;

final class NavbarOptionsFactory implements INavbarOptionsFactory {

	public function create(): NavbarOptions {
		$navbar = new NavbarOptions();
		$navbar->addLink(new NavbarLink('Odhlásit se', ['Sign:out'], 'exit'));

		return $navbar;
	}

}

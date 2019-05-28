<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Navbar;

interface INavbarOptionsFactory {

	public function create(): NavbarOptions;

}

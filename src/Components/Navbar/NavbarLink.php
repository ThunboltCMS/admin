<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Navbar;

class NavbarLink {

	/** @var string */
	public $name;

	/** @var array */
	public $link = [];

	/** @var string|null */
	public $icon;

	public function __construct(string $name, array $link, ?string $icon = null) {
		$this->name = $name;
		$this->link = $link;
		$this->icon = $icon;
	}

}

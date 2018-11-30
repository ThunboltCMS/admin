<?php declare(strict_types = 1);

namespace Thunbolt\Administration\Components\Menu;

use Nette\Security\User;

class MenuChild {

	/** @var string */
	private $name;

	/** @var array */
	private $url;

	/** @var MenuChild[] */
	private $children = [];

	/** @var array|null */
	private $allows;

	public function __construct(string $name, array $url, ?array $allows = null, array $children = []) {
		$this->name = $name;
		$this->url = $url;
		$this->allows = $allows;
		foreach ($children as $child) {
			$this->addChild($child);
		}
	}

	public function isAllowed(User $user): bool {
		if ($this->allows === null) {
			return true;
		}
		if (count($this->allows) === 1) {
			return $user->isAllowedResource($this->allows[0]);
		}

		return $user->isAllowed(...$this->allows);
	}

	/**
	 * @return array|null
	 */
	public function getAllows(): ?array {
		return $this->allows;
	}

	/**
	 * @param MenuChild $child
	 * @return static
	 */
	public function addChild(MenuChild $child) {
		$this->children[] = $child;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getUrl(): array {
		return $this->url;
	}

	/**
	 * @return MenuChild[]
	 */
	public function getChildren(): array {
		return $this->children;
	}

}

<?php

namespace Drupal\simplify_menu

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;

class SimplifyMenuServiceProvider extends ServiceProviderBase implements ServiceProviderInterface {

	public function alter(ContainerBuilder $container) {
		$definition = $container->getDefiniton('menu.default_tree_manipulators');
		$definition->setClass('Drupal\simplify_menu\MenuLock\MenuLockTreeManipulator');
		\Drupal::logger('Simp Menu Add')->warning('<pre><code>' . print_r($definition, TRUE) . '</code></pre>');

	}

}
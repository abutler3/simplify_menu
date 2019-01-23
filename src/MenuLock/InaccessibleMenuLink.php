<?php

namespace Drupal\Core\Menu;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Url;

/**
 * A menu link plugin for wrapping another menu link, in sensitive situations.
 *
 * @see \Drupal\Core\Menu\DefaultMenuLinkTreeManipulators::checkAccess()
 */
class InaccessibleMenuLink extends MenuLinkBase {

  /**
   * The wrapped menu link.
   *
   * @var \Drupal\Core\Menu\MenuLinkInterface
   */
  protected $wrappedLink;

  /**
   * Constructs a new InaccessibleMenuLink.
   *
   * @param \Drupal\Core\Menu\MenuLinkInterface $wrapped_link
   *   The menu link to wrap.
   */
  public function __construct(MenuLinkInterface $wrapped_link) {
    $this->wrappedLink = $wrapped_link;
    parent::__construct([], $this->wrappedLink->getPluginId(), $this->wrappedLink->getPluginDefinition());
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    \Drupal::logger('barista_patches')->debug('@type: deleted %title.',
      array(
          '@type' => "InaccessibleMenuLink: getTitle",
          '%title' => $this->pluginDefinition['title'],
      ));
    return $this->pluginDefinition['title'];
  }

  /**
   * {@inheritdoc}
   */
  public function getUrlObject($title_attribute = TRUE) {
    $options = $this->getOptions();

    // Add special classes.
    $options['attributes']['class'][] = 'fa';
    $options['attributes']['class'][] = 'fa-lock';
    \Drupal::logger('barista_patches')->debug('@type: deleted %title.',
      array(
          '@type' => "InaccessibleMenuLink: getUrlObject",
          '%title' => $options,
      ));
    if ($title_attribute && $description = $this->getDescription()) {
      $options['attributes']['title'] = $description;
    }
    if (empty($this->pluginDefinition['url'])) {
      return new Url($this->getRouteName(), $this->getRouteParameters(), $options);
    }
    else {
      return Url::fromUri($this->pluginDefinition['url'], $options);
    }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return $this->wrappedLink
      ->getCacheContexts();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return $this->wrappedLink
      ->getCacheTags();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return $this->wrappedLink
      ->getCacheMaxAge();
  }

  /**
   * {@inheritdoc}
   */
  public function updateLink(array $new_definition_values, $persist) {
    throw new PluginException('Inaccessible menu link plugins do not support updating');
  }

}
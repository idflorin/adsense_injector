<?php

namespace Drupal\adsense_injector\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Handles AdSense script injection using modern Drupal 11.3 architecture.
 */
class AdsenseHook {

  /**
   * Constructs the hook object.
   * * Drupal 11.3 automatically injects the current user service (autowiring).
   */
  public function __construct(
    protected AccountProxyInterface $currentUser,
  ) {}

  /**
   * Implements hook_page_attachments().
   */
  #[Hook('page_attachments')]
  public function onPageAttachments(array &$attachments): void {
    // CRITICAL: Always vary cache by role so admins don't see a cached page
    // with ads (and non-admins don't see a cached page without ads).
    $attachments['#cache']['contexts'][] = 'user.roles';

    // Attach the AdSense library for every role except administrator.
    if (!$this->currentUser->hasRole('administrator')) {
      $attachments['#attached']['library'][] = 'adsense_injector/adsense-google';
    }
  }

}

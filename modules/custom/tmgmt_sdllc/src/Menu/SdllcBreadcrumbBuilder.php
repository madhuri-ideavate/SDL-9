<?php

/**
 * @file
 * Contains Drupal\tmgmt_sdllc_batch\Menu\SdllcBatchBreadcrumbBuilder
 */

namespace Drupal\tmgmt_sdllc\Menu;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Description of SdllcBatchBreadcrumbBuilder
 *
 * @author ktran
 */
class SdllcBreadcrumbBuilder implements BreadcrumbBuilderInterface {

    use StringTranslationTrait;

    /**
     *
     * {@inheritdoc}
     *
     */
    public function applies(RouteMatchInterface $route_match) {
        if ($route_match->getRouteName() == 'tmgmt_sdllc.tmgmt_sdllc_job_overview') {
            return TRUE;
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function build(RouteMatchInterface $route_match) {
        $breadcrumb = new Breadcrumb ();
        $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
        $breadcrumb->addCacheContexts([
            'route'
        ]);

        // Add links to administration, translation, job overview and job to the
        // breadcrumb.
        $breadcrumb->addLink(Link::createFromRoute($this->t('Administration'),
                'system.admin'));
        $breadcrumb->addLink(Link::createFromRoute($this->t('Translation'),
                'tmgmt.admin_tmgmt'));

        return $breadcrumb;
    }

}

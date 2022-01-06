<?php
namespace Drupal\tmgmt_sdllc\Plugin;

use Drupal\Core\Form\FormStateInterface;
use Drupal\tmgmt\JobCheckoutManager;
use Drupal\tmgmt\SourcePluginUiBase;

/**
 * Content entity source plugin UI.
 *
 * Provides getEntity() method to retrieve list of entities of specific type.
 * It also allows to implement alter hook to alter the entity query for a
 * specific type.
 *
 * @ingroup tmgmt_source
 */
class Test extends JobCheckoutManager {

public function checkoutMultiple(array $jobs, $skip_request_translation = FALSE)
{
    ksm("Testing123 ");
}
 

}

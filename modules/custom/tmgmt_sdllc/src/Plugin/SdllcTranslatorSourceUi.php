<?php
namespace Drupal\tmgmt_sdllc\Plugin;

use Drupal\Core\Form\FormStateInterface;
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
class SdllcTranslatorSourceUi extends SourcePluginUiBase {


  public function overviewFormSubmit(array $form, FormStateInterface $form_state, $type) {
  }

}

<?php

namespace Drupal\tmgmt_sdllc\Plugin\tmgmt\Source;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\Entity;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeBundleInfo;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Plugin\DataType\EntityReference;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Session\AnonymousUserSession;
use Drupal\Core\TypedData\OptionsProviderInterface;
use Drupal\Core\TypedData\PrimitiveInterface;
use Drupal\Core\TypedData\Type\StringInterface;
use Drupal\Core\Url;
use Drupal\tmgmt\ContinuousSourceInterface;
use Drupal\tmgmt\Entity\Job;
use Drupal\tmgmt\JobItemInterface;
use Drupal\tmgmt\SourcePluginBase;
use Drupal\tmgmt\SourcePreviewInterface;
use Drupal\tmgmt\TMGMTException;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;

/**
 * SDL Content entity source plugin controller.
 *
 * @SourcePlugin(
 * id = "sdlcontent",
 * label = @Translation("SDL Content Entity"),
 * description = @Translation("SDL Source handler for entities."),
 * ui = "Drupal\tmgmt_sdllc\Plugin\SdllcTranslatorSourceUi"
 * )
 */
class ContentEntitySourceEx extends SourcePluginBase implements
  SourcePreviewInterface,
  ContinuousSourceInterface
{

  /**
   * {@inheritdoc}
   */
  public function getLabel(JobItemInterface $job_item)
  {
    if ($entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId())) {
      return $entity->label() ?: $entity->id();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl(JobItemInterface $job_item)
  {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    if ($entity = \Drupal::entityTypeManager()
      ->getStorage($job_item->getItemType())
      ->load($job_item->getItemId())
    ) {
      if ($entity->hasLinkTemplate('canonical')) {
        $anonymous = new AnonymousUserSession();
        $url = $entity->toUrl();
        $anonymous_access = \Drupal::config('tmgmt.settings')
          ->get('anonymous_access');
        if ($url && $anonymous_access && !$entity->access('view', $anonymous)) {
          $url->setOption('query',
            [
              'key' => \Drupal::service('tmgmt_content.key_access')->getKey(
                $job_item),
            ]);
        }
        return $url;
      }
    }
    return NULL;
  }

  /**
   * Implements TMGMTEntitySourcePluginController::getData().
   *
   * Returns the data from the fields as a structure that can be processed by
   * the Translation Management system.
   */
  public function getData(JobItemInterface $job_item, $is_target = FALSE, $check_previous = FALSE)
  {
    if ($is_target) {

      if (!$check_previous) {
        return $this->getDataInternal($job_item, TRUE);
      }

      $previous_source = $this->getDataInternal($job_item, FALSE, TRUE);

      if (!isset($previous_source)) {
        return $this->getDataInternal($job_item, TRUE);
      }

      $current_source = $this->getDataInternal($job_item);
      $target_data = $this->getDataInternal($job_item, TRUE);

      if (!isset($target_data)) {
        return $this->getDataInternal($job_item, TRUE);
      }

      $this->filterData($current_source, $target_data, $previous_source);

      return $target_data;
    }

    return $this->getDataInternal($job_item);
  }

  /**
   * Filters data.
   *
   * @param array $source_data
   *   Source data.
   * @param array $target_data
   *   Target data.
   * @param array $previous_source
   *   Previous source.
   */
  private function filterData(array $source_data, array &$target_data, array $previous_source)
  {
    if (!empty($source_data['#text']) && !empty($target_data['#text']) &&
      !empty($previous_source['#text'])
    ) {
      if ($source_data['#text'] != $previous_source['#text']) {
        unset($target_data['#text']);
      }
    }

    foreach (Element::children($source_data) as $key) {
      if (isset($source_data[$key]) && isset($target_data[$key]) &&
        isset($previous_source[$key])
      ) {
        $this->filterData($source_data[$key], $target_data[$key], $previous_source[$key]);
      }
    }
  }

  /**
   * Returns the previous revison of an Entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity to be translated.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   The entity to be translated.
   */
  private function getPreviousRevision(EntityInterface $entity)
  {
    $entity_storage = \Drupal::entityTypeManager()
      ->getStorage($entity->getEntityTypeId());
    $vids = $entity_storage->revisionIds($entity);

    if (count($vids) < 2) {
      return NULL;
    }

    return $entity_storage->loadRevision(array_reverse($vids)[1]);
  }

  /**
   * Gets translations.
   *
   * @param \Drupal\tmgmt\JobItemInterface $job_item
   *   The translation job item.
   * @param bool $is_target
   *   True if job is target.
   * @param bool $check_previous
   *   True if previous should be checked.
   *
   * @return array|null
   *   Array of translatable data.
   *
   * @throws \Drupal\tmgmt\TMGMTException
   */
  private function getDataInternal(JobItemInterface $job_item, $is_target = FALSE, $check_previous = FALSE)
  {
    $entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId());
    if (!$entity) {
      throw new TMGMTException(
        t('Unable to load entity %type with id %id',
          [
            '%type' => $job_item->getItemType(),
            '%id' => $job_item->getItemId(),
          ]));
    }

    // Retrieve the last revision.
    if ($check_previous) {
      $revision = $this->getPreviousRevision($entity);

      if (!$revision) {
        return NULL;
      }

      unset($entity);
      $entity = $revision;
    }

    $languages = \Drupal::languageManager()->getLanguages();
    $id = $entity->language()->getId();
    if (!isset($languages[$id])) {
      throw new TMGMTException(
        t(
          'Entity %entity could not be translated because the language %language is not applicable',
          [
            '%entity' => $entity->language()->getId(),
            '%language' => $entity->language()->getName(),
          ]));
    }

    $lang_code = $job_item->getJob()->getSourceLangcode();

    if ($is_target) {
      $lang_code = $job_item->getJob()->getTargetLangcode();
    }

    if (!$entity->hasTranslation($lang_code) && !$is_target) {
      throw new TMGMTException(
        t('The entity %id with translation %lang does not exist.',
          [
            '%id' => $entity->id(),
            '%lang' => $job_item->getJob()->getSourceLangcode(),
          ]));
    }

    try {
      $translation = $entity->getTranslation($lang_code);

      if ($this->isTranslationOutdated($translation)) {
        return NULL;
      }

      $data = $this->extractTranslatableData($translation, $is_target ? $lang_code : 'default');
      $entity_form_display = \Drupal::entityTypeManager()
        ->getStorage('entity_form_display')
        ->load($job_item->getItemType() . '.' . $entity->bundle() . '.' . 'default');

      uksort($data,
        function ($a, $b) use ($entity_form_display) {
          $a_weight = NULL;
          $b_weight = NULL;
          // Get the weights.
          if ($entity_form_display->getComponent($a) &&
            !is_null($entity_form_display->getComponent($a)['weight'])
          ) {
            $a_weight = (int)$entity_form_display->getComponent($a)['weight'];
          }
          if ($entity_form_display->getComponent($b) &&
            !is_null($entity_form_display->getComponent($b)['weight'])
          ) {
            $b_weight = (int)$entity_form_display->getComponent($b)['weight'];
          }

          // If neither field has a weight, sort alphabetically.
          if ($a_weight === NULL && $b_weight === NULL) {
            return ($a > $b) ? 1 : -1;
          }
          // If one of them has no weight, the other comes
          // first.
          elseif ($a_weight === NULL) {
            return 1;
          } elseif ($b_weight === NULL) {
            return -1;
          } // If both have a weight, sort by weight.
          elseif ($a_weight == $b_weight) {
            return 0;
          } else {
            return ($a_weight > $b_weight) ? 1 : -1;
          }
        });
      return $data;
    } catch (\Exception $e) {

      \Drupal::logger('tmgmt_sdllc')->error(
        'Failed to getTranslation for (@language). Detailed error: @error',
        [
          '@language' => $lang_code,
          '@error' => $e->getMessage(),
        ]);

      return NULL;
    }
  }

  /**
   * Verifies if transaltion is outdates.
   *
   * @param \Drupal\Core\Entity\Entity $translation
   *   Translation of the same entity object.
   *
   * @return bool
   *   True if is outdated, false otherwise.
   */
  private function isTranslationOutdated(Entity $translation)
  {
    try {
      $manager = \Drupal::service('content_translation.manager');

      $metadata = $manager->getTranslationMetadata($translation);

      return $metadata->isOutdated();
    } catch (\Exception $e) {
      \Drupal::logger('tmgmt_sdllc')->error(
        'Failed to getTranslationMetadata. Detailed error: @error',
        [
          '@error' => $e->getMessage(),
        ]);
      return FALSE;
    }
  }

  /**
   * Extracts translatable data from an entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to get the translatable data from.
   * @param string $lang_code
   *   The language code.
   *
   * @return array
   *   Translatable data.
   */
  public function extractTranslatableData(ContentEntityInterface $entity, $lang_code = 'default')
  {

    // @todo Expand this list or find a better solution to exclude fields
    // like
    // content_translation_source.
    if ($lang_code != 'default') {
      try {
        $entity = $entity->getTranslation($lang_code);
      } catch (\Exception $e) {

        \Drupal::logger('tmgmt_sdllc')->error(
          'Failed to extractTranslatableData for (@language). Detailed error: @error',
          [
            '@language' => $lang_code,
            '@error' => $e->getMessage(),
          ]);
        return NULL;
      }
    }

    $field_definitions = $entity->getFieldDefinitions();
    $exclude_field_types = [
      'language',
    ];
    $translatable_fields = array_filter($field_definitions,
      function (FieldDefinitionInterface $field_definition) use ($exclude_field_types) {
        return $field_definition->isTranslatable() &&
          !in_array($field_definition->getType(), $exclude_field_types);
      });

    $data = [];
    foreach ($translatable_fields as $key => $field_definition) {
      $field = $entity->get($key);
      foreach ($field as $index => $field_item) {
        $format = NULL;
        $translatable_properties = 0;
        /* @var FieldItemInterface $field_item */
        foreach ($field_item->getProperties() as $property_key => $property) {
          // Ignore computed values.
          $property_definition = $property->getDataDefinition();
          // Ignore values that are not primitives.
          if (!($property instanceof PrimitiveInterface)) {
            continue;
          }
          $translate = TRUE;
          // Ignore properties with limited allowed values or if
          // they're not strings.
          if ($property instanceof OptionsProviderInterface ||
            !($property instanceof StringInterface)
          ) {
            $translate = FALSE;
          }
          // All the labels are here, to make sure we don't have empty
          // labels in
          // the UI because of no data.
          if ($translate == TRUE) {
            $data[$key]['#label'] = $field_definition->getLabel();
            if (count($field) > 1) {
              // More than one item, add a label for the delta.
              $data[$key][$index]['#label'] = t('Delta #@delta',
                [
                  '@delta' => $index,
                ]);
            }
          }
          $data[$key][$index][$property_key] = [
            '#label' => $property_definition->getLabel(),
            '#text' => $property->getValue(),
            '#translate' => $translate,
          ];

          $translatable_properties += (int)$translate;
          if ($translate && ($field_item->getFieldDefinition()
                ->getFieldStorageDefinition()
                ->getSetting('max_length') != 0)
          ) {
            $data[$key][$index][$property_key]['#max_length'] = $field_item->getFieldDefinition()
              ->getFieldStorageDefinition()
              ->getSetting('max_length');
          }

          if ($property_definition->getDataType() == 'filter_format') {
            $format = $property->getValue();
          }
        }
        // Add the format to the translatable properties.
        if (!empty($format)) {
          foreach ($data[$key][$index] as $name => $value) {
            if (is_array($value) && isset($value['#translate']) &&
              $value['#translate'] == TRUE
            ) {
              $data[$key][$index][$name]['#format'] = $format;
            }
          }
        }
        // If there is only one translatable property, remove the label
        // for it.
        if ($translatable_properties <= 1) {
          foreach (Element::children($data[$key][$index]) as $property_key) {
            unset($data[$key][$index][$property_key]['#label']);
          }
        }
      }
    }

    $embeddable_fields = $this->getEmbeddableFields($entity);
    foreach ($embeddable_fields as $key => $field_definition) {
      $field = $entity->get($key);
      foreach ($field as $index => $field_item) {
        /* @var FieldItemInterface $field_item */
        foreach ($field_item->getProperties(TRUE) as $property_key => $property) {
          // If the property is a content entity reference and it's
          // value is
          // defined, than we call this method again to get all the
          // data.
          if ($property instanceof EntityReference &&
            $property->getValue() instanceof ContentEntityInterface
          ) {
            // All the labels are here, to make sure we don't have
            // empty
            // labels in the UI because of no data.
            $data[$key]['#label'] = $field_definition->getLabel();
            if (count($field) > 1) {
              // More than one item, add a label for the delta.
              $data[$key][$index]['#label'] = t('Delta #@delta',
                [
                  '@delta' => $index,
                ]);
            }

            $translated_version = $this->extractTranslatableData($property->getValue(),
              $lang_code);

            if (isset($translated_version)) {
              $data[$key][$index][$property_key] = $translated_version;
            }
          }
        }
      }
    }
    return $data;
  }

  /**
   * Returns fields that should be embedded into the data for the given entity.
   *
   * Includes explicitly enabled fields and composite entities that are
   * implicitly included to the translatable data.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to get the translatable data from.
   *
   * @return array
   *   Translatable data.
   */
  public function getEmbeddableFields(ContentEntityInterface $entity)
  {
    // Get the configurable embeddable references.
    $field_definitions = $entity->getFieldDefinitions();
    $embeddable_field_names = \Drupal::config('tmgmt_content.settings')
      ->get('embedded_fields');
    $embeddable_fields = array_filter($field_definitions,
      function (FieldDefinitionInterface $field_definition) use ($embeddable_field_names) {
        return !$field_definition->isTranslatable() &&
          isset(
            $embeddable_field_names[$field_definition->getTargetEntityTypeId()][$field_definition->getName()]);
      });

    // Get always embedded references.
    $content_translation_manager = \Drupal::service('content_translation.manager');
    foreach ($field_definitions as $field_name => $field_definition) {
      $storage_definition = $field_definition->getFieldStorageDefinition();

      $property_definitions = $storage_definition->getPropertyDefinitions();
      foreach ($property_definitions as $property_definition) {
        // Look for entity_reference properties where the storage
        // definition
        // has a target type setting and that is enabled for content
        // translation.
        if (in_array($property_definition->getDataType(),
            [
              'entity_reference',
              'entity_revision_reference',
            ]) && $storage_definition->getSetting('target_type') && $content_translation_manager->isEnabled(
            $storage_definition->getSetting('target_type'))
        ) {
          // Include field if the target entity has the parent type
          // field key
          // set, which is defined by entity_reference_revisions.
          $target_entity_type = \Drupal::entityTypeManager()->getDefinition(
            $storage_definition->getSetting('target_type'));
          if ($target_entity_type->get('entity_revision_parent_type_field')) {
            $embeddable_fields[$field_name] = $field_definition;
          }
        }
      }
    }

    return $embeddable_fields;
  }

  /**
   * {@inheritdoc}
   */
  public function saveTranslation(JobItemInterface $job_item, $target_langcode)
  {
    /* @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId());
    if (!$entity) {
      $job_item->addMessage(
        'The entity %id of type %type does not exist, the job can not be completed.',
        [
          '%id' => $job_item->getItemId(),
          '%type' => $job_item->getItemType(),
        ], 'error');
      return FALSE;
    }

    $data = $job_item->getData();
    $this->doSaveTranslations($entity, $data, $target_langcode);
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getItemTypes()
  {
    $entity_types = \Drupal::entityTypeManager()->getDefinitions();
    $types = [];
    $content_translation_manager = \Drupal::service('content_translation.manager');
    foreach ($entity_types as $entity_type_name => $entity_type) {
      // Entity types with this key set are considered composite entities
      // and
      // always embedded in others. Do not expose them as their own item
      // type.
      if ($entity_type->get('entity_revision_parent_type_field')) {
        continue;
      }
      if ($content_translation_manager->isEnabled($entity_type->id())) {
        $types[$entity_type_name] = $entity_type->getLabel();
      }
    }
    return $types;
  }

  /**
   * {@inheritdoc}
   */
  public function getItemTypeLabel($type)
  {
    return \Drupal::entityTypeManager()->getDefinition($type)->getLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function getType(JobItemInterface $job_item) {
    if ($entity = entity_load($job_item->getItemType(), $job_item->getItemId())) {
      $bundles = entity_get_bundles($job_item->getItemType());
      $entity_type = $entity->getEntityType();
      $bundle = $entity->bundle();
      // Display entity type and label if we have one and the bundle isn't
      // the same as the entity type.
      if (isset($bundles[$bundle]) && $bundle != $job_item->getItemType()) {
        return t('@type (@bundle)', array('@type' => $entity_type->getLabel(), '@bundle' => $bundles[$bundle]['label']));
      }
      // Otherwise just display the entity type label.
      return $entity_type->getLabel();
    }
  }


//  public function getType(JobItemInterface $job_item)
//  {
//    if ($entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId())) {
//      $bundles = \Drupal::entityTypeManager()->getDefinition($job_item->getItemType());
//      $entity_type = $entity->getEntityType();
//      $bundle = $entity->bundle();
//      // Display entity type and label if we have one and the bundle isn't
//      // the same as the entity type.
//      if (isset($bundles[$bundle]) && $bundle != $job_item->getItemType()) {
//        return t('@type (@bundle)',
//          [
//            '@type' => $entity_type->getLabel(),
//            '@bundle' => $bundles[$bundle]['label'],
//          ]);
//      }
//      // Otherwise just display the entity type label.
//      return $entity_type->getLabel();
//    }
//  }

  /**
   * {@inheritdoc}
   */
  public function getSourceLangCode(JobItemInterface $job_item)
  {
    $entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId());
    return $entity->getUntranslated()
      ->language()
      ->getId();
  }

  /**
   * {@inheritdoc}
   */
  public function getExistingLangCodes(JobItemInterface $job_item)
  {
    if ($entity = \Drupal::entityTypeManager()->getStorage($job_item->getItemType())->load($job_item->getItemId())) {
      return array_keys($entity->getTranslationLanguages());
    }

    return [];
  }

  /**
   * Saves translation data in an entity translation.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity for which the translation should be saved.
   * @param array $data
   *   The translation data for the fields.
   * @param string $target_langcode
   *   The target language.
   */
  protected function doSaveTranslations(ContentEntityInterface $entity,
                                        array $data,
                                        $target_langcode)
  {
    // If the translation for this language does not exist yet, initialize
    // it.
    if (!$entity->hasTranslation($target_langcode)) {
      $entity->addTranslation($target_langcode, $entity->toArray());
    }

    // $embeded_fields =
    // \Drupal::config('tmgmt_content.settings')->get('embedded_fields');.
    $embeded_fields = $this->getEmbeddableFields($entity);
    $translation = $entity->getTranslation($target_langcode);
    $manager = \Drupal::service('content_translation.manager');
    $manager->getTranslationMetadata($translation)->setSource(
      $entity->language()
        ->getId());

    foreach ($data as $name => $field_data) {
      foreach (Element::children($field_data) as $delta) {
        $field_item = $field_data[$delta];
        foreach (Element::children($field_item) as $property) {
          $property_data = $field_item[$property];
          // If there is translation data for the field property, save
          // it.
          if (isset($property_data['#translation']['#text']) &&
            $property_data['#translate']
          ) {
            $delta_content = $translation->get($name)->offsetGet($delta);
            if (!isset($delta_content)) {
              // Duplicate the source.
              $content = $entity->get($name)->offsetGet($delta);
              $translation->get($name)->offsetSet($delta, $content);
            }

            $translation->get($name)
              ->offsetGet($delta)
              ->set($property, $property_data['#translation']['#text']);
          }
          // If the field is an embeddable reference, we assume that
          // the
          // property is a field reference.
          elseif (isset($embeded_fields[$name]) && $property == 'entity') {
            try {
              $translation_property = $translation->get($name)
                ->offsetGet($delta)->$property;

              if (!isset($translation_property)) {
                $embeded_fields_delta = $translation->get($name)
                  ->offsetGet($delta);

                if (!isset($embeded_fields_delta)) {
                  $embeded_content = $entity->get($name)->offsetGet($delta);

                  $translation->get($name)->offsetSet($delta, $embeded_content);
                  $translation_property = $translation->get($name)->offsetGet(
                    $delta)->$property;
                }
              }

              if (isset($translation_property)) {

                $this->doSaveTranslations($translation_property, $property_data,
                  $target_langcode);
              }
            } catch (\Exception $e) {
              \Drupal::logger('tmgmt_sdllc')->error(
                'Failed to doSaveTranslations. Detailed error: @error',
                [
                  '@error' => $e->getMessage(),
                ]);
            }
          }
        }
      }
    }
    $translation->save();
  }

  /**
   * {@inheritdoc}
   */
  public function getPreviewUrl(JobItemInterface $job_item)
  {
    if ($job_item->getJob()
        ->isActive() && !($job_item->isAborted() || $job_item->isAccepted())
    ) {
      return new Url('tmgmt_content.job_item_preview',
        [
          'tmgmt_job_item' => $job_item->id(),
        ],
        [
          'query' => [
            'key' => \Drupal::service('tmgmt_content.key_access')->getKey(
              $job_item),
          ],
        ]);
    } else {
      return NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function continuousSettingsForm(array &$form, FormStateInterface $form_state, Job $job)
  {
  }

  /**
   * {@inheritdoc}
   */
  public function shouldCreateContinuousItem(Job $job, $plugin, $item_type, $item_id)
  {
    $continuous_settings = $job->getContinuousSettings();
    $entity_manager = \Drupal::entityTypeManager();
    $entity = $entity_manager->getStorage($item_type)->load($item_id);
    $translation_manager = \Drupal::service('content_translation.manager');
    $translation = $entity->hasTranslation($job->getTargetLangcode()) ? $entity->getTranslation(
      $job->getTargetLangcode()) : NULL;
    $metadata = isset($translation) ? $translation_manager->getTranslationMetadata($translation) : NULL;

    // If a translation exists and is not marked as outdated, no new job
    // items
    // needs to be created.
    if (isset($translation) && !$metadata->isOutdated()) {
      return FALSE;
    } else {
      if ($entity && $entity->getEntityType()->hasKey('bundle')) {
        // The entity type has bundles, check both the entity type
        // setting and
        // the bundle.
        if (!empty($continuous_settings[$plugin][$item_type]['bundles'][$entity->bundle()]) &&
          !empty($continuous_settings[$plugin][$item_type]['enabled'])
        ) {
          return TRUE;
        }
      } // No bundles, only check entity type setting.
      elseif (!empty($continuous_settings[$plugin][$item_type]['enabled'])) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Returns the bundle label for a given entity type.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return string
   *   The bundle label.
   */
  protected function getBundleLabel(EntityTypeInterface $entity_type)
  {
    if ($entity_type->getBundleLabel()) {
      return $entity_type->getBundleLabel();
    }
    if ($entity_type->getBundleEntityType()) {
      return \Drupal::entityTypeManager()
        ->getDefinition($entity_type->getBundleEntityType())
        ->getLabel();
    }
    return $this->t('@label type',
      [
        '@label' => $entity_type->getLabel(),
      ]);
  }

}

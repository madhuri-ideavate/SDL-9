<?php
namespace Drupal\tmgmt_sdllc;

use Drupal\Core\Url;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilderInterface;
use Drupal\tmgmt\Entity\ListBuilder\TranslatorListBuilder;
use Drupal\tmgmt_sdllc\Plugin\tmgmt\Translator\SdllcTranslator;

/**
 * Provides a listing of translators.
 */
class SdllcTranslatorListBuilder extends TranslatorListBuilder implements EntityListBuilderInterface
{

    /**
     *
     * {@inheritdoc}
     */
    public function getDefaultOperations(EntityInterface $entity)
    {
        $operations = parent::getDefaultOperations($entity);
        if ($entity->getPlugin() instanceof SdllcTranslator) {
            $jobsUrl = Url::fromRoute('entity.tmgmt_translator.job_collection', [
                'tmgmt_translator' => $entity->id(),
                'tmgmt_id' => $entity->id()
            ]);
            $operations['jobs_overview'] = [
                'url' => $jobsUrl,
                'title' => t('Jobs overview'),
                'weight' => - 100
            ];
            $operations['jobs_auto_retrieval'] = [
                'url' => Url::fromRoute('tmgmt_sdllc.settings', [
                    'tmgmt_translator' => $entity->id()
                ]),
                'title' => t('Auto Retrieval settings'),
                'weight' => - 100
            ];
        }
        return $operations;
    }
}

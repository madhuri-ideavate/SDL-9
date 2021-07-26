<?php
namespace Drupal\tmgmt_sdllc\FormModel;

use Drupal\Core\Datetime\DrupalDateTime;

class CheckoutSettingsFormModel
{

    public function sdllcProjectOptions($data, $sdllcProjectOptions)
    {
        return [
            '#type' => 'select',
            '#options' => $data,
            '#title' => t('Project Options Name'),
            '#required' => TRUE,
            '#default_value' => $sdllcProjectOptions,
        ];
    }

    public function sdllcJobName($data)
    {
        return [
            '#type' => 'textfield',
            '#title' => t('Project Name'),
            '#maxlength' => 50,
            '#default_value' => $data,
            '#description' => t('The name for the SDL Translation Management project.')
        ];
    }

    public function sdllcJobDescription()
    {
        return [
            '#type' => 'textarea',
            '#title' => t('Project Description'),
            '#rows' => 2,
            '#description' => t('The description for the SDL Translation Management project.'),
            '#maxlength' => 255
        ];
    }

    public function sdllcJobDueDate($date)
    {
      $auxData = date('Y-m-d', strtotime(' + 5 days'));
      if (isset($date) && !empty($date)){
        $auxData = $date;
      }
        $timeStamp = new \DateTime(drupal_get_user_timezone());
        $timeStamp->add(new \DateInterval('P7D'));
        date_default_timezone_set(drupal_get_user_timezone());
        return [
            '#type' => 'date',
            '#title' => t('Due Date'),
            '#default_value' => $auxData,
            '#date_increment' => 1,
            '#date_timezone' => drupal_get_user_timezone(),
            '#date_format' => 'Y-m-d',
            '#datepicker_options' => array('maxDate' => 30),
            '#description' => t('The due date for the SDL Translation Management Project.')
        ];
    }
}

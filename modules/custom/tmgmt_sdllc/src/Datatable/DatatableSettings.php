<?php

namespace Drupal\tmgmt_sdllc\Datatable;

class DatatableSettings
{

  /*
   * Return all header settings
   */
  public function returnHeaderSettings()
  {
    return [
      [
        'data' => t('Project Id')
      ],
      [
        'data' => t('Project Name')
      ],
      [
        'data' => t('Created By')
      ],
      [
        'data' => t('Languages')
      ],
      [
        'data' => t('Project Option')
      ],
      [
        'data' => t('Project Due Date')
      ],
      [
        'data' => t('Project Delivered')
      ],
      [
        'data' => t('Status')
      ],
      [
        'data' => t('Cost')
      ]
    ];
  }

  /*
   * Return all the table settins
   * The modifications will affect direct the datatable
   */
  public function returnTableSettings()
  {
    return [
      '#header' => $this->returnHeaderSettings(),
      '#type' => 'table',
      '#theme' => 'datatable',
      '#caption' => t('Translation projects.'),
      '#attributes' => [
        'class' => [
          'joboverview-table'
        ],
        'datatable_options' => [
          'aoColumns' => $this->returnHeaderSettings(),
          'iDisplayLength' => 25,
          'bInfo' => TRUE,
          'bPaginate' => TRUE,
          'aaSorting' => [
            [
              0,
              'desc'
            ]
          ],
          "sDom" => 'T<"clear">lfrtip',
          "bSortCellsTop" => TRUE,
          "oTableTools" => [
            "sSwfPath" => "/libraries/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
            "aButtons" => [
              "copy",
              "print",
              [
                "sExtends" => "collection",
                "sButtonText" => "Save",
                "aButtons" => [
                  "csv",
                  "xls",
                  "pdf"
                ]
              ]
            ]
          ]
        ]
      ],
      '#attached' => [
        'library' => [
          'datatables/datatables_tabletools',
          'tmgmt_sdllc/datatables_tabletools_extra',
          'tmgmt_sdllc/jobinfo'
        ]
      ]
    ];
  }
}

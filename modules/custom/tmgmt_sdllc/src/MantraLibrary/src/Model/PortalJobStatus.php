<?php
namespace MantraLibrary\Model;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * PortalJobStatus class.
 *
 * This is the class created for compatibility with the server Object type.
 *
 * @category class
 * @package MantraLibrary\Model
 */
class PortalJobStatus extends PortalObject
{

    /**
     * Array of property to type mappings.
     * Used for (de)serialization.
     *
     * @var string[]
     */
    public static $propertyTypes = [
        'id' => 'string',
        'providerJobId' => 'string',
        'jobOptionsName' => 'string',
        'jobOptionsId' => 'string',
        'name' => 'string',
        'description' => 'string',
        'createdByUserId' => 'string',
        'createdByUserName' => 'string',
        'projectContact' => 'string',
        'wordCount' => 'int',
        'status' => 'int',
        'cost' => 'double',
        'currency' => '\MantraLibrary\Model\PortalCurrency',
        'createdDate' => '\Date',
        'dueDate' => '\Date',
        'deliveredDate' => '\Date',
        'projectType' => 'int',
        'costDetails' => '\MantraLibrary\Model\PortalJobCostDetail[]',
        'languagePairDetails' => '\MantraLibrary\Model\PortalJobLanguageStatus[]',
        'metadata' => '\MantraLibrary\Model\PortalMetadata[]',
        'isPromoDisc' => 'bool',
        'languages' => 'int',
        'sourceFiles' => 'int',
        'sourceWords' => 'int',
        'percentComplete' => 'int',
        'repeatedWords' => 'int',
        'perfectMatchWords' => 'int',
        'hundredWords' => 'int',
        'fuzzyWords' => 'int',
        'newWords' => 'int',
        'tmSavings' => 'double'
    ];

    /**
     * Array of attributes.
     * The key is the local, the value is the original name.
     *
     * @var string[]
     */
    public static $attributeMap = [
        'id' => 'Id',
        'providerJobId' => 'ProviderJobId',
        'jobOptionsName' => 'JobOptionsName',
        'jobOptionsId' => 'JobOptionsId',
        'name' => 'Name',
        'description' => 'Description',
        'createdByUserId' => 'CreatedByUserId',
        'createdByUserName' => 'CreatedByUserName',
        'projectContact' => 'ProjectContact',
        'wordCount' => 'WordCount',
        'status' => 'Status',
        'cost' => 'Cost',
        'currency' => 'Currency',
        'createdDate' => 'CreatedDate',
        'dueDate' => 'DueDate',
        'deliveredDate' => 'DeliveredDate',
        'projectType' => 'ProjectType',
        'costDetails' => 'CostDetails',
        'languagePairDetails' => 'LanguagePairDetails',
        'metadata' => 'Metadata',
        'isPromoDisc' => 'IsPromoDisc',
        'languages' => 'Languages',
        'sourceFiles' => 'SourceFiles',
        'sourceWords' => 'SourceWords',
        'percentComplete' => 'PercentComplete',
        'repeatedWords' => 'RepeatedWords',
        'perfectMatchWords' => 'PerfectMatchWords',
        'hundredWords' => 'HundredWords',
        'fuzzyWords' => 'FuzzyWords',
        'newWords' => 'NewWords',
        'tmSavings' => 'TMSavings'
    ];

    /**
     * Gets the property type map.
     *
     * {@inheritdoc}
     *
     * @see \MantraLibrary\Model\PortalObject::getPropertyTypes()
     */
    public function getPropertyTypes()
    {
        return self::$propertyTypes;
    }

    /**
     * Gets the property name map.
     *
     * {@inheritdoc}
     *
     * @see \MantraLibrary\Model\PortalObject::getPropertyMaps()
     */
    public function getPropertyMaps()
    {
        return self::$attributeMap;
    }

    /**
     * Property $id.
     *
     * @var string
     */
    public $id;

    /**
     * Property $providerJobId.
     *
     * @var string
     */
    public $providerJobId;

    /**
     * Property $jobOptionsName.
     *
     * @var string
     */
    public $jobOptionsName;

    /**
     * Property $jobOptionsId.
     *
     * @var string
     */
    public $jobOptionsId;

    /**
     * Property $name.
     *
     * @var string
     */
    public $name;

    /**
     * Property $description.
     *
     * @var string
     */
    public $description;

    /**
     * Property $createdByUserId.
     *
     * @var string
     */
    public $createdByUserId;

    /**
     * Property $createdByUserName.
     *
     * @var string
     */
    public $createdByUserName;

    /**
     * Property $projectContact.
     *
     * @var string
     */
    public $projectContact;

    /**
     * Property $wordCount.
     *
     * @var int
     */
    public $wordCount;

    /**
     * Property $status.
     *
     * @var int enum type: 0 => Preparing, 1 => ForApproval, 2 => InProgress, 3 =>
     *      ForDownload, 4 => Completed, 5 => PartialDownload.
     */
    public $status;

    /**
     * For status mapping.
     *
     * @var array
     */
    const JOB_STATUS = [
        'Preparing',
        'For Approval',
        'In Progress',
        'For Download',
        'Completed',
        'Partial Download'
    ];

    /**
     * Property $cost.
     *
     * @var double
     */
    public $cost;

    /**
     * Property $currency.
     *
     * @var \MantraLibrary\Model\PortalCurrency
     */
    public $currency;

    /**
     * Property $createdDate.
     *
     * @var \DateTime
     */
    public $createdDate;

    /**
     * Property $dueDate.
     *
     * @var \DateTime
     */
    public $dueDate;

    /**
     * Property $deliveredDate.
     *
     * @var \DateTime
     */
    public $deliveredDate;

    /**
     * Property $projectType.
     *
     * @var int enum type: 0 => Manual, 1 => Automatic.
     */
    public $projectType;

    /**
     * For projectType mapping.
     *
     * @var array
     */
    const PORTAL_JOB_TYPE = [
        'Manual',
        'Automatic'
    ];

    /**
     * Property $costDetails.
     *
     * @var \MantraLibrary\Model\PortalJobCostDetail[]
     */
    public $costDetails;

    /**
     * Property $languagePairDetails.
     *
     * @var \MantraLibrary\Model\PortalJobLanguageStatus[]
     */
    public $languagePairDetails;

    /**
     * Property $metadata.
     *
     * @var \MantraLibrary\Model\PortalMetadata[]
     */
    public $metadata;

    /**
     * Property $isPromoDisc.
     *
     * @var bool
     */
    public $isPromoDisc;

    /**
     * Property $languages.
     *
     * @var int
     */
    public $languages;

    /**
     * Property $sourceFiles.
     *
     * @var int
     */
    public $sourceFiles;

    /**
     * Property $sourceWords.
     *
     * @var int
     */
    public $sourceWords;

    /**
     * Property $percentComplete.
     *
     * @var int
     */
    public $percentComplete;

    /**
     * Property $repeatedWords.
     *
     * @var int
     */
    public $repeatedWords;

    /**
     * Property $perfectMatchWords.
     *
     * @var int
     */
    public $perfectMatchWords;

    /**
     * Property $hundredWords.
     *
     * @var int
     */
    public $hundredWords;

    /**
     * Property $fuzzyWords.
     *
     * @var int
     */
    public $fuzzyWords;

    /**
     * Property $newWords.
     *
     * @var int
     */
    public $newWords;

    /**
     * Property $tmSavings.
     *
     * @var double
     */
    public $tmSavings;

    /**
     * Constructor.
     *
     * @param mixed[] $data
     *            Associated array of property value initalizing the model.
     */
    public function __construct(array $data = NULL)
    {
        if ($data != NULL) {
            $this->populate($data);
        }
    }

    /**
     * For deserialization from Json data.
     *
     * @param array $data
     *            Associated array of property value initalizing the model.
     */
    private function populate(array $data)
    {
        foreach ($data as $property => $value) {
            $object_property = $this->getProperty($property);

            $object_type = $this->getPropertyType($object_property);

            if (! property_exists($this, $object_property)) {
                continue;
            }

            if (in_array($object_property, [
                'dueDate',
                'createdDate',
                'deliveredDate'
            ])) {

                $this->$object_property = $value;
            } elseif ($object_property == 'currency') {
                $this->$object_property = new PortalCurrency($value);
            } elseif ($object_property == 'costDetails') {
                $object_array = [];

                foreach ($value as $v) {
                    $object_array[] = new PortalJobCostDetail($v);
                }

                $this->$object_property = $object_array;
            } elseif ($object_property == 'languagePairDetails') {
                $object_array = [];

                foreach ($value as $v) {
                    $object_array[] = new PortalJobLanguageStatus($v);
                }

                $this->$object_property = $object_array;
            } elseif ($object_property == 'metadata') {
                $object_array = [];

                foreach ($value as $v) {
                    $object_array[] = new PortalMetadata($v);
                }

                $this->$object_property = $object_array;
            } elseif (in_array($object_property, [
                'wordCount',
                'status',
                'cost',
                'projectType',
                'isPromoDisc',
                'languages',
                'sourceFiles',
                'sourceWords',
                'percentComplete',
                'repeatedWords',
                'perfectMatchWords',
                'hundredWords',
                'fuzzyWords',
                'newWords',
                'tmSavings'
            ])) {
                settype($value, $object_type);
                $this->$object_property = $value;
            } else {
                $this->$object_property = $value;
            }
        }
    }

    /**
     * Gets id.
     *
     * @return string The Job Id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string $id
     *            The Job Id.
     *            
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets providerJobId.
     *
     * @return string The Provider Job Id.
     */
    public function getProviderJobId()
    {
        return $this->providerJobId;
    }

    /**
     * Sets providerJobId.
     *
     * @param string $providerJobId
     *            The Provider Job Id.
     *            
     * @return $this
     */
    public function setProviderJobId($providerJobId)
    {
        $this->providerJobId = $providerJobId;
        return $this;
    }

    /**
     * Gets jobOptionsName.
     *
     * @return string The Job Name.
     */
    public function getJobOptionsName()
    {
        return $this->jobOptionsName;
    }

    /**
     * Sets jobOptionsName.
     *
     * @param string $jobOptionsName
     *            The Job Name.
     *            
     * @return $this
     */
    public function setJobOptionsName($jobOptionsName)
    {
        $this->jobOptionsName = $jobOptionsName;
        return $this;
    }

    /**
     * Gets jobOptionsId.
     *
     * @return string The Job option Id.
     */
    public function getJobOptionsId()
    {
        return $this->jobOptionsId;
    }

    /**
     * Sets jobOptionsId.
     *
     * @param string $jobOptionsId
     *            The Job option Id.
     *            
     * @return $this
     */
    public function setJobOptionsId($jobOptionsId)
    {
        $this->jobOptionsId = $jobOptionsId;
        return $this;
    }

    /**
     * Gets name.
     *
     * @return string The Job name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     *            The Job name.
     *            
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets description.
     *
     * @return string The description.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets description.
     *
     * @param string $description
     *            The description.
     *            
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets createdByUserId.
     *
     * @return string The UserId of the author.
     */
    public function getCreatedByUserId()
    {
        return $this->createdByUserId;
    }

    /**
     * Sets createdByUserId.
     *
     * @param string $createdByUserId
     *            The UserId of the author.
     *            
     * @return $this
     */
    public function setCreatedByUserId($createdByUserId)
    {
        $this->createdByUserId = $createdByUserId;
        return $this;
    }

    /**
     * Gets createdByUserName.
     *
     * @return string The username of the author.
     */
    public function getCreatedByUserName()
    {
        return $this->createdByUserName;
    }

    /**
     * Sets createdByUserName.
     *
     * @param string $createdByUserName
     *            The username of the author.
     *            
     * @return $this
     */
    public function setCreatedByUserName($createdByUserName)
    {
        $this->createdByUserName = $createdByUserName;
        return $this;
    }

    /**
     * Gets projectContact.
     *
     * @return string The project contact.
     */
    public function getProjectContact()
    {
        return $this->projectContact;
    }

    /**
     * Sets projectContact.
     *
     * @param string $projectContact
     *            The project contact.
     *            
     * @return $this
     */
    public function setProjectContact($projectContact)
    {
        $this->projectContact = $projectContact;
        return $this;
    }

    /**
     * Gets wordCount.
     *
     * @return int The word count.
     */
    public function getWordCount()
    {
        return $this->wordCount;
    }

    /**
     * Sets wordCount.
     *
     * @param int $wordCount
     *            The word count.
     *            
     * @return $this
     */
    public function setWordCount($wordCount)
    {
        $this->wordCount = $wordCount;
        return $this;
    }

    /**
     * Gets status.
     *
     * @return int The status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets status mapping.
     *
     * @return string The status.
     */
    public function getStatusName()
    {
        return self::JOB_STATUS[$this->status];
    }

    /**
     * Sets status.
     *
     * @param int $status
     *            The status.
     *            
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Gets cost.
     *
     * @return double The Cost.
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Sets cost.
     *
     * @param double $cost
     *            The Cost.
     *            
     * @return $this
     */
    public function setCost(double $cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * Gets currency.
     *
     * @return \MantraLibrary\Model\PortalCurrency The currency Object.
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets currency.
     *
     * @param \MantraLibrary\Model\PortalCurrency $currency
     *            The currency Object.
     *            
     * @return $this
     */
    public function setCurrency(PortalCurrency $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Gets createdDate.
     *
     * @return \DateTime Created date of the job.
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Sets createdDate.
     *
     * @param \Drupal\Core\Datetime\DrupalDateTime $createdDate
     *            Created date of the job.
     *            
     * @return $this
     */
    public function setCreatedDate(DrupalDateTime $createdDate)
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * Gets dueDate.
     *
     * @return \DateTime Due date of the job.
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Sets dueDate.
     *
     * @param \Drupal\Core\Datetime\DrupalDateTime $dueDate
     *            Due date of the job.
     *            
     * @return $this
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * Gets deliveredDate.
     *
     * @return \DateTime Delivery date of the job.
     */
    public function getDeliveredDate()
    {
        return $this->deliveredDate;
    }

    /**
     * Sets deliveredDate.
     *
     * @param \Drupal\Core\Datetime\DrupalDateTime $deliveredDate
     *            Delivery date of the job.
     *            
     * @return $this
     */
    public function setDeliveredDate(DrupalDateTime $deliveredDate)
    {
        $this->deliveredDate = $deliveredDate;
        return $this;
    }

    /**
     * Gets projectType.
     *
     * @return int The type of the project.
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Gets projectType mapping.
     *
     * @return string The type of the project.
     */
    public function getProjectTypeName()
    {
        if (in_array($this->projectType, self::PORTAL_JOB_TYPE)) {
            return self::PORTAL_JOB_TYPE[$this->projectType];
        }

        return '';
    }

    /**
     * Sets projectType.
     *
     * @param int $projectType
     *            The type of the project.
     *            
     * @return $this
     */
    public function setProjectType($projectType)
    {
        $this->projectType = $projectType;
        return $this;
    }

    /**
     * Gets costDetails.
     *
     * @return \MantraLibrary\Model\PortalJobCostDetail[] The PortalJobCostDetail object.
     */
    public function getCostDetails()
    {
        return $this->costDetails;
    }

    /**
     * Sets costDetails.
     *
     * @param \MantraLibrary\Model\PortalJobCostDetail[] $costDetails
     *            The PortalJobCostDetail object.
     *            
     * @return $this
     */
    public function setCostDetails(array $costDetails)
    {
        $this->costDetails = $costDetails;
        return $this;
    }

    /**
     * Gets languagePairDetails.
     *
     * @return \MantraLibrary\Model\PortalJobLanguageStatus[] Array of PortalJobLanguageStatus.
     */
    public function getLanguagePairDetails()
    {
        return $this->languagePairDetails;
    }

    /**
     * Sets languagePairDetails.
     *
     * @param \MantraLibrary\Model\PortalJobLanguageStatus[] $languagePairDetails
     *            Array of PortalJobLanguageStatus.
     *            
     * @return $this
     */
    public function setLanguagePairDetails(array $languagePairDetails)
    {
        $this->languagePairDetails = $languagePairDetails;
        return $this;
    }

    /**
     * Gets metadata.
     *
     * @return \MantraLibrary\Model\PortalMetadata[] Array of PortalMetadata.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Sets metadata.
     *
     * @param \MantraLibrary\Model\PortalMetadata[] $metadata
     *            Array of PortalMetadata.
     *            
     * @return $this
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * Gets isPromoDisc.
     *
     * @return bool True if IsPromoDisc.
     */
    public function getIsPromoDisc()
    {
        return $this->isPromoDisc;
    }

    /**
     * Sets isPromoDisc.
     *
     * @param bool $isPromoDisc
     *            True if IsPromoDisc.
     *            
     * @return $this
     */
    public function setIsPromoDisc($isPromoDisc)
    {
        $this->isPromoDisc = $isPromoDisc;
        return $this;
    }

    /**
     * Gets languages.
     *
     * @return int Number of languages.
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Sets languages.
     *
     * @param int $languages
     *            Number of languages.
     *            
     * @return $this
     */
    public function setLanguagePairCount($languages)
    {
        $this->languages = $languages;
        return $this;
    }

    /**
     * Gets sourceFiles.
     *
     * @return int The number of sourceFiles.
     */
    public function getSourceFiles()
    {
        return $this->sourceFiles;
    }

    /**
     * Sets sourceFiles.
     *
     * @param int $sourceFiles
     *            The number of sourceFiles.
     *            
     * @return $this
     */
    public function setSourceFiles($sourceFiles)
    {
        $this->sourceFiles = $sourceFiles;
        return $this;
    }

    /**
     * Gets sourceWords.
     *
     * @return int The number of sourceWords.
     */
    public function getSourceWords()
    {
        return $this->sourceWords;
    }

    /**
     * Sets sourceWords.
     *
     * @param int $sourceWords
     *            The number of sourceWords.
     *            
     * @return $this
     */
    public function setSourceWords($sourceWords)
    {
        $this->sourceWords = $sourceWords;
        return $this;
    }

    /**
     * Gets percentComplete.
     *
     * @return int The percent complete.
     */
    public function getPercentComplete()
    {
        return $this->percentComplete;
    }

    /**
     * Sets percentComplete.
     *
     * @param int $percentComplete
     *            The percent complete.
     *            
     * @return $this
     */
    public function setPercentComplete($percentComplete)
    {
        $this->percentComplete = $percentComplete;
        return $this;
    }

    /**
     * Gets repeatedWords.
     *
     * @return int The number of repeated words.
     */
    public function getRepeatedWords()
    {
        return $this->repeatedWords;
    }

    /**
     * Sets repeatedWords.
     *
     * @param int $repeatedWords
     *            The number of repeated words.
     *            
     * @return $this
     */
    public function setRepeatedWords($repeatedWords)
    {
        $this->repeatedWords = $repeatedWords;
        return $this;
    }

    /**
     * Gets perfectMatchWords.
     *
     * @return int The number of match words.
     */
    public function getPerfectMatchWords()
    {
        return $this->perfectMatchWords;
    }

    /**
     * Sets perfectMatchWords.
     *
     * @param int $perfectMatchWords
     *            The number of match words.
     *            
     * @return $this
     */
    public function setPerfectMatchWords($perfectMatchWords)
    {
        $this->perfectMatchWords = $perfectMatchWords;
        return $this;
    }

    /**
     * Gets hundredWords.
     *
     * @return int The hundred words.
     */
    public function getHundredWords()
    {
        return $this->hundredWords;
    }

    /**
     * Sets hundredWords.
     *
     * @param int $hundredWords
     *            The hundred words.
     *            
     * @return $this
     */
    public function setHundredWords($hundredWords)
    {
        $this->hundredWords = $hundredWords;
        return $this;
    }

    /**
     * Gets fuzzyWords.
     *
     * @return int The fuzzy words.
     */
    public function getFuzzyWords()
    {
        return $this->fuzzyWords;
    }

    /**
     * Sets fuzzyWords.
     *
     * @param int $fuzzyWords
     *            The fuzzy words.
     *            
     * @return $this
     */
    public function setFuzzyWords($fuzzyWords)
    {
        $this->fuzzyWords = $fuzzyWords;
        return $this;
    }

    /**
     * Gets newWords.
     *
     * @return int The NewWords.
     */
    public function getNewWords()
    {
        return $this->newWords;
    }

    /**
     * Sets newWords.
     *
     * @param int $newWords
     *            The NewWords.
     *            
     * @return $this
     */
    public function setNewWords($newWords)
    {
        $this->newWords = $newWords;
        return $this;
    }

    /**
     * Gets tmSavings.
     *
     * @return double The TmSavings.
     */
    public function getTmSavings()
    {
        return $this->tmSavings;
    }

    /**
     * Sets tmSavings.
     *
     * @param double $tmSavings
     *            The TmSavings.
     *            
     * @return $this
     */
    public function setTmSavings(double $tmSavings)
    {
        $this->tmSavings = $tmSavings;
        return $this;
    }
}

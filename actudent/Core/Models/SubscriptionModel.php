<?php namespace Actudent\Core\Models;

use OstiumDate;

class SubscriptionModel extends \Actudent\Core\Models\Connector
{
    /**
     * Query builder for tb_subscription
     * 
     * @var object
     */
    private $QBSubscription;

    /**
     * Query builder for tb_organization
     * 
     * @var object
     */
    private $QBOrganization;

    /**
     * Table tb_subscription
     * 
     * @var string
     */
    private $subscription = 'tb_subscription';
    
    /**
     * Table tb_organization
     * 
     * @var string
     */
    private $organization = 'tb_organization';

    /**
     * Student's limit based on subscription type
     * 
     * @var array
     */
    public $subsLimit = [
        'free'          => 200,
        'starter'       => 750,
        'standard'      => 1250,
        'enhanced'      => 2000,
        'enterprise'    => 100000
    ];

    /**
     * Build up QueryBuilder
     */
    public function __construct()
    {
        parent:: __construct();
        $this->QBSubscription = $this->dbMain->table($this->subscription);
        $this->QBOrganization = $this->dbMain->table($this->organization);
    }

    /**
     * Get student limitation
     * 
     * @return int
     */
    public function getLimit(): int
    {
        $subscriber = $this->getSubscription();

        return $this->subsLimit[$subscriber->subscription_type];
    }

    /**
     * Check if subscription has been expired or not
     * 
     * @return boolean
     */
    public function hasExpired(): bool
    {
        $subscriber = $this->getSubscription();
        $currentDate = date('Y-m-d H:i:s');

        if($currentDate > $subscriber->subscription_expiration)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get package detail
     * 
     * @return object
     */
    public function getPackageDetail()
    {
        $os = new OstiumDate;
        $subscription = $this->getSubscription();
        $limit = $this->getLimit();
        $dateArray = explode(' ', $subscription->subscription_expiration);
        $expireDate = $os->format('d-MM-y', reverse($dateArray[0], '-', '-'));

        return (object) [
            'name'      => ucfirst($subscription->subscription_type),
            'limit'     => $limit,
            'expiration'=> $expireDate,
        ];
    }

    /**
     * Get subscription data
     * 
     * @return array
     */
    private function getSubscription(): object
    {
        $organizationID = $this->getOrganizationID();
        $query = $this->QBSubscription->getWhere(['organization_id' => $organizationID]);

        return $query->getResult()[0];
    }

    /**
     * Retrieve organization ID by its url
     * 
     * @return int
     */
    private function getOrganizationID(): int
    {
        $uri    = new \CodeIgniter\HTTP\URI(base_url());
        $host   = $uri->getHost();
        $query  = $this->QBOrganization->getWhere(['organization_origination' => $host]);

        return $query->getResult()[0]->organization_id;
    }
}
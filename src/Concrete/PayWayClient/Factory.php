<?php

namespace Concrete\Package\CommunityStoreBccPayway\PayWayClient;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Package\CommunityStoreBccPayway;

defined('C5_EXECUTE') or die('Access Denied');

class Factory
{
    /**
     * @var \Concrete\Core\Config\Repository\Repository
     */
    protected $config;

    /**
     * @var \Concrete\Package\CommunityStoreBccPayway\Http\DriverFactory
     */
    protected $httpDriverFactory;

    public function __construct(Repository $config, CommunityStoreBccPayway\Http\DriverFactory $httpDriverFactory)
    {
        $this->config = $config;
        $this->httpDriverFactory = $httpDriverFactory;
    }

    /**
     * @param string $environment the environment to be used (empty string to use the default)
     *
     * @return \Concrete\Package\CommunityStoreBccPayway\PayWayClient
     */
    public function buildClient($environment = '')
    {
        $environment = (string) $environment;
        if ($environment === '') {
            $environment = (string) $this->config->get('community_store_bcc_payway::options.environment');
        }

        return new CommunityStoreBccPayway\PayWayClient(
            $environment,
            $this->config->get("community_store_bcc_payway::options.environments.{$environment}.terminalID"),
            $this->config->get("community_store_bcc_payway::options.environments.{$environment}.servicesURL"),
            $this->config->get("community_store_bcc_payway::options.environments.{$environment}.signatureKey"),
            $this->httpDriverFactory->createDriver()
        );
    }
}

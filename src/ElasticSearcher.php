<?php
	
	namespace ElasticSearcher;
	
	use Elasticlegacy\Client;
	use Elasticlegacy\ClientBuilder;
	use ElasticSearcher\Managers\IndicesManager;
	use ElasticSearcher\Managers\DocumentsManager;
	
	/**
	 * Package.
	 */
	class ElasticSearcher
	{
		/**
		 * @var Environment
		 */
		private $environment;
		
		/**
		 * @var Client
		 */
		private $client;
		
		/**
		 * @var IndicesManager
		 */
		private $indicesManager;
		
		/**
		 * @var DocumentsManager
		 */
		private $documentsManager;
		
		/**
		 * @param Environment $environment
		 */
		public function __construct(Environment $environment)
		{
			$this->environment = $environment;
			$this->createClient();
		}
		
		/**
		 * Create a client instance from the ElasticSearch SDK.
		 */
		public function createClient()
		{
			$client = new Client($this->environment->all());
			
			$this->setClient($client);
		}
		
		/**
		 * @param \Elasticlegacy\Client $client
		 */
		public function setClient(Client $client)
		{
			$this->client = $client;
		}
		
		/**
		 * @return \Elasticlegacy\Client
		 */
		public function getClient()
		{
			return $this->client;
		}
		
		/**
		 * @return IndicesManager
		 */
		public function indicesManager()
		{
			if (!$this->indicesManager) {
				$this->indicesManager = new IndicesManager($this);
			}
			
			return $this->indicesManager;
		}
		
		/**
		 * @return DocumentsManager
		 */
		public function documentsManager()
		{
			if (!$this->documentsManager) {
				$this->documentsManager = new DocumentsManager($this);
			}
			
			return $this->documentsManager;
		}
		
		/**
		 * @return bool
		 */
		public function isHealthy()
		{
			$info = $this->getClient()->cluster()->health();
			
			return $info['status'] == 'green';
		}
	}

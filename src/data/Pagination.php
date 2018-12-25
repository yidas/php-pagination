<?php

namespace yidas\data;

use Exception;

/**
 * Pagination
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @version 1.0.7
 */
class Pagination
{
    /**
     * The limit of the data
     *
     * @var integer
     */
    public $limit;

    /**
     * The offset of the data
     *
     * @var integer
     */
    public $offset;

    /**
     * The current page number (zero-based). The default value is 1, meaning the first page.
     *
     * @var integer
     */
    public $page;

    /**
     * Number of pages
     *
     * @var integer
     */
    public $pageCount;

    /**
     * Name of the parameter storing the current page index
     *
     * @var string
     */
    public $pageParam = 'page';

    /**
     * The number of items per page
     *
     * @var integer
     */
    public $perPage = 20;

    /**
     * Name of the parameter storing the page size
     *
     * @var string|boolean `false` to turn off per-page input by client
     */
    public $perPageParam = 'per-page';

    /**
     * The per page number limits. The first array element stands for the minimal page size, and the
     * second the maximal page size
     *
     * @var array
     */
    public $perPageLimit = [1, 50];

    /**
     * Parameters (name => value) that should be used to obtain the current page number and to create new pagination URLs
     *
     * @var array
     */
    public $params;

    /**
     * Total number of items
     *
     * @var integer
     */
    public $totalCount;

    /**
     * Whether to check if $page is within valid range
     *
     * @var boolean
     */
    public $validatePage = true;

    /**
     * Required option keys
     *
     * @param array
     */
    protected $requireOptions = ['totalCount'];

    /**
     * Default options
     *
     * @param array
     */
    protected $defaultOpt = [];

    function __construct($options=[]) 
    {
        // Required options check
        foreach ($this->requireOptions as $key => $optionKey) {
            if (!isset($options[$optionKey])) {
                throw new Exception("Pagination option `{$optionKey}` is required", 500);
            }
        }

        $options = array_merge($this->defaultOpt, $options);
        
        // Options to properties
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }

        // Page fetching
        if ($this->page===null) {
            
            $this->page = isset($_GET[$this->pageParam]) ? $_GET[$this->pageParam] : 1;
        }

        // PrePage fetching
        if (!isset($options[$this->perPageParam]) && $this->perPageParam && isset($_GET[$this->perPageParam])) {
            
            // Limit check
            $input = (int) $_GET[$this->perPageParam];
            list($min, $max) = $this->perPageLimit;
            $this->perPage = ($input <= $max && $input >= $min) ? $input : $this->perPage;
        }

        $this->_init();
    }

    /**
     * Sets the current page number
     *
     * @param integer $var
     * @return self
     */
    public function setPage($page)
    {
        $this->page = (int) $page;

        $this->_init();
        
        return $this;
    }

    /**
     * Sets the number of items per page
     *
     * @param integer $var
     * @return self
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        $this->_init();
        
        return $this;
    }

    /**
     * Creates the URL suitable for pagination with the specified page number
     *
     * @param integer $page
     * @param integer $perPage
     * @return string
     */
    public function createUrl($page, $perPage=null)
    {
        $requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        // Add or reset page parameter
        $params[$this->pageParam] = (int) $page;
        if ($this->perPageParam) {
            $params[$this->perPageParam] = ($perPage) ? $perPage : $this->perPage;
        }
        // Build URL
        $url = "//{$_SERVER['HTTP_HOST']}{$requestUri}?" . http_build_query(array_merge($_GET, $params));

        return $url;
    }

    /**
     * Initialize pagination
     *
     * @return void
     */
    protected function _init()
    {
        // Format
        $this->totalCount = ($this->totalCount > 0) ? floor($this->totalCount) : 0;
        $this->perPage = ($this->perPage >= 1) ? floor($this->perPage) : 20;
        $this->page = ($this->page >= 1) ? floor($this->page) : 1;
        $this->pageCount = ceil($this->totalCount / $this->perPage);
        $this->pageCount = ($this->pageCount > 0) ? $this->pageCount : 1;

        // Validate page
        if ($this->validatePage) {
            $this->page = ($this->page <= $this->pageCount) ? $this->page : $this->pageCount;
        }

        $this->offset = $this->perPage * ($this->page - 1);
        // Limit ignores (total - offset)
        $this->limit = $this->perPage;
    }
}

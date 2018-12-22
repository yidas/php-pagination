***php*** Pagination
===============

PHP Paginator with Pager Widget (pure PHP, CI, Yii, Laravel support)

[![Latest Stable Version](https://poser.pugx.org/yidas/pagination/v/stable?format=flat-square)](https://packagist.org/packages/yidas/pagination)
[![Latest Unstable Version](https://poser.pugx.org/yidas/pagination/v/unstable?format=flat-square)](https://packagist.org/packages/yidas/pagination)
[![License](https://poser.pugx.org/yidas/pagination/license?format=flat-square)](https://packagist.org/packages/yidas/pagination)

Features
--------

- *Compatible with pure PHP, Codeigniter, Yii & Laravel*

- ***SOLID principle** with Yii 2 pattern like*

- ***Pagination Widget** (View Block) included* 

---

OUTLINE
-------

- [Demonstration](#demonstration)
- [Requirements](#requirements)
    - [PDO with pure PHP](#pdo-with-pure-php)
    - [Codeiginter 3 Framework](#codeiginter-3-framework)
    - [Widget Render](#widget-render)
- [Installation](#installation)
    - [Codeigniter 3](#codeigniter-3)
- [Configuration](#configuration)
    - [Inheritance](#inheritance)
- [Usage](#usage)
    - [Widget](#widget)
        - [Customized View](#customized-view)
        - [Inheritance](#inheritance-1)
    - [Build URL](#build-url)
- [API Documentation](#api-documentation)
- [Examples](#examples)
    - [PDO with pure PHP](#pdo-with-pure-php-1)
    - [Codeiginter 3 Framework](#codeiginter-3-framework-1)
- [References](#references)

---

DEMONSTRATION
-------------

### PDO with pure PHP

```php
// Get count of data set first
$sql = "SELECT count(*) FROM `table`"; 
$count = $conn->query($sql)->fetchColumn(); 

// Initialize a Data Pagination with previous count number
$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
]);

// Get range data for the current page
$sql = "SELECT * FROM `table` LIMIT {$pagination->offset}, {$pagination->limit}"; 
$sth = $conn->prepare($sql);
$sth->execute();
$data = $sth->fetchAll();
```

### Codeiginter 3 Framework

```php
$query = $this->db->where('type', 'C');

// Clone same query for get total count
$countQuery = clone $query;

// Get total count from cloned query
// Or you could use count_all_results('', false) to keep query instead of using `clone`
$count = $countQuery->count_all_results();

// Initialize a Data Pagination with previous count number
$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
]);

// Get range data for the current page
$records = $query
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->get()->result_array();
```

### Widget Render

```php
<div>
<?=\yidas\widgets\Pagination::widget([
    'pagination' => $pagination
])?>
</div>
```

<img src="https://raw.githubusercontent.com/yidas/php-pagination/master/img/widget.png" width="300px" />

> `$pagination` is the object of `yidas\data\Pagination`.

---

REQUIREMENTS
------------
This library requires the following:

- PHP 5.4.0+

---

INSTALLATION
------------

Run Composer in your project:

    composer require yidas/pagination

Then initialize it at the bootstrap of application such as config file:

```php
require __DIR__ . '/vendor/autoload.php';
```

### Codeigniter 3 

Run Composer in your Codeigniter project under the folder `\application`:

    composer require yidas/pagination
    
Check Codeigniter `application/config/config.php`:

```php
$config['composer_autoload'] = TRUE;
```
    
> You could customize the vendor path into `$config['composer_autoload']`

---

CONFIGURATION
-------------

The simple config and usage could refer to [Demonstration](#demonstration).

When you are dealing with pagination, you could new `yidas\data\Pagination` with configuration to get pager information for data query. For example:

```php
// Get total rows from your query
$count = $query->count();
// Initialize a Data Pagination
$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
    'pergpage' => 10,
]);
// ...use $pagination offset/limit info for your query
```

For more parameters, you could refer to [API Documentation](#api-documentation).

### Inheritance

You could build your application data Pagination with styles Inherited from `yidas\data\Pagination`. For example:

```php
namespace yidas\data;

use yidas\data\Pagination as BasePagination;

class Pagination extends BasePagination
{
    // Name of the parameter storing the current page index
    public $pageParam = 'page';
    
    // The number of items per page
    public $perPage = 10;
    
    // Name of the parameter storing the page size
    // false to turn off per-page input by client
    public $perPageParam = false;
}
```

---

USAGE
-----

When there are too much data to be displayed on a single page, a common strategy is to display them in multiple pages and on each page only display a small portion of the data. This strategy is known as *pagination*.

This library uses a `yidas\data\Pagination` object to represent the information about a pagination scheme. In particular,

- `total count` specifies the total number of data items. Note that this is usually much more than the number of data items needed to display on a single page.
- `page size` specifies how many data items each page contains. The default value is 20.
- `current page` gives the current page number (not zero-based). The default value is 1, meaning the first page.

With a fully specified `yidas\data\Pagination object`, you can retrieve and display data partially. For example, if you are fetching data from a database, you can specify the `OFFSET` and `LIMIT` clause of the DB query with the corresponding values provided by the pagination. Below is an example:

```php
/**
 * Yii 2 Framework sample code
 */
use yidas\data\Pagination;

// build a DB query to get all articles with status = 1
$query = Article::find()->where(['status' => 1]);

// get the total number of articles (but do not fetch the article data yet)
$count = $query->count();

// create a pagination object with the total count
$pagination = new Pagination(['totalCount' => $count]);

// limit the query using the pagination and retrieve the articles
$articles = $query->offset($pagination->offset)
    ->limit($pagination->limit)
    ->all();
```

### Widget

To facilitate building the UI element that supports pagination, This library provides the `yii\widgets\Pagination` widget that displays a list of page buttons upon which users can click to indicate which page of data should be displayed. The widget takes a pagination object so that it knows what is the current page and how many page buttons should be displayed. For example,

```php
use yidas\widgets\Pagination;

echo  Pagination::widget([
    'pagination' => $pagination
]);
```
> `$pagination` is a `yidas\data\Pagination` object for data provider.

#### Customized View

The default widget view is for Bootstrap(`bootstrap`), you could customized your pagination view then set into Pagination Widget.

```php
use yidas\widgets\Pagination;

echo  Pagination::widget([
    'pagination' => $pagination,
    'view' => $appPagerViewPath,
]);
```

> You could also choose library's template view: `bootstrap`, `simple`

#### Inheritance

You could build your application Pagination Widget with styles Inherited from `yidas\widgets\Pagination`. For example:

```php
<?php

namespace app\widgets;

use yidas\widgets\Pagination as BaseWidget;

/**
 * Pagination Widget
 */
class Pagination extends BaseWidget
{
    // Set the Widget pager is center align or not   
    public $alignCenter = false;
    
    // Maximum number of page buttons that can be displayed   
    public $buttonCount = 7;

    // The text label for the "first" page button
    public $firstPageLabel = '<i class="fa fa-step-backward" aria-hidden="true"></i>';

    // The text label for the "last" page button
    public $lastPageLabel = '<i class="fa fa-step-forward" aria-hidden="true"></i>';
    
    // The text label for the "next" page button
    public $nextPageLabel = '<i class="fa fa-caret-right" aria-hidden="true"></i>';
    
    // The text label for the "previous" page button
    public $prevPageLabel = '<i class="fa fa-caret-left" aria-hidden="true"></i>';
    
    // <ul> class. For example, 'pagination-sm' for Bootstrap small size.
    public $ulCssClass = '';
}
```


### Build URL

If you want to build UI element manually, you may use `yidas\data\Pagination::createUrl()` to create URLs that would lead to different pages. The method requires a page parameter and will create a properly formatted URL containing the page parameter. For example:

```php
// ex. https://yoursite.com/list/
// displays: https://yoursite.com/list/?page=100
echo $pagination->createUrl(100);

// ex. https://yoursite.com/list/?sort=desc&type=a
// displays: https://yoursite.com/list/?sort=desc&type=a&page=101
echo $pagination->createUrl(101);
```
> The formatted URL pattern is `//{current-host-uri}{parameters-with-pagination}`

You could also build a `per-page` setting URL for changing `per-page` when `perPageParam` is set:

```php
// ex. https://yoursite.com/list/
// displays: https://yoursite.com/list/?page=1&per-page=50
echo $pagination->createUrl(1, 50);
```

---

EXAMPLES
--------

### PDO with Pure PHP

```php
$conn = new PDO("mysql:host=localhost;dbname=database", 'username', 'password');

// Get count of data set first
$sql = "SELECT count(*) FROM `table`"; 
$count = $conn->query($sql)->fetchColumn(); 

// Initialize a Data Pagination with previous count number
$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
]);

// Get range data for the current page
$sql = "SELECT * FROM `table` LIMIT {$pagination->offset}, {$pagination->limit}"; 
$sth = $conn->prepare($sql);
$sth->execute();
$data = $sth->fetchAll();

print_r($data);
```

LinkPager display:

```php
echo yidas\widgets\Pagination::widget([
    'pagination' => $pagination
]);
```

### Codeiginter 3 Framework

Codeiginter 3 Framework with [yidas/codeigniter-model](https://github.com/yidas/codeigniter-model):

```php
$this->load->model('Post_model');

$query = $this->Post_model->find()
    ->where('type', 'C');
    
// Clone same query for get total count
$countQuery = clone $query;

// Get total count from cloned query
// Or you could use count(false) to keep query instead of using `clone`
$count = $countQuery->count();

// Initialize a Data Pagination with previous count number
$pagination = new \yidas\data\Pagination([
    'totalCount' => $count,
]);

// Get range data for the current page
$records = $query
    ->offset($pagination->offset)
    ->limit($pagination->limit)
    ->get()->result_array();
```

LinkPager in view:

```php
<div>
<?=yidas\widgets\Pagination::widget([
    'pagination' => $pagination
])?>
</div>
```

---

API DOCUMENTATION
-----------------

### Data Pagination

|Public Property|Type   |Description   |
|:--            |:--    |:--           |
|$limit         |integer|The limit of the data|
|$offset        |integer|The offset of the data|
|$page          |integer|The current page number (zero-based). The default value is 1, meaning the first page.|
|$pageCount     |integer|Number of pages|
|$pageParam     |string |Name of the parameter storing the current page index, default value is `page`|
|$perPage       |integer|The number of items per page, default value is 20|
|$perPageParam  |string |Name of the parameter storing the page size, default value is `per-page`|
|$perPageLimit  |array  |The per page number limits. The first array element stands for the minimal page size, and the second the maximal page size, default value is `[1, 50]`|
|$params        |array  |Parameters (name => value) that should be used to obtain the current page number and to create new pagination URLs|
|$totalCount    |integer|Total number of items|
|$validatePage  |boolean|Whether to check if $page is within valid range|

### Widget Pagination

|Public Property|Type   |Description   |
|:--            |:--    |:--           |
|$alignCenter   |boolean|Set the Widget pager is center align or not, default value is `true`|
|$buttonCount   |integer|Maximum number of page buttons that can be displayed, default value is |
|$pagination|yidas\data\Pagination|The data pagination object that this pager is associated with|
|$firstPageLabel|string |The text label for the "first" page button, default value is `First`|
|$lastPageLabel |string |The text label for the "last" page button, default value is `Last`|
|$nextPageLabel |string |The text label for the "next" page button, default value is `Next`|
|$prevPageLabel |string |The text label for the "previous" page button, default value is `Prev`|
|$firstPageCssClass|string|The CSS class for the "first" page button|
|$lastPageCssClass|string|The CSS class for the "last" page button|
|$nextPageCssClass|string|The CSS class for the "next" page button|
|$prevPageCssClass|string|The CSS class for the "previous" page button|
|$pageCssClass|string   |The CSS class for the each page button, default value is `page-item`|
|$ulCssClass |string   |The CSS class for the ul element of pagination. For example, 'pagination-sm' for Bootstrap small size.|
|$linkAttributes|array  |HTML attributes for the link in a pager container tag, default value is ['class' => 'page-link']|
|$view          |string |The view name or absolute file path that can be used to render view. (Template: `bootstrap`, `simple`)|

---

REFERENCES
----------

[Yii 2 PHP Framework - Displaying Data: Pagination](https://www.yiiframework.com/doc/guide/2.0/en/output-pagination)

[Yii 2 PHP Framework - Class yii\data\Pagination](https://www.yiiframework.com/doc/api/2.0/yii-data-pagination)












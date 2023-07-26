# vcv-php-client

## Installation
> **Requires [PHP 8.0+](https://php.net/releases/)**

To get started, simply require the project using [Composer](https://getcomposer.org).
## Examples

```php
<?php

require_once 'vendor/autoload.php';


$api = new Api('your_access_token');

$api->users->me();
```

### Vacancies

```php
//return the vacancies api
$vacancies = $api->vacancies

//Build filter by title request
$request = (new ApiRequestBuilder())
    ->withUser()
    ->whereTitle('(copy)')
    ->getRequest();

//returns list of vacancies
$vacancies->list($request);

//return the Vacancy 123
$vacancies->getById(123);

//delete vacancy 123
$vacancies->delete(123);
```

### Response Comments

```php
//return current user 
$user = $api->users->me();

//return response comments api
$comments = $api->responseComments;

//Build request for filtering comments created by current user
$request = (new ApiRequestBuilder())
->whereUserId($user['user']['id'])
->setPageSize(10)
->getRequest();

//list comments by filter
$response = $comments->list($request);

foreach ($response['_embedded']['comments'] as $comment) {
    $comment['message'] = $comment['message'] . ' [UPDATED]';
    //update response comment message
    $comments->update($comment['id'], $comment);
}
```


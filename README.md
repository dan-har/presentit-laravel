# presentit-laravel

Presentit adapter for laravel framework.

Custom presentations and transformation of nested Eloquent models, models relations and collections.

See full presentit docs [here](https://github.com/dan-har/presentit)

# Docs
+ [Installation](#installation)
+ [Transform Eloquent models](#Transform Eloquent models)
+ [Transform collection](#Transform collection)

## Installation

Install using composer

```
composer require dan-har/presentit-laravel
```

Add the presentit service provider to the app config

```php
'providers' => [
    // ...
    Presentit\Laravel\PresentitServiceProvider::class,
]
```
## Transform Eloquent models

Use presentit transformation functionality with any Eloquent model by implementing the ```Presentable``` contract and using the ```PresentsItem``` trait.  

For example, the User model class with the PresentsItem trait

```php
class User extends Authenticatable implements Presentable
{
    use PresentsItem;
    
    //...
}
```

To transform the user model use the ```present``` method to get a ```Present``` instance or use the ```transfrom``` method to use a transformer.
   
```php
$user = User::find(1);

$user->present()->with(function(User $user){
    return [
        //...
    ];
});

$user->transform(function(User $user){
    return [
        //...
    ];
});
```

Note that instead of closure transformer you can pass a transformer class, see presentit docs.

## Transform collections

To transform collections the ```present``` and ```transformWith``` macros were added to the base collection.

```php
$posts = Collection::make();

$posts->present()->each(function (Post $post) {
    return [
        //...
    ];
});

$posts->transformWith(function (Post $post) {
    return [
        //...
    ];
});
```

Model relations that returns collections such as HasMany will also have the presentit transformation functionality
  
```php
class Post implements Presentable
{
    use PresentsItem;
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

$posts = Posts::find(1);

$posts->comments->transformWith(function (Comment $comment) {
    return [
        //...
    ];
});
```

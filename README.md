# presentit-laravel

Presentit adapter for laravel framework.

Custom presentations and transformation of nested Eloquent models, models relations and collections.

See full presentit docs [here](https://github.com/dan-har/presentit)

# Docs
+ [Installation](#installation)
+ [Transform Eloquent models](#Transform-Eloquent-models)
+ [Transform collection](#Transform-collection)
+ [Transform nested models and relations](#Transform-nested-models-and-relations)

## Installation

Install using composer

```
composer require dan-har/presentit-laravelq
```

Add the presentit service provider to the app config file

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

Instead of closure transformer you can pass a transformer class, see presentit docs or example below.

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

> The collection presentit api uses the ```transformWith``` method because the ```transform``` method exists in the base laravel collection.
  
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

## Nested models and relations

To demonstrate the nested model transformation we will use an example of a Post with comments and on each comment users can write comments.
So first we use a transformer class for the Post, Comment and User model 

```php
class UserTransformer
{
    public function transform(User $user) {
        return [
            'name' => ucfirst($user->name),
            'profile_image' => $user->profile_image ?: Hidden::key(),
        ];
    }
}


class CommentTransformer
{
    public function transform(Comment $comment)
    {
        return [
            'text' => $comment->text,
            'datetime' => $comment->created_at->toW3cString(),
            'edited_datetime' => $comment->edited_at ? $comment->edited_at : Hidden::key(),
            'user' => $comment->user->transform(UserTransformer::class),
            'comments' => $comment->comments->transformWith(CommentTransformer::class),
        ];
    }
}


class PostTransformer
{
    public function tranfrom(Post $post)
    {
        return [
            'title' => $post->title,
            'text' => $post->text,
            'user' => $post->user->transform(UserTransformer::class),
            'datetime' => $post->created_at->toW3cString(),
            'comments' => $post->comments->transformWith(CommentTransformer::class),
        ];
    }
}
```

Then to transform a single post use

```php
$post = Post::find(1);

$array = $post->transform(PostTransformer::class)->show();
```

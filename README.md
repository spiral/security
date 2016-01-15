# Security Module
Security module provides ability to manage user access using set of defined roles, permissions 
and rules.

Definition
----------
* `ActorInterface` (user) has one (none is allowed as well) or multiple roles
* Role associated with one or multiple permissions
* Role associated to permission based on a given rule (by default `ALLOW`)
* Code must check Actor access using `GuardInterface`, permission and operation context

Example:
--------
```php
public function boot(RulesInterface $rules, PermissionsInterface $permissions)
{
    //Registering custom rule
    $rules->set('custom-rule', function () {
        return mt_rand(0, 1);
    });
    
    //Registering new role
    $permissions->addRole('admin');
    $permissions->addRole('user');
    
    $permissions->associate('admin', 'post.*', GuardInterface::ALLOW);
    
    //RuleInterface classes can be assigned directly, bypassing rule registration
    $permissions->associate('user', 'post.(save|edit)', AuthorRule::class);
    
    //Via rule name
    $permissions->associate('user', 'post.view', 'custom-rule');
}
```

Where AuthorRule is:

```php
class AuthorRule extends Rule
{
    protected function check(User $user, Post $post)
    {
        return $post->author_id == $user->id;
    }
}
```

To start using security component simply make sure that `Spiral\Security\ActorInterface` is pointing
to an active user:

```php
interface ActorInterface
{
    /**
     * Method must return list of roles associated with current actor is a form of array.
     *
     * @return array
     */
    public function getRoles();
}
```

```php
$this->container->set(ActorInterface::class, new Actor(['user']);
```

Usage in code:

```php
public function indexAction(GuardInterface $guard)
{
    dump($guard->allows('post.update', ['post' => 'POST OBJECT']));
}
```

You can also use `GuardedTrait` or `AuthorizesTrait` for controllers.

```php
public function indexAction()
{
    //Throws Forbidden exception
    $this->authorize('post.update', ['post' => 'POST OBJECT']);
}
```

You can also change guard actor in runtime (for example for testing):

```php
public function indexAction(GuardInterface $guard)
{
    //New guard instance are created via withActor method
    $guard = $guard->withActor(new Actor(['admin']));

    dump($guard->allows('post.update', ['post' => 'POST OBJECT']));
}
```

Installation
------------
Execute following commands to install security component into your application:

```
composer require spiral/security
```

Once downloaded you can register module configuration:

```
spiral register spiral/security
```

Once module registered simply add SecurityBootloader into your application:

```php
protected $load = [
    //...
    
    SecurityBootloader::class,
    
    //...
];
```

Do not forget to add `app/config/modules/security.php` into your git repository.

> More documentation is coming.

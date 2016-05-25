UserBundle
===========

UserBundle 基于 friendsofsymfony/user-bundle 进行整合管理用户
重写用户登陆、注册、资料
用户、用户组管理

介绍
------------

### Composer

添加 `composer.json` 到你的项目依赖
```json
{
    "foreverglory/user-bundle": "~0.1"
}
```
### Kernel

添加 `Kernel` 依赖，并启用 `Bundle`
```php
//app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new FOS\UserBundle\FOSUserBundle(),
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Glory\Bundle\UserBundle\GloryUserBundle(),
        // ...
    );
}
```

### Conﬁgure
```yaml
#app/conﬁg/conﬁg.yml
fos_user:
    db_driver: orm
    # 对应 security.firewalls 值
    firewall_name: main
    user_class: Glory\Bundle\UserBundle\Entity\User
    group:
        group_class: Glory\Bundle\UserBundle\Entity\Group
    # 更多配置，参考 `friendsofsymfony/user-bundle`

glory_user:
    # 未实现

```

```yaml
#app/config/routing.yml
glory_user:
    resource: "@GloryUserBundle/Resources/config/routing.yml"
    prefix:   /
# 警告 不需要引用 `friendsofsymfony/user-bundle` 的路由配置
```

```yaml
#app/config/security.yml
security:
    encoders:
        FOS\UserBundle\Model\UserInterface: sha256

    providers:
        fos_user:
            id: fos_user.user_provider.username

    firewalls:
        # fos_user.firewall_name, hwi_oauth.firewall_name 对应值
        main:
            pattern:    /.*
            form_login:
                # 对应其中一个 security.providers
                provider: fos_user
                # 登录地址，不要修改
                login_path: glory_user_login
                # 登录验证
                check_path: glory_user_check
                #...more...
            remember_me:
                key: "%secret%"
                lifetime: 31536000
                path: /
                domain: ~
            logout:
                # 退出地址
                path: glory_user_logout 
            anonymous:    true
```
### Code
extends Glory\Bundle\UserBundle\Entity\AbstractUser

extends Glory\Bundle\UserBundle\Entity\AbstractGroup

More
------------
todo:

UserBundle
===========

UserBundle 基于 friendsofsymfony/user-bundle 及 hwi/oauth-bundle 进行整合用户
重写用户登陆、注册、绑定
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
        new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
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

hwi_oauth:
    # 对应 security.firewalls
    firewall_name: main
    # 记录跳转位置
    use_referer: true
    connect:
    resource_owners:
        qq:
            type:                qq
            client_id:           <client_id>
            client_secret:       <client_secret>
        wechat:
            type: wechat
            client_id: <client_id>
            client_secret: <client_secret>
            # 微信必须增加 下一行
            scope: snsapi_userinfo
        # 更多第三方登陆设置
    # 警告 不要设置 fosub 属性，否则不能正常登录
    # 更多配置，参考 `hwi/oauth-bundle`

glory_user:
    # 未实现

```

```yaml
#app/config/routing.yml
glory_user:
    resource: "@GloryUserBundle/Resources/config/routing.yml"
    prefix:   /
# 警告 不需要引用 `friendsofsymfony/user-bundle` 和 `hwi/oauth-bundle` 的路由配置
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
            oauth:
                resource_owners:
                    # 配置第三方登录，回调地址。（路由不需要 controller）
                    qq: /connect/qq/callback
                    #wechat: /connect/wechat/callback
                    #my_custom_provider: /connect/custom/callback
                # 登录地址，直接来源于 glory_user_login
                login_path:        glory_user_login
                # 登录失败，错误信息（包括未绑定），未绑定，则跳转到第三方进行绑定（创建新用户 or 绑定老用户），请谨慎修改
                failure_path:      glory_user_oauth
                # 进行第三方登录验证，请谨慎修改
                oauth_user_provider: 
                    service: glory.user.security.provider.oauth_user    
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

More
------------
todo:
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
    firewall_name: main # 对应 security.firewalls 值
    user_class: Glory\Bundle\UserBundle\Entity\User
    group:
        group_class: Glory\Bundle\UserBundle\Entity\Group
    # 更多配置，参考 `friendsofsymfony/user-bundle`

hwi_oauth:
    firewall_name: main # 对应 security.firewalls
    connect: true
    resource_owners:
        qq:
            type:                qq
            client_id:           <client_id>
            client_secret:       <client_secret>
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
        main:   # fos_user.firewall_name, hwi_oauth.firewall_name 对应值
            pattern:    /.*
            form_login:     # 表单登录
                provider: fos_user      # 对应其中一个 security.providers
                login_path:             glory_user_login    # 登录地址，不要修改
                check_path:             glory_user_check    # 登录验证，不要个性
                target_path_parameter:  goto                # 登录成功跳转 login?goto=/admin 通过获取 goto，登陆成功跳转到目标地址
                #csrf_provider:         form.csrf_provider
                #csrf_token_generator:  security.csrf.token_manager
                failure_handler: glory.user.security.handler.login_failure  # 登录失败执行，增加 ajax 请求 返回 json
                success_handler: glory.user.security.handler.login_success  # 登录成功执行
            oauth:
                resource_owners:
                    qq:     qq_callback         # 配置第三方登录，回调地址。（路由不需要 controller）
#                    google:             "/connect/check-google"
#                    my_custom_provider: "/connect/check-custom"
                login_path:        glory_user_oauth     # 登录地址，默认访问，将跳转到 glory_user_login，登录成功，进行自动登录
                failure_path:      glory_user_oauth     # 登录失败，错误信息（包括未绑定），未绑定，则跳转到第三方绑定进行绑定，其它错误，跳转回 glory_user_login 显示错误
                oauth_user_provider: 
                    service: glory.user.security.provider.oauth_user    # 进行第三方登录验证，请谨慎修改
            remember_me:
                key: "%secret%"
                lifetime: 31536000
                path: /
                domain: ~
            logout:
                path: glory_user_logout # 退出地址
                success_handler: glory.user.security.handler.logout_success # 退出成功执行
            anonymous:    true
```

More
------------
todo:
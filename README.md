# webman admin插件

## jwt

修改`config\plugin\tinywan\jwt\app.php

```
'user_model' => function($uid){
    return \Jyil\WebmanAdmin\Model\User::find($uid);
},
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="/App/views/static/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/App/views/static/css/public.css">
</head>
<body>
<div class="main" style="width: 500px;margin: 0 auto;">
    <form action="index.php?m=user&a=register" method="post" id="regForm">
    <table style="align-items: center">
        <tbody>
        <tr>
            <td colspan="2" align="center">注册页</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>用户名：</td>
            <td><input type="text" name="user_name"></td>
            <td><em class="hide">ss</em></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="password"></td>
            <td><em class="hide">ss</em></td>
        </tr>
        <tr>
            <td>确认密码：</td>
            <td><input type="password" name="rePassword"></td>
            <td><em class="hide">ss</em></td>
        </tr>
        <tr>
            <td>邮箱：</td>
            <td><input type="text" name="email"></td>
            <td><em class="hide">ss</em></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="checkbox" class="is_accept">我已阅读并且同意</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="button" id="submitReg" value="注册"></td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
    </form>
</div>
</body>
<script type="text/javascript" src="/App/views/static/js/reg.js"></script>
</html>
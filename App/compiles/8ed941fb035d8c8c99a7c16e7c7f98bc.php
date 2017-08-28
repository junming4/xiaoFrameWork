<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户信息修改</title>
    <script type="text/javascript" src="/App/views/static/js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="/App/views/static/css/public.css">
    <script src="/App/views/static/js/laydate/laydate.js"></script>
    <script src="/App/views/static/js/city.js"></script>
</head>
<body>
<div class="main" style="width: 500px;margin: 0 auto;">
        <table style="align-items: center">
            <tbody>
            <tr>
                <td colspan="2" align="center">修改账户资料</td>
            </tr>
            <tr>
                <td>用户名：</td>
                <td><input type="text" name="username" value="<?php echo $this->tpl_vars['user_name']; ?>" disabled></td>
            </tr>
            <tr>
                <td>昵称：</td>
                <td><input type="text" name="nick_name" value="<?php echo $this->tpl_vars['nick_name']; ?>"></td>
            </tr>
            <tr>
                <td>真实姓名：</td>
                <td><input type="text" name="real_name" value="<?php echo $this->tpl_vars['real_name']; ?>"></td>
            </tr>
            <tr>
                <td>性别：</td>
                <td>
                    <input type="radio" name="sex" value="0" <?php echo $this->tpl_vars['radio0']; ?>>保密&nbsp;
                    <input type="radio" name="sex" value="1" <?php echo $this->tpl_vars['radio1']; ?>>男&nbsp;
                    <input type="radio" name="sex" value="2" <?php echo $this->tpl_vars['radio2']; ?>>女
                </td>
            </tr>
            <tr>
                <td>家乡:</td>
                <td>
                    省：<select name="province" id="province" data-old="<?php echo $this->tpl_vars['province']; ?>"></select>
                    市：<select name="city" id="city" data-old="<?php echo $this->tpl_vars['city']; ?>"></select>
                </td>
            </tr>
            <tr>
                <td>生日:</td>
                <td><input type="text" class="laydate-icon"  id="birth" value="<?php echo $this->tpl_vars['birthday']; ?>"></td>
            </tr>
            <tr>
                <td>爱好:</td>
                <td>
                    <?php echo $this->tpl_vars['hobby_str']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="button" id="submitReg" value="保存修改"></td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" name="id" id="user_id" value="<?php echo $this->tpl_vars['user_id']; ?>">
</div>
</body>

<script type="text/javascript" src="/App/views/static/js/user_edit.js"></script>
</html>
<?php
/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 上午11:16
 * Desc: 用户控制类
 */

namespace App\Controller;

use App\Models\User;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->display('index.html');
    }

    /**
     *注册页
     */
    public function reg()
    {
        $this->display('reg.html');
    }


    /**
     *检验用户名是否可用
     */
    public function checkUserName()
    {
        $user_name = trim($this->input('user_name'));
        if (strlen($user_name) < 1) {
            $this->jsonEnCode(['code' => 0, 'msg' => '用户名不能为空！']);
        }
        $userObj = new User();
        $res = $userObj->getUserInfoByIdOrOther($user_name, 1, 'user_id');

        if (!empty($res)) {
            $this->jsonEnCode(['code' => 0, 'msg' => '用户名已经被占用了！']);
        }
        $this->jsonEnCode(['code' => 1, 'msg' => '用户名可用！']);

    }

    /**
     *邮箱校验
     */
    public function checkEmail()
    {
        $email = trim($this->input('email'));
        if (strlen($email) < 1) {
            $this->jsonEnCode(['code' => 0, 'msg' => '邮箱不能为空']);
        }
        if (!checkEmail($email)) {
            $this->jsonEnCode(['code' => 0, 'msg' => '邮箱格式不正确！']);
        }
        $userObj = new User();
        $res = $userObj->getUserInfoByIdOrOther($email, 2, 'user_id');
        if (!empty($res)) {
            $this->jsonEnCode(['code' => 0, 'msg' => '该邮箱已经被占用了！']);
        }
        $this->jsonEnCode(['code' => 1, 'msg' => '邮箱可用！']);
    }

    /**
     * 开始注册
     */
    public function register()
    {
        $data = $this->registerVerify();
        $code = (int)$data['code'];
        if ($code < 1) {
            $this->alertMsg($data['msg']);
        }
        //获取返回得数据
        $info = $data['data'];
        $userObj = new User();
        $res = (int)$userObj->insetInfo($info);
        if ($res > 0) {
            $this->alertMsg('注册用户成功！');
        }
        $this->alertMsg('注册数据失败！');
    }

    /**
     * js 提示
     * @param $msg
     * @param string $url
     */
    private function alertMsg($msg, $url = '')
    {
        echo "<script type='text/javascript'>parent.alert('" . $msg . "');";
        if (strlen($url) > 0) {
            echo "location.href='" . $url . "'";
        } else {
            echo "history.back()";
        }
        echo "</script>";
        exit;
    }

    /**
     *修改用户信息
     */
    public function edit()
    {
        $user_id = (int)$this->input('user_id') ? (int)$this->input('user_id') : 0;

        //跳转地址
        $url = 'index.php?m=user&a=index';

        $field = 'user_id,user_name,nick_name,real_name,email,sex,birthday,province,city,hobby';

        $userObj = new User();

        $userInfo = $userObj->getUserInfoByIdOrOther($user_id, 0, $field);

        if (empty($userInfo)) $this->alertMsg('不存在该用户！', $url);

        $selectSex = [
            'radio0' => '',
            'radio1' => '',
            'radio2' => '',
        ];

        $selectSex['radio' . $userInfo['sex']] = 'checked';

        //爱好部分处理
        $hobbies = $userObj->allHobbies;
        $hobby = strlen($userInfo['hobby']) > 0 ? explode(',', trim($userInfo['hobby'])) : [];
        $hobby_str = '';
        foreach ($hobbies as $key => $val) {
            $select = '';
            if (in_array($val['id'], $hobby)) $select = 'checked';
            $hobby_str .= '<input class="hobby_checkbox" type="checkbox" name="hobby" value="' . $val['id'] . '" ' . $select . '>' . $val['name'];
        }

        $userInfo['hobby_str'] = $hobby_str;

        $this->assign($userInfo);
        $this->assign($selectSex);

        $this->display('user_edit.html');
    }

    /**
     *更新数据
     */
    public function update()
    {
        $user_id = (int)$this->input('user_id');
        if ($user_id < 1) $this->jsonEnCode(['code' => 0, 'msg' => '你非法操作！']);
        $userObj = new User();
        $res = $userObj->getUserInfoByIdOrOther($user_id, 0, 'user_id');
        if (empty($res)) $this->jsonEnCode(['code' => 0, 'msg' => '该用户可能已经删除了！']);

        $data = $this->updateVerify();
        $code = (int)$data['code'];
        if ($code < 1) {
            $this->alertMsg($data['msg']);
        }
        $info = $data['data'];
        $res = $userObj->updateInfo($user_id, $info);
        if (empty($res)) {
            $this->jsonEnCode(['code' => 0, 'msg' => '修改失败！']);
        }
        $this->jsonEnCode(['code' => 1, 'msg' => '修改成功！']);
    }


    /**
     * todo 这里好多 return 是否可以优化？？？
     * 注册验证
     * @return array
     */
    private function registerVerify()
    {
        $user_name = trim($this->input('user_name'));
        $password = $this->input('password');
        $rePassword = $this->input('rePassword');
        $email = trim($this->input('email'));

        //自定义返回数组
        $returnData = ['code' => 0, 'msg' => 'error'];

        if (strlen($user_name) < 1) {
            $returnData['msg'] = '用户名不能为空!';
            return $returnData;
        }
        $userNameLength = mb_strlen($user_name, 'utf-8');
        if ($userNameLength < 4 || $userNameLength > 25) {
            $returnData['msg'] = '用户名长度不符合要求!';
        }
        if (strlen($password) < 1) {
            $returnData['msg'] = '密码不能为空！';
            return $returnData;
        }
        $passwordLength = mb_strlen($password, 'utf-8');
        if ($passwordLength < 6 || $passwordLength > 20) {
            $returnData['msg'] = '密码不符合要求!';
            return $returnData;
        }

        if ($password != $rePassword) {
            $returnData['msg'] = '两次密码不相同！';
            return $returnData;
        }
        if (strlen($email) < 1) {
            $returnData['msg'] = '邮箱不能为空！';
            return $returnData;
        }
        if (!checkEmail($email)) {
            $returnData['msg'] = '邮箱格式非法！';
            return $returnData;
        }
        $userObj = new User();
        $userInfo = $userObj->getUserInfoByIdOrOther($user_name, 1, 'user_id');
        if (!empty($userInfo)) {
            $returnData['msg'] = '用户名已经被占用了！';
            return $returnData;
        }
        $emailInfo = $userObj->getUserInfoByIdOrOther($email, 2, 'user_id');
        if (!empty($emailInfo)) {
            $returnData['msg'] = '邮箱已经被占用了！';
            return $returnData;
        }
        $returnData = [
            'code' => 1,
            'msg' => '验证成功！',
            'data' => [
                'user_name' => $user_name,
                'password' => md5($password), //todo 这里使用md5 加密是为了方便，安全性是不够的
                'email' => $email,
                'create_time' => time()
            ]
        ];
        return $returnData;
    }

    /**
     * 更新验证
     * @return array
     */
    public function updateVerify()
    {
        $nick_name = trim($this->input('nick_name'));
        $real_name = trim($this->input('real_name'));
        $sex = (int)$this->input('sex');
        $province = trim($this->input('province'));
        $city = trim($this->input('city'));
        $hobby = $this->input('hobby');
        $birthday = trim($this->input('birthday'));

        //自定义返回数组
        $returnData = ['code' => 0, 'msg' => 'error'];

        if (is_array($hobby)) $hobby = @implode(',', $hobby);

        //整个数据验证
        if (strlen($nick_name) < 1 || strlen($real_name) < 1 || strlen($province) < 1 || strlen($city) < 1
            || strlen($hobby) < 1 || strlen($birthday) < 1
        ) {
            $returnData['msg'] = '请把数据填写完整再提交！';
            return $returnData;
        }

        if (date('Y-m-d', strtotime($birthday)) != $birthday) {
            $returnData['msg'] = '生日非法！';
            return $returnData;
        }

        $returnData = [
            'code' => 1,
            'msg' => '验证成功！',
            'data' => [
                'nick_name' => $nick_name,
                'real_name' => $real_name,
                'sex' => $sex,
                'province' => $province,
                'city' => $city,
                'hobby' => trim($hobby),
                'birthday' => $birthday
            ]
        ];
        return $returnData;
    }

}
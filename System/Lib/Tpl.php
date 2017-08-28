<?php
/*/**
 * Email: 2284876299@qq.com
 * User: XiaoJm
 * Date: 2017/5/15
 * Time: 下午11:44
 * Desc: 类简单描述一下
 */

namespace System\Lib;


class Tpl
{
    //模板文件存放位置
    private $template_dir = ROOT_PATH . '/App/views';

    //编译文件存放位置
    private $compile_dir = ROOT_PATH . '/App/compiles';

    //左定界符
    private $left_delimiter = '{';

    //右定界符
    private $right_delimiter = '}';

    //内部临时变量，存储用户赋值
    private $tpl_vars = array();

    //错误信息
    private $errorMessage = '';

    /**
     * 修改类属性的值
     * @param array $configs 需要修改的相关属性及值
     * @return bool
     */
    public function setConfigs(array $configs)
    {
        if (count($configs) > 0) {
            foreach ($configs as $k => $v) {
                if (isset($this->$k))
                    $this->$k = $v;
            }
            return true;
        }
        return false;
    }

    /**
     * 模板赋值操作
     * @param mixed $tpl_var 如果是字符串,就作为数组索引,如果是数组，就循环赋值
     * @param mixed $tpl_value 当$tpl_var为string时的值,默认为 null
     */
    public function assign($tpl_var, $tpl_value = null)
    {
        if (is_array($tpl_var) && count($tpl_var) > 0) {
            foreach ($tpl_var as $k => $v) {
                $this->tpl_vars[$k] = $v;
            }
        } elseif ($tpl_var) {
            $this->tpl_vars[$tpl_var] = $tpl_value;
        }
    }

    /**
     * 生成编译文件
     * @param string $tplFile 模板路径
     * @param string $comFile 编译路径
     * @return string
     */
    private function fetch($tplFile, $comFile)
    {

        //判断编译文件是否需要重新生成(编译文件是否存在或者模板文件修改时间大于编译文件的修改时间)
        if (!file_exists($comFile) || filemtime($tplFile) > filemtime($comFile)) {
            //编译,此处也可以使用ob_start()进行静态化
            $content = $this->tplReplace(file_get_contents($tplFile));
            file_put_contents($comFile, $content);
        }

    }

    /**
     * 编译文件
     * @param string $content 待编译的内容
     * @return string
     */
    private function tplReplace($content)
    {
        //转义左右定界符 正则表达式字符
        $left = preg_quote($this->left_delimiter, '/');
        $right = preg_quote($this->right_delimiter, '/');

        //简单模拟编译 变量
        $pattern = array(
            //例如{$test}
            '/' . $left . '\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)' . $right . '/i'
        );

        $replace = array(
            '<?php echo $this->tpl_vars[\'${1}\']; ?>'
        );

        //正则处理
        return preg_replace($pattern, $replace, $content);
    }

    /**
     * 输出内容
     * @param string $fileName 模板文件名
     */
    public function display($fileName)
    {
        //模板路径
        $tplFile = $this->template_dir . '/' . $fileName;

        //判断模板是否存在
        if (!file_exists($tplFile)) {
            $this->errorMessage = '模板文件不存在';
            return false;
        }

        //编译后的文件
        $comFile = $this->compile_dir . '/' . md5($fileName) . '.php';

        $this->fetch($tplFile, $comFile);
        include $comFile;
    }
}

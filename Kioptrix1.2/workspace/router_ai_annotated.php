<?php
/**
 * GPL v4 
 * LotusCMS 2010.
 * Written by Kevin Bluett
 * 这个类负责将外部请求路由到 LotusCMS 系统内部的对应模块中。
 */
class Router{

        /**
         * 路由主控函数：负责获取用户传入的参数，并决定如何调用对应的插件或页面。
         */
        public function Router(){
                // 【接收逻辑 1】尝试获取名为 'page' 的参数，如果没传，默认值为 "index"
                // 最终取得的值赋给变量 $page
                $page = $this->getInputString("page", "index");

                // 【接收逻辑 2】尝试获取名为 'system' 的参数，如果没传，默认值为 "Page"
                // 最终取得的值赋给变量 $plugin
                $plugin = $this->getInputString("system", "Page");

                // 【判断逻辑 1】检查系统指定目录下，是否存在名为 "$plugin" + "Starter.php" 的文件
                // 假设用户传入 system=Page（或者默认没传），这里就会去检查 "core/plugs/PageStarter.php" 是否存在
                if(file_exists("core/plugs/".$plugin."Starter.php")){
                        // 包含（加载）这个对应的文件
                        include("core/plugs/".$plugin."Starter.php");

                        // 【！！！核心漏洞触发点！！！】
                        // 【开发者的原本意图（为什么用 eval 读取页面）】：
                        // 这是一个基于插件（Plugin）的架构。开发者希望根据用户传入的 system 参数，
                        // “动态”地去实例化对应的插件类，并把 page 参数传给这个类的构造函数去渲染页面。
                        //
                        // 例如正常业务逻辑下：
                        // 1. 如果用户请求 system=Page&page=about，
                        //    开发者希望能动态执行： new PageStarter('about'); （实例化页面加载器去读取 about 页面）
                        // 2. 如果用户请求 system=Blog&page=article1，
                        //    开发者希望能动态执行： new BlogStarter('article1'); （实例化博客加载器去读取 article1）
                        // 
                        // 为了实现这种“动态类名实例化”，早期的 PHP 开发者（或技术较菜的开发者）
                        // 选择了偷懒的做法：直接用 eval() 将字符串拼接成 PHP 代码来执行。
                        //
                        // 正常情况下，PHP 本身是支持动态类名的（例如 $cls="PageStarter"; new $cls($page); ），
                        // 完全不需要用 eval()。开发者在这里乱用 eval() 是导致灾难的根源。
                        //
                        // 【攻击利用回顾】：
                        // 正因为拼接了代码： eval("new ".$plugin."Starter('".$page."');");
                        // 我们只要让 $page = "index'); phpinfo(); //"
                        // 最终在服务器执行的就是： new PageStarter('index'); phpinfo(); //');
                        // 成功绕过了原本读取页面的逻辑，执行了系统命令。
                        eval("new ".$plugin."Starter('".$page."');");
                        // eval("new ".$plugin."Starter('".index');${passthru('id')};//."');");

                // 【判断逻辑 2】如果上面的插件路径没找到，就去另一个 data/modules/ 目录下寻找
                }else if(file_exists("data/modules/".$plugin."/starter.dat")){
                        // 包含模块加载器系统
                        include("core/lib/ModuleLoader.php");

                        // 实例化模块加载器，传入插件名，并再次使用 getInputString 获取 'page' 参数
                        // （这里正常传参，没有用 eval，所以这部分是安全的）
                        new ModuleLoader($plugin, $this->getInputString("page", null));
                
                // 【判断逻辑 3】如果前面都没找到匹配的，默认按照常规页面处理
                }else{ //Otherwise load a page from the standard system.
                        // 包含默认的 PageStarter.php
                        include("core/plugs/PageStarter.php");

                        // 实例化页面加载器
                        // （这里也是正常传参，没有 eval()，同样安全）
                        new PageStarter($page);
                }
        }

        /**
         * 获取用户输入的函数：负责从超全局变量中提取参数并做初步过滤。
         * 这就是整个系统的【底层接收逻辑】。
         */
        protected function getInputString($name, $default_value = "", $format = "GPCS")
        {
                // 定义了一个数组，用来将字母缩写映射到 PHP 真实的超全局变量上
                // G = $_GET, P = $_POST, C = $_COOKIE, S = $_SESSION, R = $_REQUEST, F = $_FILES
                $format_defines = array (
                'G'=>'_GET',
                'P'=>'_POST',
                'C'=>'_COOKIE',
                'S'=>'_SESSION',
                'R'=>'_REQUEST',
                'F'=>'_FILES',
                );
                
                // 正则匹配出 format 参数中定义的字母（默认格式 "GPCS" 会匹配出 G、P、C、S）
                preg_match_all("/[G|P|C|S|R|F]/", $format, $matches); 
                
                // 按照匹配到的顺序遍历（默认顺序：GET -> POST -> COOKIE -> SESSION）
                foreach ($matches[0] as $k=>$glb)
                {
                    // 检查对应的超全局变量中，是否存在用户请求的参数名（比如 $name 为 "page"）
                    // 举例：如果是 GET 请求且 URL 中有 ?page=xxx，这里的 $_GET['page'] 就会判定为真
                    if ( isset ($GLOBALS[$format_defines[$glb]][$name]))
                    {   
                        // 如果找到了该参数，先用 trim() 去除两端空白字符
                        //
                        // 【！！！导致漏洞的关键原因：不当的过滤！！！】
                        // 然后使用了 htmlentities() 将特殊字符转换为 HTML 实体。
                        // 但是，它加了一个参数：ENT_NOQUOTES。
                        // 这个参数在 PHP 中的明确含义是：既不转义双引号(")，也不转义单引号(')！
                        //
                        // 也就是说，如果用户传入的值是  '); phpinfo(); // 
                        // 经过这个函数过滤后，返回值依然是原封不动的： '); phpinfo(); //
                        // 这直接使得上面的 eval() 拼接漏洞可以被完美利用。
                        return htmlentities ( trim ( $GLOBALS[$format_defines[$glb]][$name] ) , ENT_NOQUOTES ) ;
                    }
                }
                
                // 如果在所有定义的来源里都没找到该参数，则返回设定好的默认值（例如 "index"）
                return $default_value;
        } 

}
?>

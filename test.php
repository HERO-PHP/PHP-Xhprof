<?php

    header("Content-type: text/html; charset=utf-8");
    
    function foo()
    {
        for($i=0;$i<10000;$i++){
            //echo $i." <br/> ";
        }
    }

    function foo2(){
        $starttime = explode(' ',microtime());
        echo microtime() , " <br/> <br/> <br/>";

        foo();

        $endtime = explode(' ',microtime());
        $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
        $thistime = round($thistime,3);
        echo "About：".$thistime." S.";

    }

    // cpu:XHPROF_FLAGS_CPU 内存:XHPROF_FLAGS_MEMORY
    // 如果两个一起：XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY 
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    //xhprof_enable();
    
    foo();
    foo2();
    
    $data = xhprof_disable();   //返回运行数据
    // xhprof_lib在下载的包里存在这个目录,记得将目录包含到运行的php代码中
    include_once "xhprof_lib/utils/xhprof_lib.php";  
    include_once "xhprof_lib/utils/xhprof_runs.php";
    $objXhprofRun = new XHProfRuns_Default();
    // 第一个参数j是xhprof_disable()函数返回的运行信息
    // 第二个参数是自定义的命名空间字符串(任意字符串),
    // 返回运行ID,用这个ID查看相关的运行结果
    $run_id = $objXhprofRun->save_run($data, "xhprof");
    $url = "http://localhost/PHP-Xhprof/xhprof_html/index.php?run=$run_id&source=xhprof";
    echo "<a href='".$url."' target='_blank'>".$url."</a>";

?>

<?php

    header("Content-type: text/html; charset=utf-8");
    
    function foo()
    {
        for($i=0;$i<10000;$i++){
            //echo $i." <br/> ";
        }
    }

    function foo2(){
        
        $starttime  = explode(' ',microtime());
        foo();
        $endtime    = explode(' ',microtime());
        $thistime   = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
        $thistime   = round($thistime,6);
        
        echo "foo2 about：".$thistime." S. <br/> <br/> <br/>";
    }

    /*
     *  Start xhprof performance analyzer
     *  cpu:XHPROF_FLAGS_CPU     Memory:XHPROF_FLAGS_MEMORY
     *  cpu + memory ： XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY 
     */
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    //xhprof_enable();
    
    foo();
    foo2();
    
    $data           = xhprof_disable();   //Stop performance analysis and return the xhprof data for this operation
    
    include_once "xhprof_lib/utils/xhprof_lib.php";  
    include_once "xhprof_lib/utils/xhprof_runs.php";
    
    $objXhprofRun   = new XHProfRuns_Default();
    
    /*
     * First parameter : xhprof_disable()   Return result
     * Second parameters ： Custom namespace strings (arbitrary string)
     */
    $run_id         = $objXhprofRun->save_run($data, "xhprof");
    $url            = "http://localhost/PHP-Xhprof/xhprof_html/index.php?run=$run_id&source=xhprof";
    echo "<a href='".$url."' target='_blank'>".$url."</a>";

?>

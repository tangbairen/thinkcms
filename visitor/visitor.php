<?php
    header('Content-type:text/html;charset=utf-8');
//    error_reporting(0);
    require('./Visitor.class.php');

    $content='%7B%22message%22%3A%5B%7B%22worker_name%22%3A%22%22%2C%22company_id%22%3A%2272133840%22%2C%22msg_type%22%3A%22p%22%2C%22id6d%22%3A%2210224973%22%2C%22talk_id%22%3A%2286448938106%22%2C%22worker_id%22%3A%22bote53kf07%40163.com%22%2C%22msg%22%3A%22%3Cp+class%3D%5C%22lmsg_color%5C%22%3E%3Cspan+style%3D%5C%22color%3A%23000000%3Bbackground-color%3A+rgb%28241%2C+248%2C+249%29%3B%5C%22%3E%E6%82%A8%E5%A5%BD%EF%BC%8C%E6%82%A8%3Cspan+style%3D%5C%22font-size%3A18px%3Bcolor%3A%23ff0000%3B%5C%22%3E%3Cstrong%3E%E7%94%B5%E8%AF%9D%E5%A4%9A%E5%B0%91%3C%5C%2Fstrong%3E%3C%5C%2Fspan%3E%E5%91%A2%EF%BC%9F%E6%88%91%E4%BB%AC%E6%8A%8A%E5%85%AC%E5%8F%B8%E7%9A%84%E6%8A%95%E8%B5%84%E8%B4%B9%E7%94%A8%2C%E7%9B%88%E5%88%A9%E5%88%86%E6%9E%90%2C%E4%BC%98%E6%83%A0%E6%94%BF%E7%AD%96%E3%80%81%E8%80%83%E5%AF%9F%E5%8A%A0%E7%9B%9F%E6%B5%81%E7%A8%8B%E5%8F%91%E7%BB%99%E6%82%A8%EF%BC%8C%E6%82%A8%E5%85%88%E5%8F%82%E8%80%83%E4%BA%86%E8%A7%A3%E4%B8%80%E4%B8%8B%3C%5C%2Fspan%3E%3C%5C%2Fp%3E%22%2C%22msg_time%22%3A%2220171017144324%22%7D%5D%2C%22session%22%3A%7B%22kw%22%3A%22%E4%B8%80%E7%82%B9%E7%82%B9%E5%A5%B6%E8%8C%B6%E5%8A%A0%E7%9B%9F%22%2C%22company_id%22%3A%2272133840%22%2C%22guest_area%22%3A%22%E6%B5%99%E6%B1%9F%E7%9C%81%E6%9D%AD%E5%B7%9E%E5%B8%82%28%E7%A7%BB%E5%8A%A8%E6%89%8B%E6%9C%BA%E5%8D%A1%E4%B8%8A%E7%BD%91%E5%85%A8%E7%9C%81%E5%85%B1%E7%94%A8%E5%87%BA%E5%8F%A3%29%5B%E7%A7%BB%E9%80%9A%5D%22%2C%22land_page%22%3A%22http%3A%2F%2Fs3baidu.188bbq.com%2Fydd2-wap%2F%3Fbdclickid%3Dbdmo_003665%26keyword%3D%25E4%25B8%2580%25E7%2582%25B9%25E7%2582%25B9%25E5%25A5%25B6%25E8%258C%25B6%25E5%258A%25A0%25E7%259B%259F%26semk%3D59194433399%26semc%3D15374398779%26semm%3D2%26semp%3Dmt2%26sema%3Dbj%26semd%3Dmo%22%2C%22guest_id%22%3A%22105448158415%22%2C%22talk_id%22%3A%2286448938106%22%2C%22id6d%22%3A%2210224973%22%2C%22guest_ip%22%3A%22112.17.245.54%22%2C%22se%22%3A%22%E6%89%8B%E6%9C%BA%E7%99%BE%E5%BA%A6%22%2C%22worker_name%22%3Anull%2C%22talk_type%22%3A%225%22%2C%22talk_page%22%3A%22http%3A%2F%2Fs3baidu.188bbq.com%2Fydd2-wap%2F%3Fbdclickid%3Dbdmo_003665%26keyword%3D%25E4%25B8%2580%25E7%2582%25B9%25E7%2582%25B9%25E5%25A5%25B6%25E8%258C%25B6%25E5%258A%25A0%25E7%259B%259F%26semk%3D59194433399%26semc%3D15374398779%26semm%3D2%26semp%3Dmt2%26sema%3Dbj%26semd%3Dmo%22%2C%22device%22%3A%222%22%2C%22referer%22%3A%22https%3A%2F%2Fm.baidu.com%2Fbaidu.php%3Fsc.af0000a-KmSQQXy7vZWjISzMACH4gkaN_pNRqfT7gruDKV4DjZ0yJPezSlNiLLldkU5wFXkjUNqRirjV54O1hKYMX6X-CwcNLivYt4m1iZupyMQT9Fxhbl4q0F2WUbxdobKM8icxDa0mKnDJrUQFT0a0S29vdy9fL_JQlPnnxaG2H23kds.DD_iwtUvTyjzovUQeOmBjwIIb1tjrrjExIjwxjv3hQeVQ8yz1WYqreovGYTjGohn5Mvmxgu9vymx5ksenhZdL3x5ksenhZdL3x5I9q8ejlqrZ1vmIMs3xgGsSXej_q8Zvvmx5kseOgjESEyPrMVmLUlqOuvTX5ZxElkGYs_Ne85WvTIS1ktIOyPrMikblkGY3vPPjFdWHGumEzqmYlUhPQ-Bmuk33ljGbtEKA_nYQZZI83tN.U1Yz0ZDqYo8d3egWknzzlQ1Hst_0mywkXHLD1QQCYo8d3egWEP5jzexw0A7bTgfqn6KlTA3qPj0sQHT4riY4n1fd0ZKGm1Yk0ZfqYo8d3egWknzzlQ1Hst_0pyYqnWcz0ATqIvNsT100Iybq0ZKGujY1n6KWpyfqnWTv0AdY5HDsnHIxnH0krNt1nHf4g1nvnjD0pvbqn0KzIjYznHD0uy-b5HDsnWRLnNtknHfdPHFxnHD4Pj61g1DkrHcdPNtknjcYn1FxnH0snjb3g1DkrHR4PNtknHbkn1IxnH0Ln1Dzg1DkrH0zP7tknHbsPjNxnHD3rj6zg1Dkrj6LPNtknH63PjPxnHD3rjD3g1DkrjT4nfKBpHYznjuxnW0snj7xnW0sn1D0UynqPWTLn1c1PWnzg1mLP16YPWRzP7tknjFxn0KkTA-b5H00TyPGujYs0ZFMIA7M5H00ULu_5HDsnjRkQywlg1DsnjRYQHwxnH0srjfVuZGxnH0kn1nVn-tknjc3radbX-tknjfLPiYzg1DsPHm4QH7xnH0vnj6VuZGxnH04rjfVuZGxnHDsnjcVnNtknH0YnaYzg1Dknjf1QH7xnHDknWmVuZGxnHDknWbVuZGxnHDznW0VnNtknHTzradbX-tknHTvradbX-tknHb1nzdbX-tknW0VuZGxnHcsPWRVuZGxnHcsrH6Vr7tknWD1PiY1g1DznBYzg1DzPj01Qywlg1DzPHD3Qywlg1DzPWnvQH7xnHcLrHTVuZGxnHc3PWnVuZGxnHc4PWfVuZGxnHnsrj0VnNtkn1D3riYkg1D1nWRYQywlg1D1nWRvQH7xnHn1njcVn-tkn1nznzdbX-tkn1fsnzYkg1D1PH0sQHFxnHndPWnVnNtkn1m3PzYvg1D1rjmYQHFxnHn4njRVuZGxnHfsP1fVuZGxnHfknWDVndtkPjcsnzdbX-tkPjnkraYkg1DYn1fLQywlg1DYn1bYQH7xnHfYrjcVn-tkPjR4nBYkg1DYPWnzQH7xnHfvPjcVP7tkPjmYPzdbX-tkPjTkraYkg1DYP1n4Qywlg1DYrj04Qywlg1DYrjc1Qywlg1DYrjTYQH7xnHf3P1mVnNtkPj64nzYkg1DYrH0sQywlg1DYrHD1Qywlg1DYrHfdQH7xnHf4P1nVnNtkPjb3nzYYg1DYrH6YQH7xnHRsnjDVndtkPH0znBdbX-tkPH0YPadbX-tkPHDzraYYg1DdnW0LQywlg1DdnWnsQywlg1Ddn1RsQywlg1Ddn1R1Qywlg1Ddn1RYQH7xnHR1rH6VuZGxnHRYrj0VuZGxnHRYrHbVuZGxnHRdnHDVuZGxnHRdPWfVuZGxnHRvPjbVuZGxnHRvPHfVuZGxnHRvP1TVuZGxnHRvrHfVuZGxnHRvrHRVuZGxnHRLnHRVnNtkPHTYnadbX-tkPH6sniYkg1DdrjnvQywlg1Ddrjn3QH7xnW0vHaYknj0sP-tznWDVuZGxPHnYQHR0mycqn7ts0ANzu1Ys0ZKs5HbLPHc4rjDdn0K8IM0qna3snj0snj0sn0KVIZ0qn0KbuAqs5HD0ThCqn0KbugmqIv-1ufK%22%2C%22worker_id%22%3A%22bote53kf07%40163.com%22%2C%22talk_time%22%3A%2220171017144323%22%7D%2C%22end%22%3A%7B%22company_id%22%3A%2272133840%22%2C%22end_time%22%3A%2220171017144447%22%2C%22end_type%22%3A%223%22%2C%22talk_id%22%3A%2286448938106%22%7D%7Dtalk_infoTOKENe88fda96-bd77-429b-8bcc-be651a47d237';
    $strData=@urldecode($content);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();

    if(count($data) == count($data,1)){//一维（访客信息）

        $visitor->addInfo($data);

    }else{//二维（访客聊天记录）
        $visitor->addRecord($data);
    }

    $time=date('Y-m-dH:i:s',time());
    file_put_contents("../Uploads/log/".$time.'.txt', $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);
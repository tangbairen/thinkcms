<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    require('./Visitor.class.php');
    /*$mysql=new MMysql(array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    ));*/

    $content='%7B%22message%22%3A%5B%7B%22worker_name%22%3A%22%22%2C%22company_id%22%3A%2272133840%22%2C%22msg_type%22%3A%22p%22%2C%22id6d%22%3A%2210213367%22%2C%22talk_id%22%3A%2286452422806%22%2C%22worker_id%22%3A%22bote53kf06%40163.com%22%2C%22msg%22%3A%22%E6%82%A8%E5%A5%BD%EF%BC%8C%E8%AF%B7%E9%97%AE%E6%82%A8%E7%94%B5%E8%AF%9D%E5%A4%9A%E5%B0%91%3F%E7%A8%8D%E5%90%8E%E6%8A%8A%E4%BA%A7%E5%93%81%E4%BB%B7%E6%A0%BC%E3%80%81%E4%BC%98%E6%83%A0%E6%94%BF%E7%AD%96%E3%80%81%E5%88%A9%E6%B6%A6%E5%88%86%E6%9E%90%2C%E5%90%88%E4%BD%9C%E6%B5%81%E7%A8%8B%E7%AD%89%E5%8F%91%E5%88%B0%E6%82%A8%E6%89%8B%E6%9C%BA%E4%B8%8A%EF%BC%8C%E6%82%A8%E5%85%88%E4%BA%86%E8%A7%A3%E4%B8%80%E4%B8%8B%E5%A5%BD%E5%90%97%EF%BC%9F%22%2C%22msg_time%22%3A%2220171017161612%22%7D%2C%7B%22worker_name%22%3A%22%22%2C%22company_id%22%3A%2272133840%22%2C%22msg_type%22%3A%22g%22%2C%22id6d%22%3A%2210213367%22%2C%22talk_id%22%3A%2286452422806%22%2C%22worker_id%22%3A%22bote53kf06%40163.com%22%2C%22msg%22%3A%2218691068145%22%2C%22msg_time%22%3A%2220171017161702%22%7D%5D%2C%22session%22%3A%7B%22kw%22%3A%22%E4%B8%80%E7%82%B9%E7%82%B9%E5%A5%B6%E8%8C%B6%E5%8A%A0%E7%9B%9F%22%2C%22company_id%22%3A%2272133840%22%2C%22guest_area%22%3A%22%E6%B9%96%E5%8C%97%E7%9C%81%E8%8D%86%E5%B7%9E%E5%B8%82%5B%E7%94%B5%E4%BF%A1%5D%22%2C%22land_page%22%3A%22http%3A%2F%2Fs3baidu.188bbq.com%2Fydd2-wap%2F%3Fbdclickid%3Dbdmo_003667%26keyword%3D%25E4%25B8%2580%25E7%2582%25B9%25E7%2582%25B9%25E5%25A5%25B6%25E8%258C%25B6%25E5%258A%25A0%25E7%259B%259F%25E8%25B4%25B9%26semk%3D59194434125%26semc%3D15374398494%26semm%3D2%26semp%3Dmt2%26sema%3Dbj%26semd%3Dmo%22%2C%22guest_id%22%3A%2210231112318014%22%2C%22talk_id%22%3A%2286452422806%22%2C%22id6d%22%3A%2210213367%22%2C%22guest_ip%22%3A%2227.26.68.18%22%2C%22se%22%3A%22%E6%89%8B%E6%9C%BA%E7%99%BE%E5%BA%A6%22%2C%22worker_name%22%3Anull%2C%22talk_type%22%3A%225%22%2C%22talk_page%22%3A%22http%3A%2F%2Fs3baidu.188bbq.com%2Fydd2-wap%2F%3Fbdclickid%3Dbdmo_003667%26keyword%3D%25E4%25B8%2580%25E7%2582%25B9%25E7%2582%25B9%25E5%25A5%25B6%25E8%258C%25B6%25E5%258A%25A0%25E7%259B%259F%25E8%25B4%25B9%26semk%3D59194434125%26semc%3D15374398494%26semm%3D2%26semp%3Dmt2%26sema%3Dbj%26semd%3Dmo%22%2C%22device%22%3A%222%22%2C%22referer%22%3A%22https%3A%2F%2Fm.baidu.com%2Fbaidu.php%3Furl%3Daf0000a-KmSQQXy7vaT4TcumC6Px9yUzbPP38181MoqQ3uLKfAwSKWjbgx9SFU9wo8TKXAS2Drdc3Hms5vQVcCu2dwS8xA-tckvlsYu0VN3D9xgPl-SbhZn2LW-5VoT3AdSohuLcTkT5oTFpmBXj4dKNKgWnFPJmDyVyNpElqX4wHMBZUf.7b_iwtUvTyjzovUQeOmBjwIIb1tjrrjExIjwxjv3hQeVQ8yz1WYq5WdeRlrKYd1AZ1en5o_seQn5M33IhHjlet5M33IhHjlet5M8sSLI9qXMj4enr13T5oY3x5I9vXLjeUn5M33IOo9LOgj4en5ovmxgxdWHGeyPvSExvIMZ_ozU8_pInQ7XeW3qMZx_ePOudWHGY_ur_pIrPWHfzImYlyyQtEyPrh4Wi4Hsn3Sg6WyAp7WWgu_tN0.U1Yz0ZDqYo8d3egWknzzlQ1Hst_0mywkXHLD1QQCYo8d3egWEP5jzexw0A7bTgfqn6KlTA3qPj0sQHT4riY4n1fd0ZKGm1Yk0ZfqYo8d3egWknzzlQ1Hst8LYfKGUHYznWc0u1dLugK1n0KdpHY0TA-b5HDv0APGujY1PjT0UgfqnH0kPdtknjD4g1nkPj-xnW0snNt1PW0k0AVG5H00TMfqrjn30ANGujYknH01nHNxnHDYP1Rsg1DkrHf3nNtknH6zPj-xnHDYnHT3g1DkPjcYP7tknHbkn1IxnH0Ln1DYg1DkrH0zP7tknHbsPjwxnHD3rj64g1Dkrj6LP-tknH63PjwxnHD3rjD3g1DkrjT4P7tknH64P1D0mhbqnW0vg1csnj0zg1csnjnk0AdW5HmLP1nzn1m1n-tvP1T3PjmdnWwxnH0zg1D4rjnLPjNxn0KkTA-b5H00TyPGujYs0ZFMIA7M5H00ULu_5HDsnjRYQywlg1Dsnj6YQywlg1Dsn1czQywlg1Dsn1nLQH7xnH0YP1RVnNtknjmsraYkg1DsrjmzQywlg1DsrHTdQywlg1DsrH6YQywlg1DknjD1Qywlg1DknjT1Qywlg1DknjT3QHIxnHDsrHbVn-tknHDknadbX-tknHD1PBdbX-tknHDYnadbX-tknHczPzdbX-tknHTdPzdbX-tknHTdridbX-tknHTvradbX-tknW0VnW03g1DznjD4QH7xnHckQywlg1DznBY4rHb4rNtknWn1nadbX-tknWfsradbX-tknWf4PidbX-tknWRkradbX-tknWRvnzdbX-tknWmzPiYkg1DzP1nzQywlg1DzP1b1Qywlg1DzrjTYQywlg1DzrHmYQH7xnHnsrj0VnNtkn1cvridbX-tkn1RYnBYzg1D1PHmYQywlg1D1PWTvQywlg1D1PW6LQHPxnHnLPj6VuZGxnHnLPjbVndtkn16dPzYkg1D1rjmYQHwxnHn3rHmVndtkn1bsPBdbX-tkPjDznidbX-tkPjD3PadbX-tkPjcsnzdbX-tkPjnYPzdbX-tkPjf3nBYdg1DYPHbzQH7xnHfvn1cVnNtkPjmYnBYYg1DYPWfLQywlg1DYPWRdQH7xnHfvPWnVnNtkPjmLradbX-tkPjTsnBYkg1DYP1D3Qywlg1DYP1TsQH7xnHfLrjTVuZGxnHf3P1fVuZGxnHf3P1mVndtkPjbsnadbX-tkPjbLnadbX-tkPH0sniYzg1DdnjczQywlg1Ddnjf1QHFxnHRknW6VuZGxnHRkPjTVnNtkPHc3naYkg1Ddn1RzQywlg1Ddn1R1QH7xnHRYnH0VndtkPHf1nBYkg1DdPjn3QH7xnHRYn1bVuZGxnHRYPH6VnNtkPHRsnzdbX-tkPHRknBdbX-tkPHR1PzYkn7tkPHR3PBdbX-tkPHmYniYzg1DdPWf4Qywlg1DdPWRdQywlg1DdPWmsQywlg1DdPW6kQywlg1DdP1DdQHFxnHRLn1cVuZGxnHR3njmVnNtkPH61PBdbX-tznjunQHDsnj0kg16dniY10A7B5HKxn0K-ThTqn0KsTjYLPHms%22%2C%22worker_id%22%3A%22bote53kf06%40163.com%22%2C%22talk_time%22%3A%2220171017161612%22%7D%2C%22end%22%3A%7B%22company_id%22%3A%2272133840%22%2C%22end_time%22%3A%2220171017161815%22%2C%22end_type%22%3A%223%22%2C%22talk_id%22%3A%2286452422806%22%7D%7Dtalk_infoTOKEN53af7d28-56c9-4794-b9d0-db28f7f2af09';
    $strData=@urldecode($content);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();
    $count=$visitor->getmaxdim($data);
    if($count === 1 ){//一维（访客信息）
        file_put_contents("../Uploads/log/log222.txt", '123456');
        $visitor->addInfo($data);

    }else{//二维（访客聊天记录）
        file_put_contents("../Uploads/log/log.txt", '123456');
        $visitor->addRecord($data);
    }
    $time=date('Y-m-d H:i:s',time());
    file_put_contents("../Uploads/log/".$time.'.txt', $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);
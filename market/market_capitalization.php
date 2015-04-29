<?php
    // simple_html_dom.phpをインクルード
    require 'simple_html_dom.php';

    $yahoo_finance_url = "http://stocks.finance.yahoo.co.jp/stocks/detail/?code=";
    $yahoo_finance_t = ".T";
    
    $url = array(
            "コロプラ" => $yahoo_finance_url . "3668" . $yahoo_finance_t, 
            "グリー" => $yahoo_finance_url . "3632" . $yahoo_finance_t, 
            "DeNA" => $yahoo_finance_url . "2432" . $yahoo_finance_t, 
            "ガンホー" => $yahoo_finance_url . "3765" . $yahoo_finance_t, 
            "ミクシィ" => $yahoo_finance_url . "2121" . $yahoo_finance_t, 
            "クルーズ" => $yahoo_finance_url . "2138" . $yahoo_finance_t, 
            "ドリコム" => $yahoo_finance_url . "3793" . $yahoo_finance_t, 
            "エイチーム" => $yahoo_finance_url . "3662" . $yahoo_finance_t, 
            "サイバーエージェント" => $yahoo_finance_url . "4751" . $yahoo_finance_t, 
            "Klab" => $yahoo_finance_url . "3656" . $yahoo_finance_t, 
            "ボルテージ" => $yahoo_finance_url . "3639" . $yahoo_finance_t, 
            "enish" => $yahoo_finance_url . "3667" . $yahoo_finance_t, 
            "ケイブ" => $yahoo_finance_url . "3760" . $yahoo_finance_t, 
            "マーベラスAQL" => $yahoo_finance_url . "7844" . $yahoo_finance_t, 
            "モブキャスト" => $yahoo_finance_url . "3664" . $yahoo_finance_t, 
            "アエリア" => $yahoo_finance_url . "3758" . $yahoo_finance_t, 
            "アクロディア" => $yahoo_finance_url . "3823" . $yahoo_finance_t, 
            "インフォコム" => $yahoo_finance_url . "4348" . $yahoo_finance_t, 
            "スクエニ" => $yahoo_finance_url . "9684" . $yahoo_finance_t, 
            "ネクソン" => $yahoo_finance_url . "3659" . $yahoo_finance_t, 
            );

    //時価金額
    $total_jika = 0;

    foreach ($url as $key => $value) {
        //時価金額の数字用
        $number_jika = getjika($value);

        //数字変更
        $number_jika = str_replace(",","",$number_jika);

        //時価金額
        $total_jika += $number_jika;

        $jika_array[$key] = $number_jika;
       
        // 企業名　時価総額 
        print($key . getjika($value) ."百万円" . "\n") ;
    }

    //3桁で区切る
    $total_jika = number_format($total_jika);
    $jika_average = number_format(jikaaverage($jika_array));
    
    // 時価総額合計
    print("時価総額合計" . $total_jika . "百万円" . "\n");

    //時価総額の平均
    print("時価総額の平均" . $jika_average . "百万円" . "\n");

    /*
    * 時価総額の平均値を求める
    */
    function jikaaverage(array $values){
        return (float) (array_sum($values) / count($values));
    }

    /*
     yahoo financeから時価総額部分を取得
    */
    function getjika($url){ 

        // スクレイピングしたいURLを指定
        $html = file_get_html($url);
    
        // 引っ張るものを指定してdd要素を$elementに代入
        foreach($html->find('dd[class="ymuiEditLink mar0"]') as $element){
    
            //要素内のテキスト抽出して変数に格納
            $text = $element->innertext ;
    
            //百万円を含まれてる部分を取得
            if (preg_match("/百万円/", $text)){
    
                // <strong></strong>の部分を取得 
                $pattern = '/\<strong\>.+?\<\/strong\>/';
    
                // マッチした部分の取得
                preg_match($pattern, $text,$match);
    
                // 時価部分
                $match_jika = $match[0];
    
                // strong部分
                $search = array('<strong>','</strong>');
    
                // 時価総額部分を取得
                $jika = str_replace($search,"", $match_jika);
    
                return $jika;
    
            }
        }
    }
?>


<?php

  include 'conn.php';
  include 'insert.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <link rel="stylesheet" type="text/css" href="example.css">
        <meta charset="utf-8">
        <title>タンパクっと</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.min.js'></script>
        <script src="app.js" defer></script>
    </head>
    <body>
      <h1>タンパクっと</h1>

      <br></br>
      <img src="tanpaku.png" alt="海の写真" title="空と海"width="965" height="500" >




<div class="aaaa">
<div class="hidden_box">
<label for="label1">選択してください</label>
<input type="checkbox" id="label1"/>
<div class="hidden_show">
  
<!--非表示ここから-->

<table  class="momoyama-table">
  <thead>
<tr><th>食品</th><th>タンパク質</th><th>選択数</th></tr>
</thead>
<?php

//配列$products
foreach($products as $p){
$id = $p['id'];
$name = $p['food_name'];
$protein = $p['protein'];
$order = $p['order_quantity'];
//表を生成して選択に合わせてidを送信
echo "<tr><td><a href='product.php?id={$id}'>{$name}</a></td><td>{$protein}グラム</td><td>{$order}個</td></tr>";
}
?>
</table>
<!--ここまで-->
</div>
</div>

<!-- 円グラフのclassを定義 -->
<div class="chart-wrap" style="position: relative; display: inline-block;　display:flex; width: 700px; height: 550px;">
     <canvas id="myPieChart"></canvas>
     </div>   

  </div> 
      
         
      <?php

      foreach($total_products as $p){

      $sum = $sum . '"'. $p['sum'].'",';
      $time = $time . '"'. $p['time'] .'",';   
      }  
      //更新ボタン
      if(isset($_POST['add'])) {
          echo "";
      } else if(isset($_POST['update'])) {
          	try
          	{
          	// db接続
          	$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
          	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
          	$db->exec("UPDATE `food_products` SET `order_quantity`=0 WHERE 1"); //注文数を0にリセット
          	
          	}
          	catch(PDOException $e)
          	{
          	    $error = $e->getMessage();
          	    exit;
            }
            
      } else {
          echo "";
      }
      ?>        
     <h2>直近一週間のグラフ</h2> 
     <h2>本日は<?php echo (int)$goukei; ?>グラム摂取しました</h2>
         <!--棒グラフの表示-->  
 <div class="bar">
      <div class="chart-container" style="position: relative; width: 950px; height: 700px;">
          <canvas id="myLineChart">ここにチャート表示</canvas>
      </div>     
     <script>
     //.getContext('2d');はcanvasでグラフとか描画するために使う 
     var cty = document.getElementById("myLineChart").getContext('2d');
      var myLineChart = new Chart(cty, {
        type: 'bar',
        data: {
             labels: [<?php echo $time ?>],//各棒の名前（name)
          datasets: [
            {
              label: '直近一週間のタンパク質摂取量',
              data: [<?php echo $sum ?>],//各縦棒の高さ(値段)
               
              backgroundColor:[
              "rgba(255, 99, 132, 0.2)",
              "rgba(255, 159, 64, 0.2)",
              "rgba(255, 205, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(201, 203, 207, 0.2)"
            ],
            borderColor: [
              "rgb(255, 99, 132)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)"
            ],
            }
          ],
        },
        options: {

      scales: {
        xAxes: [{
          id : 'x軸',
          ticks: {
            autoSkip: true,
            maxTicksLimit: 7 //値の最大表示数
          }
        }],
        yAxes: [{
          id : 'y軸',
        }]
      },
      annotation: {
        annotations: [
            {
                type: 'line', // 線分を指定
                drawTime: 'afterDatasetsDraw',
                id: 'a-line-1', // 線のid名を指定（他の線と区別するため）
                mode: 'horizontal', // 水平を指定
                scaleID: 'y軸', // 基準とする軸のid名
                value: 65.0, // 引きたい線の数値（始点）
                endValue: 65.0, // 引きたい線の数値（終点）
                borderColor: 'red', // 線の色
                borderWidth: 3, // 線の幅（太さ）
                borderDash: [2, 2],
                borderDashOffset: 1,
                label: { // ラベルの設定
                    backgroundColor: 'rgba(255,255,255,0.8)',
                    bordercolor: 'rgba(200,60,60,0.8)',
                    borderwidth: 2,
                    fontSize: 10,
                    fontStyle: 'bold',
                    fontColor: 'rgba(200,60,60,0.8)',
                    xPadding: 10,
                    yPadding: 10,
                    cornerRadius: 3,
                    position: 'left',
                    xAdjust: 0,
                    yAdjust: 0,
                    enabled: true,
                    content: '1日の目標摂取量[タンパク質]'
                }
            },

        ]
    }
        }
  });      

      </script>
 <form action="index.php" method="post">
<div class="sousa">
<button class="btn-social-circle btn-social-circle--hatebu">
  <img src="touroku.png" alt="海の写真" title="登録" 　width="50" height="30">
</button>
<button class="btn-social-circle btn-social-circle--pocket">
   <img src="gomi.png" alt="海の写真" title="削除" 　width="50" height="30">
</button>
<button class="btn-social-circle btn-social-circle--feedly">
  <img src="reload.png" alt="海の写真" name="update"　title="更新" 　width="40" height="30">
</button>
     </form> 
     </div>
    </div>
 <!--  
    index.phpにpost     
    <form action="index.php" method="post">
        <button type="submit" name="add">登録</button>
        <button type="submit" name="update">更新</button>
        <button type="submit" name="remove">削除</button>
      </form>    
      -->    
	</body>
</html>
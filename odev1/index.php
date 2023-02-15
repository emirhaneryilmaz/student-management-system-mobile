<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
include 'config.php';

pageHeader();

$update = false;
$operator = isset($_GET['op']) ? $_GET['op'] : 'null';
$total_records = mysqli_num_rows($conn->query("SELECT * FROM student"));

switch ($operator) {

    case 'sil':
        sil($conn, $_GET['sid']);
        listele($conn);
        break;
    case 'kaydet':
        kaydet($conn, $_GET['fname'], $_GET['lname'], $_GET['birthplace'], $_GET['birthDate']);
        listele($conn);
        break;
    case 'yeni':
        yeniForm($conn);
        break;
    case 'guncelle':
        guncelleForm($conn, $_GET['sid']);
        break;
    case 'guncelleButon':
        guncelle($conn, $_GET['sid'], $_GET['fname'], $_GET['lname'], $_GET['birthplace'], $_GET['birthDate']);
        listele($conn);
        break;
    default:
        listele($conn);
}

pageBottom($total_records);
$conn->close();
exit;


function pageHeader()
{
    echo <<< pageHeader

    <html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#2196f3">
        <link rel="stylesheet" href="/odev1/framework7/framework7-icons.css">
        <link rel="stylesheet" href="/odev1/framework7/app.css">
        <link rel="stylesheet" href="/odev1/framework7/framework7-bundle.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
    </head>

         <body>

         <div id="app">
            <div class="panel-backdrop"></div>
            <div class="view view-main">
              <div data-name="home" class="page">
              <div class="panel panel-left panel-left-1 panel-reveal panel-resizable panel-init">
              <div class="block">
                <p><a class="link external" href="?op=yeni">Yeni</p>
                <p><a class="panel-close link external" href="index.php">Liste</a></p>
              </div>
            </div>
                <div class="navbar">
                  <div class="navbar-bg"></div>
                  <div class="navbar-inner">
                    <div class="left">
                        <i class="icon another-icon"></i>
                        <span><a class="button button-fill panel-open" href="#" data-panel=".panel-left-1"> <span class="mdi mdi-menu"></span></a></span>
                     
                    </div>
                    <div style='width:100%; text-align:center'>Student Management System</div>
                  </div>
                </div>
         
         <script>
      
         </script>
    pageHeader;
}

function pageBottom($total_records)
{

    echo <<< pageBottom
    

     <script>
     var currentUrl = document.URL;
    
     //1 ,'den sonra sağ tarafı alıyor
     //0 ,'den sonra sol tarafı
    var col = (currentUrl.split('=')[1]);
    var row = (currentUrl.split('&')[1]);
    console.log(row+" "+col); 

    document.getElementById('selectBox').addEventListener('change', function() {
        console.log('You selected: ', this.value);
        let degisken = new XMLHttpRequest();


      
        if(this.value=='all'){
          var url = "http://localhost:8888/odev1/index.php?page=1&value="+$total_records;
          
        document.location.href = url;
        }

        else{
        var url = "http://localhost:8888/odev1/index.php?page=1&value="+this.value;
          
        document.location.href = url;
        }

    });
 
   
    let str =currentUrl.substring(37,38);
    
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('value');
   

    if(str=="")
       document.getElementById('selectBox').value=5;
    else{
      if(myParam>25){
        document.getElementById('selectBox').value='all';
      }
      else
       document.getElementById('selectBox').value=myParam;
    }    
      
       </script>
       <script type="text/javascript" src="/odev1/framework7/framework7-bundle.js"></script>
         <script type="text/javascript" src="/odev1/framework7/routes.js"></script>
         <script type="text/javascript" src="/odev1/framework7/store.js"></script>
         <script type="text/javascript" src="/odev1/framework7/app.js"></script>
      </body>
    </html>

    pageBottom;
}

function sil($conn, $sid)
{
    mysqli_query($conn, $sql = "DELETE FROM student WHERE sid=$sid") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
}

function kaydet($conn, $fname, $lname, $birthplace, $birthDate)
{
    mysqli_query($conn, $sql = "INSERT INTO student (fname, lname , birthplace , birthDate) VALUES ('$fname', '$lname', '$birthplace','$birthDate')") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
}

function yeniForm($conn)
{?>

      <div class="page-content">
        <form class="list" id="my-form" method="get" action="index.php">
          <ul>
            <li>
              <div class="item-content item-input">
                <div class="item-inner">
                  <div class="item-title item-label">Ad</div>
                  <div class="item-input-wrap">
                    <input type="text" name="fname" placeholder="Adınız" />
                  </div>
                </div>
              </div>
            </li>
            <li>
            <div class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">Soyad</div>
                <div class="item-input-wrap">
                  <input type="text" name="lname" placeholder="Soyadınız" />
                </div>
              </div>
            </div>
            </li>
            <li>
              <div class="item-content item-input">
              <div class="item-inner">
              <div class="item-title item-label">Doğum Yeri</div>
                <div class="item-input-wrap">
                  <input type="text" name="birthplace" placeholder="Doğum yeriniz" />
              </div>
            </div>
            </div>
            </li>
            <li>
              <div class="item-content item-input">
                <div class="item-inner">
                  <div class="item-title item-label">Doğum Tarihi</div>
                  <div class="item-input-wrap">
                  <input type="date" name="birthDate" placeholder="Doğum tarihiniz" />
                  </div>
              </div>
                </div>
            </li>
          </ul>
          
          <input type="submit" class="button button-fill" name="op" value="kaydet" />

        </form>
         
        </div>
      </div>
    </div>
    
   

<?php
}

function guncelleForm($conn, $sid)
{
    $sql = "SELECT * FROM student WHERE sid='$sid'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    $sid = $row['sid'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $birthplace = $row['birthplace'];
    $birthDate = $row['birthDate'];
    echo <<<FORM
    <div class="page-content">
    
      <div class="block-title">Kayıt Güncelle</div>
      <form action="index.php",method="post">
        <div class="list no-hairlines-md">
          <ul>
            <li class="item-content item-input ">
              <div class="item-inner">
                <div class="item-title item-label">ID</div>
                <div class="item-input-wrap" >
                  <input type="number" readonly id="sid" name="sid" value="{$sid}" />
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">Ad</div>
                <div class="item-input-wrap">
                  <input type="text"  id="fname" name="fname" value="{$fname}"/>
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">Soyad</div>
                <div class="item-input-wrap">
                  <input type="text"  id="lname" name="lname" value="{$lname}"/>
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">Doğum Yeri</div>
                <div class="item-input-wrap">
                  <input type="text" id="birthplace" name="birthplace"value="{$birthplace}"/>
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">Doğum Tarihi</div>
                <div class="item-input-wrap">
                  <input type="date" id="birthdate" name="birthDate"value="{$birthDate}"/>
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner" style="display:none">
                <div class="item-input-wrap">
                  <input type="hidden" name="op" value="guncelleButon">
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
          </ul>
          <input class="button button-fill convert-form-to-data" type="submit" value="Güncelle">
        </div>
      </form>
      
    </div> 
    FORM;

}

function guncelle($conn, $sid, $fname, $lname, $birthplace, $birthDate)
{
    mysqli_query($conn, $sql = "UPDATE student SET fname='$fname', lname='$lname' , birthplace='$birthplace', birthDate='$birthDate' WHERE sid=$sid") or die(mysqli_error($conn) . ' sql komutu: ' . $sql);
}



function listele($conn)
{

  // $toplamKayit = mysqli_query($conn, "SELECT COUNT(*) FROM student") or die(mysqli_error($conn));
  // while($read = mysqli_fetch_array($toplamKayit))
  //    {
  //       print_r($read);
           
  //    } 


    $num_per_page = 5;
    if(isset($_GET['value'])){
      $num_per_page  = $_GET['value'];
    }

    

    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }


    $start_from = ($page - 1) * 5;
    $sql = "SELECT * FROM student";


    $result = $conn->query($sql);
    $total_records = mysqli_num_rows($result);
    $total_pages = ceil($total_records / $num_per_page);

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = 'sid';
    }

    @$sort = $_GET['sort'] == "ASC" ? "DESC" : "ASC";
    if (isset($_GET['sirala'])) {
        $sort = $_GET['sirala'] == "ASC" ? "ASC" : "DESC";
    }


    $sql2 = "SELECT * FROM student ORDER BY $order $sort LIMIT $start_from,$num_per_page ";

    $result2 = $conn->query($sql2);
    ?>


<?php    
    echo "       <div class='page-content'>
                   <div class='card data-table'>";
    echo "          <table><tr>
                    <th class='label-cell'><a class='link external' href='?order=sid&value=$num_per_page&sort=$sort'>No</th>
                    <th class='label-cel'><a class='link external' href='?order=fname&value=$num_per_page&sort=$sort'>Ad</th>
                    <th class='label-cel'><a class='link external' href='?order=lname&value=$num_per_page&sort=$sort'>Soyad</th>
                    <th class='label-cel'><a class='link external' href='?order=birthplace&value=$num_per_page&sort=$sort'>Doğum Yeri</th>
                    <th class='label-cel'><a class='link external' href='?order=birthDate&value=$num_per_page&sort=$sort'>Doğum Tarihi</th>
                    <th>Sil</th>
                    <th>Güncelle</th>
                    </tr>";


    while ($row = mysqli_fetch_assoc($result2)) {

        echo "      <tr><td class='label-cell'>" . $row["sid"] . "</td><td class='label-cell'>" . $row["fname"] . "</td><td> " . $row["lname"] . "</td>
                    <td class='label-cell'>" . $row["birthplace"] . "</td><td class='label-cell'>" . $row["birthDate"] . "</td>
                    <td> 
                    <a class='link external' href='index.php?op=sil&sid=$row[sid]'>
                    <span class='mdi mdi-trash-can'></span>
                    </a> 
                
                    </td>
                    <td> 
                    <a class='link external' href ='?op=guncelle&sid=$row[sid]'>
                    <span class='mdi mdi-account-edit'></span>
                    </a>
                    </td>
                    </tr>";
    }
    echo "          </table>";
    
    

    echo '          <div class="data-table-footer">
                      <div class="data-table-rows-select">
                        Per page:
                        <div class="input input-dropdown">
                          <select id="selectBox">
                            <option value="5">5</option>
                            <option value="10" >10</option>
                            <option value="25">25</option>
                            <option value="all">All</option>
                          </select>
                        </div>
                      </div>
                      <div class="data-table-pagination">
                      <!-- <span class="data-table-pagination-label">1-5 of 10</span> -->';
      
      if ($page != 1) { echo '<a href="?page=' . ($page - 1) . '&order='.$order.'&sirala='.$sort.'&value='.$num_per_page.' " class="link external">
        <i class="icon icon-prev color-gray"></i>
      </a>';}
      else{
       echo' <a href="#" class="link disabled">
        <i class="icon icon-prev color-gray"></i>
      </a>';
      }



      if ($page != $total_pages){echo  '<a  href="?page=' . ($page + 1) . '&order='.$order.'&sirala='.$sort.'&value='.$num_per_page.'" class="link external">
        <i class="icon icon-next color-gray"></i>
      </a>'; }
      else{
       echo' <a href="#" class="link">
        <i class="icon icon-next color-gray"></i>
      </a>';
      }

      
     
    echo '          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>';
   
  // echo "<div id='sayfalama'>";
  //   $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  //   if ($page != 1) echo ' <a class="link external" href="?page=1">&lt;&lt; </a> ';
  //     else echo "&lt;&lt";
  //   if ($page != 1) echo ' <a class="link external" href="?page=' . ($page - 1) . '">&lt; </a> ';
  //     else echo " &lt";
  //   for ($i = 1; $i <= $total_pages; $i++) {

  //       echo $page == $i ? $i . " " : "<a class='link external' href='index.php?page=" . $i . "&order=" . $order . "&sirala=" . $sort . "'>" . $i . "</a>";
  //   }

  //   if ($page != $total_pages) echo ' <a class="link external" href="?page=' . ($page + 1) . '">&gt; </a> ';
  //   else echo " &gt";
  //   if ($page != $total_pages) echo ' <a class="link external" href="?page=' . $total_pages . '">&gt;&gt; </a> ';
  //   else echo " &gt;&gt";


  //   "</div>
    
  //   </div>";


}
?>
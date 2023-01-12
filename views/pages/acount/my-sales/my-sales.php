<?php
if (!isset($_SESSION['user'])) {
    echo '<script>
            window.location="' . $path . 'acount&login";
    </script>';
    return;
}else{
    $time= time();
    if($_SESSION["user"]->token_exp_user < $time){
        echo '<script>
        switAlert("error", "Para proteger tus datos, si no hay actividad en tu cuenta, se cierra automaticamente. Vuelve a logearte!", "' . $path . 'acount&logout","");
            
    </script>';
    return;
    }else{
        $select1 = "id_store";
        $url1 = CurlController::api()."stores?linkTo=id_user_store&equalTo=".$_SESSION["user"]->id_user."&select=".$select1;
        $method= "GET";
        $header= array();
        $filds= array();
        $idStore = CurlController::request($url1, $method, $header, $filds);
        if($idStore->status == 200){
            $idStore = $idStore->result[0]->id_store;

            if( isset($_GET["date1"]) && isset($_GET["date2"])){
                if($_GET["date1"] != null && $_GET["date2"] != null && substr_count($_GET["date1"], "/") === 2 && substr_count($_GET["date2"], "/") === 2 ){
                    $between1 = date("Y-m-d", strtotime($_GET["date1"]));
                    $between2 = date("Y-m-d", strtotime($_GET["date2"]));
                    $select="unit_price_sale,commission_sale,date_created_sale,quantity_order,name_product_sale";
                    $url= CurlController::api()."relations?rel=sales,orders&type=sale,order&linkTo=date_created_sale&between1=".$between1."&between2=".$between2."&filterTo=id_store_sale&inTo=".$idStore."&select=".$select."&orderBy=date_created_sale&orderMode=ASC&token=".$_SESSION["user"]->token_user;
                    $sales= CurlController::request($url, $method, $header, $filds)->result;
                }else{
                    echo '<script>
                            formatearAlertas();
                            switAlert("error", "Se produjo un error", null,null);
                        </script>';
                    return;
                }
            }else{
            // traer las ventas
            $select="unit_price_sale,commission_sale,date_created_sale,quantity_order,name_product_sale";
            $url= CurlController::api()."relations?rel=sales,orders&type=sale,order&linkTo=id_store_sale&equalTo=".$idStore."&select=".$select."&orderBy=date_created_sale&orderMode=ASC&token=".$_SESSION["user"]->token_user;
            $sales= CurlController::request($url, $method, $header, $filds)->result;
            }
        
            if(!is_array($sales)){
                $sales = array();
            }
        }
    }
}
?>
<div class="ps-vendor-dashboard pro">

    <div class="container">

        <div class="ps-section__header">

            <!--=====================================
            Profile
            ======================================--> 

            <?php include "views/pages/acount/profile/profile.php"; ?>

            <!--=====================================
            Nav Account
            ======================================--> 

            <div class="ps-section__content">

                <ul class="ps-section__links">
                    <li><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-store">My Store</a></li>
                    <li class="active"><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
                </ul>

                <!--=====================================
                My Sales
                ======================================--> 

                <form class="ps-form--vendor-datetimepicker mt-5" method="get">

                    <div class="row">

                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 ">

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text" id="time-from">From</span>

                                </div>

                                <input 
                                class="form-control ps-datepicker" 
                                name="date1" 
                                aria-label="Username" 
                                aria-describedby="time-from"
                                value="<?php if( isset($_GET["date1"]) && isset($_GET["date2"])){if($_GET["date1"] != null && $_GET["date2"] != null && substr_count($_GET["date1"], "/") === 2 && substr_count($_GET["date2"], "/") === 2 ){echo $_GET["date1"];}}?>">

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 ">

                            <div class="input-group">

                                <div class="input-group-prepend">

                                    <span class="input-group-text" id="time-form">To</span>

                                </div>

                                <input 
                                class="form-control ps-datepicker" 
                                name="date2" 
                                aria-label="Username" 
                                aria-describedby="time-to"
                                value="<?php if( isset($_GET["date1"]) && isset($_GET["date2"])){if($_GET["date1"] != null && $_GET["date2"] != null && substr_count($_GET["date1"], "/") === 2 && substr_count($_GET["date2"], "/") === 2 ){echo $_GET["date2"];}}?>">

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 ">

                            <button type="submit" class="ps-btn"><i class="icon-sync2"></i> Update</button>

                        </div>

                    </div>

                </form>

                <?php
                    error_reporting(0);
                    $profits = 0;
                    $comisions= 0;
                    $total = 0;
                    $arrayDate = array();
                    $sumSales = array();
                    foreach( $sales as $index => $value ){                   
                        $profits += $value->unit_price_sale;
                        $comisions += $value->commission_sale;
                        $total += $profits + $comisions;

                        $date = substr($value->date_created_sale,0,7);
                        array_push($arrayDate, $date);
                        $arraySales = array($date => $value->unit_price_sale);
                        foreach($arraySales as $key => $item){
                            $sumSales[$key] += $item;
                        }
                    }
                    $dateNoRepeat = array_unique($arrayDate);
                ?>

                <div class="row">

                    <div class="col-12 ">

                        <figure class="ps-block--vendor-status">

                            <figcaption>Total sales</figcaption>

                            <table class="table ps-table ps-table--vendor-status">

                                <tbody>

                                    <tr>
                                        <td>Store profile</td>
                                        <td>$ <?php echo number_format($profits,2); ?></td>
                                    </tr>

                                    <tr>
                                        <td>Comision</td>
                                        <td>$ <?php echo number_format($comisions,2); ?></td>
                                    </tr>

                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td>$ <?php echo number_format($total,2); ?></td>
                                    </tr>

                                </tbody>

                            </table>

                        </figure>

                    </div>

                     <div class=" col-12 ">

                        <figure class="ps-block--vendor-status">

                            <figcaption>Sales Graph</figcaption>

                            <canvas id="line-chart" width="585" height="292" class="chartjs-render-monitor" style="display: block; width: 585px; height: 292px;"></canvas>

                        </figure>

                    </div>

                    <div class="col-12">
                        <figure class="ps-block--vendor-status">
                            <figcaption>Sales Table</figcaption>
                        
                            <div class="table-responsive">
                                <table class="table ps-table ps-table--vendor dt-responsive dt-client" datatable width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Comission</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($sales as $key => $value): ?>
                                            <tr>
                                                <td><?php echo $value->date_created_sale ?></td>
                                                <td><?php echo $value->name_product_sale ?></td>
                                                <td><?php echo $value->quantity_order ?></td>
                                                <td>$<?php echo $value->unit_price_sale ?></td>
                                                <td>$<?php echo $value->commission_sale ?></td>
                                                <td>$<?php echo $value->unit_price_sale + $value->commission_sale ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </figure>
                    </div>

                </div>     

            </div>

        </div>

    </div>

</div>
<script>
    var config = {
    type: 'line',
    data: {
        labels: [
            <?php 
                foreach($dateNoRepeat as $key => $value){
                    echo "'".$value."',";
                }    
            ?>
        ],
        datasets: [{
            label: 'Sales',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [
                <?php 
                foreach($dateNoRepeat as $key => $value){
                    echo "'".$sumSales[$value]."',";
                }    
            ?>
            ],
            fill: false,
        }]
    },
    options: {
        responsive: true,
        title: {
            display: true, 
            text: 'Total is <?php echo count($sales); ?> Sales from <?php echo $sales[0]->date_created_sale; ?> - <?php echo $sales[count($sales)-1]->date_created_sale; ?>'
        }
    }
};

window.onload = function() {
    var ctx = document.getElementById('line-chart').getContext('2d');
    window.myLine = new Chart(ctx, config);
    var pieChart = document.getElementById('pie-chart').getContext('2d');
    window.myPie = new Chart(pieChart, configPieChart);
};
</script>
<?php
require_once "../controllers/curlController.php";
require_once "../controllers/templateController.php";

class ControllerDataTableOrders{
    public function dataOrders(){
        if(!empty($_POST)){
            $draw = $_POST["draw"];
            $orderByColumIndex = $_POST["order"][0]["column"];
            $orderBy = $_POST["columns"][$orderByColumIndex]["data"];
            $orderType = $_POST["order"][0]["dir"];
            $start = $_POST["start"];
            $length = $_POST["length"];

            $select = "id_order";
            $url = CurlController::api()."orders?linkTo=id_store_order&equalTo=".$_GET["idStore"]."&select=".$select."&token=".$_GET["token"];
            $method ="GET";
            $fields = array();
            $headers = array();
            
            $totalData = CurlController::request($url, $method, $fields, $headers);
        
            if($totalData->status == 200){
                $totalData = $totalData->total;

                $select = "id_order,id_store_order,id_user_order,id_product_order,details_order,quantity_order,price_order,email_order,country_order,city_order,address_order,phone_order,price_product,quantity_order,details_order,price_order,date_created_order,notes_order,process_order,status_order,name_product,displayname_user";
                if(!empty($_POST["search"]["value"])){
                    $linkTo = ["id_order","name_product","displayname_user","status_order","date_created_order"];
                    $search = str_replace(" ", "_", $_POST["search"]["value"]);

                    foreach($linkTo as $key => $value){
                        $url = CurlController::api()."relations?rel=orders,stores,users,products&type=order,store,user,product&linkTo=".$value.",id_store_order&search=".$search.",".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                        $searchOrder = CurlController::request($url,$method,$fields,$headers)->result;
                        if($searchOrder == "no found"){
                            $totalOrder = array();
                        }else{
                            $totalOrder = $searchOrder;
                            $recordsFiltered = count($totalOrder);
                            break;
                        }
                    }
                }else{
                    $url = CurlController::api()."relations?rel=orders,stores,users,products&type=order,store,user,product&linkTo=id_store_order&equalTo=".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                    $totalOrder = CurlController::request($url, $method, $fields, $headers);
                    $recordsFiltered = $totalData;
                    if($totalOrder->status != 200){
                        echo '{"data":[]}';
                        return;
                    }
                    $totalOrder = $totalOrder->result;
                }

                if(count($totalOrder) == 0){
                    echo '{"data":[]}';
                    return;
                }

                $dataJson = '{
                    "draw": '.$draw.',
                    "recordsTotal":'.$totalData.',
                    "recordsFiltered":'.$recordsFiltered.',
                    "data":[';
                
                foreach($totalOrder as $key => $value){
                    if($value->status_order == "pending"){
                        $status_order = "<span class='badge badge-danger p-3'>".$value->status_order."</span>";
                    }else{
                        $status_order = "<span class='badge badge-success p-3'>".$value->status_order."</span>";
                    }

                    $client_order = $value->displayname_user;

                    $email_order = $value->email_order;

                    $country_order = $value->country_order;

                    $city_order = $value->city_order;

                    $address_order = $value->address_order;

                    $phone_order = $value->phone_order;

                    $product_order = $value->name_product;

                    $quantity_order = $value->quantity_order;

                    $details_order = preg_replace("/\"/", "'", $value->details_order);;
                    $details_order = TemplateController::cleanhtml($details_order);

                    $price_order = $value->price_order;

                    $process_order = "<ul class='timeline'>";
                    foreach(json_decode($value->process_order, true) as $index => $item2){
                        if($item2["status"] == "ok"){
                            $process_order .= "<li class='success pl-5 ml-5'>                                             
                                                    <h5>".$item2["date"]."</h5>
                                                    <p class='text-success'>".$item2["stage"]."<i class='fas fa-check'></i></p>
                                                    <p>Comment: ".$item2["comment"]."</p>
                                                </li>";
                        }else{
                            $process_order .= " <li class='process pl-5 ml-5'>                                             
                                                    <h5>".$item2["date"]."</h5>
                                                    <p>".$item2["stage"]."</p>
                                                    <button class='btn btn-primary' disabled><span class='spinner-border spinner-border-sm'></span>In Process</button>
                                                </li>";
                        }
                    }
                    $process_order .="</ul>";
                    if($value->status_order == "pending" && $value->status_order != null){
                        $process_order .= "<a class='btn btn-warning btn-lg nextProcess' idStores='".$value->id_store_order."' namessProduct='".$product_order."' clientOrder='".$client_order."' idOrder='".$value->id_order."' emailOrder='".$email_order."' productOrder='".$product_order."' processOrder='". base64_encode($value->process_order)."'>Next Process</a>";
                    }
                    $process_order = TemplateController::cleanhtml($process_order);

                    $date_created_order = $value->date_created_order;
                                        
                    $dataJson .= '{
                        "id_order" : "'.($start + $key + 1).'",
                        "status_order" : "'.$status_order.'",
                        "displayname_user" : "'.$client_order.'",
                        "email_order" : "'.$email_order.'",
                        "country_order" : "'.$country_order.'",
                        "city_order" : "'.$city_order.'",
                        "address_order" : "'.$address_order.'",
                        "phone_order" : "'.$phone_order.'",
                        "name_product" : "'.$product_order.'",
                        "quantity_order" : "'.$quantity_order.'",
                        "details_order" : "'.$details_order.'",
                        "price_order" : "'.$price_order.'",
                        "process_order" : "'.$process_order.'",
                        "date_created_order" : "'.$date_created_order.'"
                    },';
                }
                $dataJson = substr($dataJson, 0, -1);
                $dataJson .= ']}';
                echo $dataJson;
            }else{
                echo '{"data":[]}';
                return;
            }
        }
    }

}

$data = new ControllerDataTableOrders();
$data -> dataOrders();
?>
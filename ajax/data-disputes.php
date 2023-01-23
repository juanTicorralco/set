<?php
require_once "../controllers/curlController.php";
require_once "../controllers/templateController.php";

class ControllerDataTableDispute{
    public function dataDispute(){
        if(!empty($_POST)){
            $draw = $_POST["draw"];
            $orderByColumIndex = $_POST["order"][0]["column"];
            $orderBy = $_POST["columns"][$orderByColumIndex]["data"];
            $orderType = $_POST["order"][0]["dir"];
            $start = $_POST["start"];
            $length = $_POST["length"];

            $select = "id_dispute";
            $url = CurlController::api()."disputes?linkTo=id_store_dispute&equalTo=".$_GET["idStore"]."&select=".$select."&token=".$_GET["token"];
            $method ="GET";
            $fields = array();
            $headers = array();
            
            $totalData = CurlController::request($url, $method, $fields, $headers);        
            if($totalData->status == 200){
                $totalData = $totalData->total;
                $select = "id_dispute,id_order_dispute,content_dispute,answer_dispute,date_answer_dispute,date_created_dispute,displayname_user,email_user";
                if(!empty($_POST["search"]["value"])){
                    $linkTo = ["id_dispute","id_order_dispute","date_answer_dispute","date_created_dispute","displayname_user","email_user"];
                    $search = str_replace(" ", "_", $_POST["search"]["value"]);

                    foreach($linkTo as $key => $value){
                        $url = CurlController::api()."relations?rel=disputes,users&type=dispute,user&linkTo=".$value.",id_store_dispute&search=".$search.",".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                        $searchDispute = CurlController::request($url,$method,$fields,$headers)->result;
                        if($searchDispute == "no found"){
                            $totalDispute = array();
                        }else{
                            $totalDispute = $searchDispute;
                            $recordsFiltered = count($totalDispute);
                            break;
                        }
                    }
                }else{
                    $url = CurlController::api()."relations?rel=disputes,users&type=dispute,user&linkTo=id_store_dispute&equalTo=".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                    $totalDispute = CurlController::request($url, $method, $fields, $headers);
                    $recordsFiltered = $totalData;
                    if($totalDispute->status != 200){
                        echo '{"data":[]}';
                        return;
                    }
                    $totalDispute = $totalDispute->result;
                }

                if(count($totalDispute) == 0){
                    echo '{"data":[]}';
                    return;
                }

                $dataJson = '{
                    "draw": '.$draw.',
                    "recordsTotal":'.$totalData.',
                    "recordsFiltered":'.$recordsFiltered.',
                    "data":[';
                
                foreach($totalDispute as $key => $value){

                    $id_order = $value->id_order_dispute;
                    $client_order = $value->displayname_user;
                    $email_order = $value->email_user;
                    $content_dispute = $value->content_dispute;
                    if( $value->answer_dispute == null){
                        $answer_dispute = "<button class='btn btn-sm btn-secondary answerDiput' idDispute=".$value->id_dispute." clientDispute='".$value->displayname_user."' emailDispute='".$value->email_user."'>Atender</button>";
                        $date_answer_dispute = "--/--/--";
                    }else{
                        $answer_dispute = $value->answer_dispute;
                        $date_answer_dispute = $value->date_answer_dispute;
                    }                    
                    $date_created_dispute = $value->date_created_dispute;
                                        
                    $dataJson .= '{
                        "id_dispute" : "'.($start + $key + 1).'",
                        "id_order_dispute" : "'.$id_order.'",
                        "displayname_user" : "'.$client_order.'",
                        "email_user" : "'.$email_order.'",
                        "content_dispute" : "'.$content_dispute.'",
                        "date_created_dispute" : "'.$date_created_dispute.'",
                        "answer_dispute" : "'.$answer_dispute.'",
                        "date_answer_dispute" : "'.$date_answer_dispute.'"
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

$data = new ControllerDataTableDispute();
$data -> dataDispute();
?>
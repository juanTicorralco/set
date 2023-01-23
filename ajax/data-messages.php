<?php
require_once "../controllers/curlController.php";
require_once "../controllers/templateController.php";

class ControllerDataTableMessage{
    public function dataMessage(){
        if(!empty($_POST)){
            $draw = $_POST["draw"];
            $orderByColumIndex = $_POST["order"][0]["column"];
            $orderBy = $_POST["columns"][$orderByColumIndex]["data"];
            $orderType = $_POST["order"][0]["dir"];
            $start = $_POST["start"];
            $length = $_POST["length"];

            $select = "id_message";
            $url = CurlController::api()."messages?linkTo=id_store_message&equalTo=".$_GET["idStore"]."&select=".$select."&token=".$_GET["token"];
            $method ="GET";
            $fields = array();
            $headers = array();
            
            $totalData = CurlController::request($url, $method, $fields, $headers);        
            if($totalData->status == 200){
                $totalData = $totalData->total;
                $select = "id_message,content_message,answer_message,date_answer_message,date_created_message,displayname_user,email_user,name_product,url_product";
                if(!empty($_POST["search"]["value"])){
                    $linkTo = ["id_message","name_product","date_answer_message","date_created_message","displayname_user","email_user"];
                    $search = str_replace(" ", "_", $_POST["search"]["value"]);

                    foreach($linkTo as $key => $value){
                        $url = CurlController::api()."relations?rel=messages,users,products&type=message,user,product&linkTo=".$value.",id_store_message&search=".$search.",".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                        $searchMessage = CurlController::request($url,$method,$fields,$headers)->result;
                        if($searchMessage == "no found"){
                            $totalMessage = array();
                        }else{
                            $totalMessage = $searchMessage;
                            $recordsFiltered = count($totalMessage);
                            break;
                        }
                    }
                }else{
                    $url = CurlController::api()."relations?rel=messages,users,products&type=message,user,product&linkTo=id_store_message&equalTo=".$_GET["idStore"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length."&select=".$select."&token=".$_GET["token"];
                    $totalMessage = CurlController::request($url, $method, $fields, $headers);
                    $recordsFiltered = $totalData;
                    if($totalMessage->status != 200){
                        echo '{"data":[]}';
                        return;
                    }
                    $totalMessage = $totalMessage->result;
                }

                if(count($totalMessage) == 0){
                    echo '{"data":[]}';
                    return;
                }

                $dataJson = '{
                    "draw": '.$draw.',
                    "recordsTotal":'.$totalData.',
                    "recordsFiltered":'.$recordsFiltered.',
                    "data":[';
                
                foreach($totalMessage as $key => $value){

                    $name_product = $value->name_product;
                    $client_message = $value->displayname_user;
                    $email_message = $value->email_user;
                    $content_message = $value->content_message;
                    if( $value->answer_message == null){
                        $answer_message = "<button class='btn btn-sm btn-secondary answerMessage' idMessage=".$value->id_message." clientMessage='".$value->displayname_user."' emailMessage='".$value->email_user."' urlProduct='".$value->url_product."'>Responder</button>";
                        $date_answer_message = "--/--/--";
                    }else{
                        $answer_message = $value->answer_message;
                        $date_answer_message = $value->date_answer_message;
                    }                    
                    $date_created_message = $value->date_created_message;
                                        
                    $dataJson .= '{
                        "id_message" : "'.($start + $key + 1).'",
                        "name_product" : "'.$name_product.'",
                        "displayname_user" : "'.$client_message.'",
                        "email_user" : "'.$email_message.'",
                        "content_message" : "'.$content_message.'",
                        "date_created_message" : "'.$date_created_message.'",
                        "answer_message" : "'.$answer_message.'",
                        "date_answer_message" : "'.$date_answer_message.'"
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

$data = new ControllerDataTableMessage();
$data -> dataMessage();
?>
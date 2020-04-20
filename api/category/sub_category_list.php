<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
     header("content-type: application/json");
     
    if (isset($_GET['cat_id']) && !empty($_GET['cat_id'])) {
        
 		$cat_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['cat_id']));
        $sql = "SELECT * FROM `sub_category` WHERE `category_id` = '$cat_id'";
        if ($res = $connection->query($sql)) {
            while($categor = $res->fetch_assoc()){
                $category[] = [
                    'id' => $categor['id'],
                    'name' => $categor['name'],
                    'image' => $categor['image'],
                ];
            }
            
            $response =[
                "status" => true,
                'message' => 'Sub Category List',
                'data' =>$category,
            ];
            http_response_code(200);
            echo json_encode($response);
        }else{
            $response =[
                "status" => false,
                'message' => 'Something Wrong',
                'data' =>[],
            ];
            http_response_code(200);
            echo json_encode($response);
        }
    } else {
        $response =[
            "status" => false,
            'message' => 'Cat Id Can Not Be Empty',
            'data' =>[],
        ];
        http_response_code(200);
        echo json_encode($response);
    }
    
	
    function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}	
?>
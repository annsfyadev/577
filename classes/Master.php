<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_shop_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `shop_type_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Shop Type already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `shop_type_list` set {$data} ";
			}else{
				$sql = "UPDATE `shop_type_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Shop Type successfully saved.";
				else
				$resp['msg'] = " Shop Type successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_shop_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `shop_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Shop Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		
		$check = $this->conn->query("SELECT * FROM `category` where `name` = '{$name}' and seller_id = '{$seller_id}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Category already exists.";
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `category` set {$data} ";
			}else{
				$sql = "UPDATE `category` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				if(empty($id))
				$resp['msg'] = " New Category successfully saved.";
				else
				$resp['msg'] = " Category successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){
		$_POST['description'] = htmlentities($_POST['description']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `resources` where seller_id = '{$seller_id}' and `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Resources Name already exists.';
		}else{
			if(empty($id)){
				$sql = "INSERT INTO `resources` set {$data} ";
			}else{
				$sql = "UPDATE `resources` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$pid = empty($id) ? $this->conn->insert_id : $id;
				$resp['pid'] = $pid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " New resources successfully saved.";
				else
					$resp['msg'] = " Resources successfully updated.";
				
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/products"))
					mkdir(base_app."uploads/products");
					$fname = 'uploads/products/'.($pid).'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg']=" Resources list saved but Image failed due to invalid file type.";
					}else{
						
				
						list($width, $height) = getimagesize($upload);
						$new_height = $height; 
						$new_width = $width; 
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
								if(isset($uploaded_img) && $uploaded_img == true){
									$qry = $this->conn->query("UPDATE `resources` set image_path = concat('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '$pid' ");
								}
						}else{
						$resp['msg']=" But Image failed to upload due to unkown reason.";
						}
					}
					
				}
			}else{
				$resp['status'] = 'failed';
				if(empty($id))
					$resp['msg'] = " Resources has failed to save.";
				else
					$resp['msg'] = " Resources has failed to update.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}

		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `resources` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Resources successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function add_to_cart(){
		$_POST['customer_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM cart where resources_id = '{$resources_id}' && customer_id = '{$customer_id}'")->num_rows;
		if($check > 0){
			$sql = "UPDATE cart set quantity = quantity + {$quantity} where resources_id = '{$resources_id}' && customer_id = '{$customer_id}' ";
		}else{
			$sql = "INSERT INTO cart set {$data}";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$resp['msg'] = " Resources has added to cart.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " The resources has failed to add to the cart.";
			$resp['error'] = $this->conn->error. "[{$sql}]";
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function update_cart_qty(){
		extract($_POST);
		$update_cart = $this->conn->query("UPDATE `cart` set `quantity` = '{$quantity}' where id = '{$cart_id}'");
		if($update_cart){
			$resp['status'] = 'success';
			$resp['msg'] = ' Resources Quantity has updated successfully';
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = ' Resources Quantity has failed to update';
			$resp['error'] = $this->conn->error;
		}
		
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_cart(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `cart` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$resp['msg'] = " Cart Item has been deleted successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Cart Item has failed to delete.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] =='success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function place_order(){
		extract($_POST);
		$inserted=[];
		$has_failed=false;
		$gtotal = 0;
		$seller = $this->conn->query("SELECT * FROM `seller` where id in (SELECT seller_id from resources where id in (SELECT resources_id FROM `cart` where customer_id ='{$this->settings->userdata('id')}')) order by `shop_name` asc");
		$prefix = date('Ym-');
		$code = sprintf("%'.05d",1);
		while($vrow = $seller->fetch_assoc()):
			$data = "";
			while(true){
				$check = $this->conn->query("SELECT * FROM order where code = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$ref_code = $prefix.$code;
			$data = "('{$ref_code}','{$this->settings->userdata('id')}','{$vrow['id']}','{$this->conn->real_escape_string($delivery_address)}')";
			$sql = "INSERT INTO `order` (`code`,`customer_id`,`seller_id`,`delivery_address`) VALUES {$data}";
			$save = $this->conn->query($sql);
			if($save){
				$oid = $this->conn->insert_id;
				$inserted[] = $oid;
				$data = "";
				$gtotal = 0 ;
				$products = $this->conn->query("SELECT c.*, p.name as `name`, p.price,p.image_path FROM `cart` c inner join resources p on c.resources_id = p.id where c.customer_id = '{$this->settings->userdata('id')}' and p.seller_id = '{$vrow['id']}' order by p.name asc");
				while($prow = $products->fetch_assoc()):
					$total = $prow['price'] * $prow['quantity'];
					$gtotal += $total;
					if(!empty($data)) $data .= ", ";
						$data .= "('{$oid}', '{$prow['resources_id']}', '{$prow['quantity']}', '{$prow['price']}')";
				endwhile;
				$sql2 = "INSERT INTO `order_items` (`order_id`,`resources_id`,`quantity`,`price`) VALUES {$data}";
				$save2= $this->conn->query($sql2);
				if($save2){
					$this->conn->query("UPDATE `order` set `total_amount` = '{$gtotal}' where id = '{$oid}'");
				}else{
					$has_failed = true;
					$resp['sql'] = $sql2;
					break;
				}
			}else{
				$has_failed = true;
				$resp['sql'] = $sql;
				break;
			}
		endwhile;
		if(!$has_failed){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been placed";
			$this->conn->query("DELETE FROM `cart` where customer_id ='{$this->settings->userdata('id')}'");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Order has failed to place";
			$resp['error'] = $this->conn->error;
			if(count($inserted) > 0){
				$this->conn->query("DELETE FROM `order` where id in (".(implode(',',array_values($inserted))).") ");
			}
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);

		return json_encode($resp);
	}
	function cancel_order(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order` set `status` = 5 where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order has been cancelled successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `order` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has been updated successfully.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = " Order Status has failed to update.";
			$resp['error'] = $this->conn->error;
		}
		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_shop_type':
		echo $Master->save_shop_type();
	break;
	case 'delete_shop_type':
		echo $Master->delete_shop_type();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
	break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
	break;
	case 'delete_cart':
		echo $Master->delete_cart();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'cancel_order':
		echo $Master->cancel_order();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	default:
		// echo $sysset->index();
		break;
}
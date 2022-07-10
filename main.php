<?php

//検索処理
function getMstData($params){
	//接続取得
	$Mysqli = getSqlConn();

	//入力された検索条件からSQl文を生成
	$where = [];
	if(!empty($params['user_id'])){
		$where[] = "M01.user_id like '%{$params['user_id']}%'";
	}
	if(!empty($params['user_nm'])){
		$where[] = "M01.user_nm like '%{$params['user_nm']}%'";
	}
	if(!empty($params['bumon_cd'])){
		$where[] = "M02.bumon_cd = '{$params['bumon_cd']}'";
	}
	if(empty($params['muko_flg']) || $params['muko_flg'] == false){
		$where[] = "M01.muko_flg = false";
	}

	$sql = 'SELECT M01.KANRI_NO, M01.KOSHINBI, M01.TOROKUBI, M01.USER_ID,M01.USER_NM,M01.SAGYOBA_MEI,M01.ADDRESS,M01.PHONE,M01.MUKO_FLG'
			. ",M02.BUMON_MEI FROM M01 INNER JOIN M02 ON M01.BUMON_CD = M02.BUMON_CD";

	if($where){
		$sql = $sql . ' WHERE ';
		$whereSql = implode(' AND ', $where);
		$sql = $sql . $whereSql;
	}
	
	//SQL文を実行する
	$UserDataSet = $Mysqli->query($sql);

	//扱いやすい形に変える
	$result = [];
	while($row = $UserDataSet->fetch_assoc()){
		$result[] = $row;
	}
	return $result;
}

//編集時の管理NO取得
function getMstDataByNo($params){
	//接続取得
	$Mysqli = getSqlConn();

	$sql = "SELECT M01.*, M01.USER_NM FROM M01 INNER JOIN M02 ON M01.BUMON_CD = M02.BUMON_CD "
			. "WHERE M01.kanri_no = " . $_POST["kanri_no"];
	
	//SQL文を実行する
	$UserDataSet = $Mysqli->query($sql);

	//扱いやすい形に変える
	$result = [];
	while($row = $UserDataSet->fetch_assoc()){
		$result[] = $row;
	}
	return $result;
}

//更新処理
function updateMst() {
	if (isset($_POST['kanri_no'])) {

		$pdo = new PDO('mysql:charset=UTF8;dbname=mydb;host=localhost', 'testuser', '12345');

		$stmt = $pdo->prepare("UPDATE M01 SET KOSHINBI = :koshinbi, "
				. " USER_ID = :user_id,  USER_NM = :user_nm, BUMON_CD = :bumon_cd, SAGYOBA_MEI = :sagyoba_mei, ADDRESS = :address, PHONE = :phone, MUKO_FLG = :muko_flg"
				. " WHERE kanri_no = :kanri_no");
		
		$stmt->bindParam( ':kanri_no', $_POST['kanri_no'], PDO::PARAM_INT);
		$stmt->bindParam( ':user_id', $_POST['user_id'], PDO::PARAM_STR);
		$stmt->bindParam( ':user_nm', $_POST['user_nm'], PDO::PARAM_STR);
		$stmt->bindParam( ':bumon_cd', $_POST['bumon_cd'], PDO::PARAM_STR);
		$stmt->bindParam( ':sagyoba_mei', $_POST['sagyoba_mei'], PDO::PARAM_STR);
		$stmt->bindParam( ':address', $_POST['address'], PDO::PARAM_STR);
		$stmt->bindParam( ':phone', $_POST['phone'], PDO::PARAM_STR);
		$stmt->bindParam( ':koshinbi', date("Y-m-d H:i:s") , PDO::PARAM_STR);
		$stmt->bindParam( ':muko_flg', $_POST['muko_flg'], PDO::PARAM_BOOL);
		
		$res = $stmt->execute();
		
		$pdo = null;
	}
}

//削除処理
function deleteMst() {
	if (isset($_POST['kanri_no'])) {

		$pdo = new PDO('mysql:charset=UTF8;dbname=mydb;host=localhost', 'testuser', '12345');

		$stmt = $pdo->prepare("DELETE FROM M01 WHERE kanri_no = :kanri_no");
		
		$stmt->bindParam( ':kanri_no', $_POST['kanri_no'], PDO::PARAM_INT);
		
		$res = $stmt->execute();
		
		$pdo = null;
	}
}

//新規登録
function insertMst() {
	$pdo = new PDO('mysql:charset=UTF8;dbname=mydb;host=localhost', 'testuser', '12345');

	//管理NOを採番
	$stmt = $pdo->prepare("SELECT MAX(M01.kanri_no) AS MAX_NO FROM M01");
	$stmt->execute();
	$result = $stmt->fetch();
	$maxno = $result['MAX_NO'] + 1;

	//登録
	$stmt = $pdo->prepare("INSERT INTO M01 VALUES ("
			. ":kanri_no, :user_id, :user_nm, :bumon_cd, :sagyoba_mei, :address, :phone, :torokubi, :koshinbi, :muko_flg)");

	$newdate = date('Y/m/d H:i:s');
	
	$stmt->bindValue( ':kanri_no', $maxno , PDO::PARAM_INT);
	$stmt->bindParam( ':user_id', $_POST['user_id'], PDO::PARAM_STR);
	$stmt->bindParam( ':user_nm', $_POST['user_nm'], PDO::PARAM_STR);
	$stmt->bindParam( ':bumon_cd', $_POST['bumon_cd'], PDO::PARAM_STR);
	$stmt->bindParam( ':sagyoba_mei', $_POST['sagyoba_mei'], PDO::PARAM_STR);
	$stmt->bindParam( ':address', $_POST['address'], PDO::PARAM_STR);
	$stmt->bindParam( ':phone', $_POST['phone'], PDO::PARAM_STR);
	$stmt->bindValue( ':torokubi', $newdate , PDO::PARAM_STR);
	$stmt->bindValue( ':koshinbi', $newdate , PDO::PARAM_STR);
	$stmt->bindParam( ':muko_flg', $_POST['muko_flg'], PDO::PARAM_BOOL);
	
	$res = $stmt->execute();
	
	$pdo = null;
}

//DB接続情報取得
function getSqlConn() {
	//DBの接続情報
	include_once('config/database.php');

	//DBコネクタを生成
	$Mysqli = new mysqli($host, $username, $password, $dbname);
	if ($Mysqli->connect_error) {
			error_log($Mysqli->connect_error);
			exit;
	}
	return $Mysqli;
}
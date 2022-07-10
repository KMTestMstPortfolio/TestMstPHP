<?php 

	include_once('main.php');
	if (isset($_POST['edit'])) {
		//検索処理
		$userData = getMstDataByNo($_GET);
		$row = $userData[0];
	}
	if (empty($_POST['kanri_no'])) {
		if (isset($_POST['update'])) {
			//新規登録を実行時
			insertMst();
			header('Location: ./index.php');
			exit;
		}
	}
	else {
		if (isset($_POST['update'])) {
			//更新処理
			updateMst();
			header('Location: ./index.php');
			exit;
		}
		if (isset($_POST['delete'])) {
			//削除処理
			deleteMst();
			header('Location: ./index.php');
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<link rel="stylesheet" type="text/css" href="static/style.css">
	<meta charset="UTF-8">
	<title>作業者マスタメンテナンス</title>
</head>
<body>
	<header>
		<h1>
			<a href="/index">作業者マスタメンテナンス</a>
		</h1>
	</header>
	<div class="contents">
		<form method="post" method="post">
			<input type="hidden" name="kanri_no" value="<?php echo isset($_POST['edit']) ? $row['kanri_no'] : ''; ?>">
			<p><label>作業者ID：</label><input type="text" name="user_id" value="<?php echo isset($_POST['edit']) ? $row['user_id'] : ''; ?>" maxlength='30'>
			<p><label>作業者名：</label><input type="text" name="user_nm" value="<?php echo isset($_POST['edit']) ? $row['user_nm'] : ''; ?>"  maxlength='30'>
			<p><label>部門：</label>
			<select name="bumon_cd" class="form-control" id="bumon_Cd">
				<option value="0" <?php echo empty($row['bumon_cd']) ? 'selected' : ''; ?>>選択しない</option>
				<option value="A01" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A01' ? 'selected' : '' ?>>製造部門</option>
				<option value="A02" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A02' ? 'selected' : '' ?>>管理部門</option>
				<option value="A03" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A03' ? 'selected' : '' ?>>技術部門</option>
			</select>
			<p><label>作業場：</label><input type="text" name="sagyoba_mei" value="<?php echo isset($_POST['edit']) ? $row['sagyoba_mei'] : ''; ?>" maxlength='5'></p>
			<p><label>メールアドレス：</label><input type="text" name="address" value="<?php echo isset($_POST['edit']) ? $row['address'] : ''; ?>" maxlength='30'></p>
			<p><label>携帯番号：</label><input type="text" name="phone" value="<?php echo isset($_POST['edit']) ? $row['phone'] : ''; ?>" maxlength='13'></p>
			<input type="checkbox" name="muko_flg" <?php echo empty($row['muko_flg']) ? '' : 'checked' ?>>無効フラグ<p>
			<input type="submit" name="update" value="登録する"> <input type="submit" name="delete" value="削除する">
		</form>
		<input type="button" value="戻る" onClick="history.back()">
	</div>
	<footer>
    <br>
    </footer>
</body>
</html>
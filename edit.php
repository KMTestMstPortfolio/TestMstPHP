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
			<table class="edit_table">
			<tr>
	            <td colspan="2">以下の内容を入力してください。</td>
	        </tr>
			<tr>
	            <td>作業者ID</td>
				<td><input type="text" name="user_id" value="<?php echo isset($_POST['edit']) ? $row['user_id'] : ''; ?>" maxlength='30'></td>
			</tr>
			<tr>
				<td>作業者名</td>
				<td><input type="text" name="user_nm" value="<?php echo isset($_POST['edit']) ? $row['user_nm'] : ''; ?>"  maxlength='30'></td>
			</tr>
			<tr>
				<td>部門</td>
				<td><select name="bumon_cd" class="form-control" id="bumon_Cd">
				<option value="0" <?php echo empty($row['bumon_cd']) ? 'selected' : ''; ?>>選択しない</option>
				<option value="A01" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A01' ? 'selected' : '' ?>>製造部門</option>
				<option value="A02" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A02' ? 'selected' : '' ?>>管理部門</option>
				<option value="A03" <?php echo isset($row['bumon_cd']) && $row['bumon_cd'] == 'A03' ? 'selected' : '' ?>>技術部門</option>
				</select><td>
			</tr>
			<tr>
				<td>作業場</td>
				<td><input type="text" name="sagyoba_mei" value="<?php echo isset($_POST['edit']) ? $row['sagyoba_mei'] : ''; ?>" maxlength='5'></td>
			</tr>
				<tr>
				<td>メールアドレス</td>
				<td><input type="text" name="address" value="<?php echo isset($_POST['edit']) ? $row['address'] : ''; ?>" maxlength='30'></td>
			</tr>
			<tr>
				<td>携帯番号：</td>
				<td><input type="text" name="phone" value="<?php echo isset($_POST['edit']) ? $row['phone'] : ''; ?>" maxlength='13'></td>
			</tr>
			<tr>
			<td><input type="checkbox" name="muko_flg" <?php echo empty($row['muko_flg']) ? '' : 'checked' ?>>無効フラグ</td>
			</tr>
	        </table>
			<p><input type="submit" name="update" class="btn_update" value="登録する"> 
			<input type="submit" class="btn_delete" name="delete" value="削除する"></p>
		</form>
		<p><input type="button" value="戻る" class="btn_back" onClick="history.back()"></p>
	</div>
	<footer>
    <br>
    </footer>
</body>
</html>
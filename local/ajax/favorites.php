<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?

$id = $_POST['id'];

switch ($_POST['action']){
	case 'add':
		Favorites::add($id);
		$return['code'] = 'success';
		$return['text'] = 'Успешно добавлено';
		$return['items'] = Favorites::get();
		break;

	case 'remove':
		Favorites::remove($id);
		$return['code'] = 'success';
		$return['text'] = 'Успешно убрано';
		$return['items'] = Favorites::get();		
		break;

	case 'get':
		$return['code'] = 'success';
		$return['items'] = Favorites::get();
		break;

	case 'check':
		$return['code'] = 'success';
		if (Favorites::check($id)) {
			$return['result'] = true;
		} else {
			$return['result'] = false;
		}
		break;

	case 'toggle':
		if (Favorites::check($id)) {
			Favorites::remove($id);
			$return['code'] = 'success';
			$return['text'] = 'Успешно убрано';
			$return['items'] = Favorites::get();
		} else {
			Favorites::add($id);
			$return['code'] = 'success';
			$return['text'] = 'Успешно добавлено';
			$return['items'] = Favorites::get();
		}
		break;

	case 'header_update':
		/* Обновляем блок с количеством в шапке */

		break;
}
echo json_encode($return);
?>

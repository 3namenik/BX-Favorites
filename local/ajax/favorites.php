<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

$id = $_POST['id'];

switch ($_POST['action']) {
    case 'add':
        Wishlist::add($id);
        $return['code'] = 'success';
        $return['text'] = 'Успешно добавлено';
        $return['items'] = Wishlist::get();
        break;

    case 'remove':
        Wishlist::remove($id);
        $return['code'] = 'success';
        $return['text'] = 'Успешно убрано';
        $return['items'] = Wishlist::get();
        break;

    case 'get':
        $return['code'] = 'success';
        $return['items'] = Wishlist::get();
        break;

    case 'check':
        $return['code'] = 'success';
        if (Wishlist::check($id)) {
            $return['result'] = true;
        } else {
            $return['result'] = false;
        }
        break;

    case 'toggle':
        if (Wishlist::check($id)) {
            Wishlist::remove($id);
            $return['code'] = 'success';
            $return['text'] = 'Успешно убрано';
            $return['items'] = Wishlist::get();
        } else {
            Wishlist::add($id);
            $return['code'] = 'success';
            $return['text'] = 'Успешно добавлено';
            $return['items'] = Wishlist::get();
        }
        break;

    case 'header_update':
        /* Обновляем блок с количеством в шапке */

        break;
}
echo json_encode($return);
?>

<?
/**
 * 
 * Избранные товары
 * 
 * Класс для работы с избранными товарами
 * 
 * */
class Favorites
{
    /* Сколько времени будем хранить куки? */
    /* 60*60*24*30*12*2 */
    public static $time = 62208000;

    static public function get()
    {
        $favorites_list = json_decode(Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getCookie("FAVORITES"), TRUE);

        if ($favorites_list == null) {
            return [];
        } else {
            return $favorites_list;
        }
    }

    static public function add($value)
    {
        if (is_array($value)) {
            foreach ($value as $val) {
                $favorites_list = self::get();
                if (!in_array($val, $favorites_list)) {
                    $favorites_list[] = $val;
                }
            }
            self::_set_cookie($favorites_list);
        } else {
            $favorites_list = self::get();
            if (!in_array($value, $favorites_list)) {
                $favorites_list[] = $value;
                self::_set_cookie($favorites_list);
            }
        }
    }

    /** 
     * Удалить из избранного 
     * 
     * */
    static public function remove($value)
    {

        $favorites_list = self::get();
        if (is_array($value)) {
            foreach ($value as $val) {
                foreach ($favorites_list as $key => $id) {
                    if ($id == $val) {
                        unset($favorites_list[$key]);
                    }
                }
            }
            self::_set_cookie($favorites_list);
            return true;
        } else {
            foreach ($favorites_list as $key => $id) {
                if ($id == $value) {
                    unset($favorites_list[$key]);
                    self::_set_cookie($favorites_list);
                    return true;
                }
            }
        }
        return false;
    }

    static public function check($value)
    {
        $favorites_list = self::get();
        if (array_search($value, $favorites_list) !== false) {
            return true;
        } else {
            return false;
        }
    }

    static private function _set_cookie($favorites_list)
    {
        sort($favorites_list);
        $context = Bitrix\Main\Application::getInstance()->getContext();
        $cookie = new Bitrix\Main\Web\Cookie("FAVORITES", json_encode($favorites_list), time() + self::$time);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);
        $cookie->setSecure(false);
        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->writeHeaders("");
    }
}

?>
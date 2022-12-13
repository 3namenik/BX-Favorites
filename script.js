
/**
 * Wishlist
 * 
 * Объект для работы с избранным
 * 
 * Здесь храним список id избранного
 * 
 * Для привязки действий к кнопка в верстке добавляем атрибут [data-wishlist-id]
 * 
 * Для отображения счетчика - [data-wishlist-count]
 * 
 **/
class Wishlist{

    constructor(){
        this.items = [];

        let form = new FormData();
        form.append('action', 'get');
        fetch('/local/ajax/favorites.php', {
            method: 'POST',
            body: form
        }).then(response => response.json()).then(data => {
            if (data.items != null && data.items.length > 0) {
                this._save_items(data.items);
            }

            this.count = this.items.length;
            document.querySelectorAll('[data-wishlist-id]').forEach( item => {
                item.addEventListener('click', evt => {
                    let id = item.dataset.wishlistId;
                    if (item.classList.contains('btn_active')){
                        this.remove_item(id);
                    } else {
                        this.add_item(id);
                    }

                });
            });
            this._redraw();
        });

    }

    /* Добавляем в избранное */
    add_item(id){
        let form = new FormData();
        form.append('action', 'add');
        form.append('id', id);

        fetch('/local/ajax/favorites.php', {
            method: 'POST',
            body: form
        }).then(response => response.json()).then(
            data => {
                this.getItems();
            }
        );
    }

    /* Удалить из избранного */
    remove_item(id){
        let form = new FormData();
        form.append('action', 'remove');
        form.append('id', id);

        fetch('/local/ajax/favorites.php', {
            method: 'POST',
            body: form
        }).then(response => response.json()).then(
            data => {
                this.getItems();
            }
        );
    }

    getItems(){
        let form = new FormData();
        form.append('action', 'get');
        fetch('/local/ajax/favorites.php', {
            method: 'POST',
            body: form
        }).then(response => response.json()).then(data => {
            this._save_items(data.items);
        });
    }

    /* Необходим, чтобы сделать строгую типизацию списка id */
    _save_items(items){    
        let save = [];

        items.forEach(item => {
            save.push(Number(item));
        });

        this.items = save;
        this.count = this.items.length;

        this._redraw();
    }

    /* Перерисовать избранное */
    _redraw(){
        /* Обновляем кнопки */
        document.querySelectorAll('[data-wishlist-id]').forEach( item => {
            if (this.items.includes(Number(item.dataset.wishlistId))) {
                item.classList.add('btn_active');
            } else {
                item.classList.remove('btn_active');
            }
        });

        /* Обновляем счетчик */        
        document.querySelectorAll('[data-wishlist-count]').forEach(item => {
            if (this.count > 0){
                item.classList.remove('deactivate');
            } else {
                item.classList.add('deactivate');
            }
            item.innerText = this.count;
        });
    }
}

/* end class Wishlist */

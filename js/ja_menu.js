/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $("#logout_but").click(
            function () {
                var res = confirm('ログアウトしてもよろしいですか？');
                if (res) {
                    $("#logout").submit();
                }
            }
    );

});


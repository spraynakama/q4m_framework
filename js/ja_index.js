/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $(window).resize(function () {
        if ($(window).width() >= 780) {
            $('#index_main').css("margin-top", "100px");
        } else if ($(window).width() < 760) {
            $('#index_main').css("margin-top", "60px");
        }
    });

});
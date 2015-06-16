/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
    
    $('.user_row').click(function(){
        var id = $(this).data('id');
        var app = 'edit';
        $.post(app, { id: id }, function(data) {
                $('#right_pane').html(data);
        });
    });
    
    $('#add_new_but').click(function(){
        var app = 'edit';
        $.post(app, {}, function(data) {
                $('#right_pane').html(data);
        });
        
    });
});
$('.checkbox_wrapper').on('click',function(){
    $(this).closest('.card').find('.checkbox_children').prop('checked',this.checked);
})
$('.check_all').on('click',function(){
    $(this).parents('.form').find('.checkbox_children').prop('checked',this.checked);
})
$('.check_all').on('click',function(){
    $(this).parents('.form').find('.checkbox_wrapper').prop('checked',this.checked);
})

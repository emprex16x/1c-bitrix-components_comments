$(function(){
    var commentList = 'comments-list',
        commentList_comment = `${commentList}__comment`,
        commentList_replyBtn = `${commentList_comment}-reply`,
        commentList_form = `${commentList}-submit`,
        commentList_formReply = `${commentList_form}__reply`;

        $(`.${commentList_form}`).each(function(){
            var formID = $(this).data('id');
            $(`.${commentList}[data-id=${formID}] .${commentList_comment}`)
                .append(`<button class="${commentList_replyBtn}">Ответить</button>`);    
        });
        
        $(document).on('click', `.${commentList_replyBtn}`, function(){
            var parentID = $(this).parent().data('id'),
                replyTo = 'Ответ на комментарий:'+$(this).parent().children('b').text(),
                formID = $(this).parents(`.${commentList}`).data('id'),
                $form = $(`.${commentList_form}[data-id=${formID}]`);

            $form.find('input[name=parent]').val(parentID);

            if(!$form.find(`.${commentList_formReply}`).length)
                $form.prepend(`<div class="${commentList_formReply}">${replyTo}</div>`);
            else
                $form.find(`.${commentList_formReply}`).text(replyTo);
        });

        $(document).on('click', `.${commentList_formReply}`, function(){
            $(this).parent().find('input[name=parent]').val(0);
            $(this).remove();
        });
});
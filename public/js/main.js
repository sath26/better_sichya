function markNotificationAsRead(notificationCount) {
    if(notificationCount !=='0'){
        $.get('/markAsRead');
    }
}

   function toggleReply(commentId){
            $('.reply-form-'+commentId).toggleClass('hidden');
        }
$(document).ready(function () {
    // Pour gérer l'ajout de commentaires
    $('.comment-btn').click(function () {
        const newsId = $(this).data('news-id');
        const commentText = $(this).siblings('.comment-text').val();

        if (commentText.trim() === '') {
            alert('Veuillez entrer un commentaire.');
            return;
        }

        $.post('add_comment.php', { news_id: newsId, comment: commentText }, function (data) {
            if (data.success) {
                loadComments(newsId);
                $(this).siblings('.comment-text').val('');
            } else {
                alert('Erreur lors de l\'ajout du commentaire.');
            }
        }, 'json');
    });

    // Pour charger les commentaires
    function loadComments(newsId) {
        $.get('load_comments.php', { news_id: newsId }, function (data) {
            if (data.success) {
                const commentsHtml = data.comments.map(comment => `
                    <div class="comment">
                        <p>${comment.text}</p>
                        <button class="btn btn-danger delete-comment" data-comment-id="${comment.id}">Supprimer</button>
                    </div>
                `).join('');
                $(`.comments-list[data-news-id="${newsId}"]`).html(commentsHtml);
            }
        }, 'json');
    }

    // Pour gérer la suppression des commentaires
    $(document).on('click', '.delete-comment', function () {
        const commentId = $(this).data('comment-id');
        const newsId = $(this).closest('.comments-list').data('news-id');

        if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
            $.post('delete_comment.php', { comment_id: commentId }, function (data) {
                if (data.success) {
                    loadComments(newsId);
                } else {
                    alert('Erreur lors de la suppression du commentaire.');
                }
            }, 'json');
        }
    });

    // Pour gérer le partage
    $('.share-btn').click(function () {
        const sharePopup = $('#sharePopup');
        sharePopup.removeClass('d-none');
        const newsTitle = $(this).closest('.categories-item').find('h3').text();
        const newsUrl = window.location.href; // Changez cela si nécessaire

        $('#facebook-link').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(newsUrl)}&title=${encodeURIComponent(newsTitle)}`);
        $('#whatsapp-link').attr('href', `https://api.whatsapp.com/send?text=${encodeURIComponent(newsTitle)}%20${encodeURIComponent(newsUrl)}`);
        $('#instagram-link').attr('href', `https://www.instagram.com/?url=${encodeURIComponent(newsUrl)}`);
        $('#twitter-link').attr('href', `https://twitter.com/share?url=${encodeURIComponent(newsUrl)}&text=${encodeURIComponent(newsTitle)}`);
    });

    // Pour fermer la popup de partage
    $('.close-btn').click(function () {
        $('#sharePopup').addClass('d-none');
    });
});


  // Gestion des likes sur une publication
  const likeButtons = document.querySelectorAll(".like-btn");
  likeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const postId = this.dataset.id;
      const liked = this.dataset.liked === "true";
      const likeCount = this.querySelector(".like-count");

      fetch("like.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ post_id: postId, liked }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.dataset.liked = !liked;
            likeCount.textContent = data.likes;
            this.classList.toggle("text-blue-500", !liked);
            this.classList.toggle("text-gray-400", liked);
          }
        });
    });
  });

  // Gestion de l'envoi de commentaire
  const commentForms = document.querySelectorAll(".comment-form");
  commentForms.forEach((form) => {
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(this);

      fetch("comment.php", { method: "POST", body: formData })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            const commentsList = this.nextElementSibling;
            commentsList.innerHTML += `
                            <div class="comment-item p-2 border-b">
                                <p><strong>${data.username}</strong>: ${data.text}</p>
                                <button class="like-comment text-sm text-gray-400 hover:text-blue-500"
                                        data-comment-id="${data.commentId}">
                                    <i class="fas fa-thumbs-up"></i> (0)
                                </button>
                            </div>`;
          }
        });
    });
  });

  // Gestion du partage
  // const shareButtons = document.querySelectorAll(".share-btn");
  // shareButtons.forEach((button) => {
  //   button.addEventListener("click", function () {
  //     alert("Cephas ! le meilleur dev de l'histoire...");
  //   });
  // });
 


// gallery
function openModal(fileUrl, title, description) {
  const image = document.getElementById("modal-image");
  const video = document.getElementById("modal-video");

  if (fileUrl.match(/\.(jpg|jpeg|png|gif)$/)) {
    image.src = fileUrl;
    image.style.display = "block";
    video.style.display = "none";
  } else {
    video.src = fileUrl;
    video.style.display = "block";
    image.style.display = "none";
  }

  document.getElementById("modal").style.display = "block";
  document.getElementById("modal-caption").innerHTML = title;
  document.getElementById("modal-description").innerHTML = description;
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
}



document.addEventListener("DOMContentLoaded", () => {
  const change = document.querySelector(".icon");
  let titlesWhite = false;  // Initialise un état pour gérer la couleur des titres

  change.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode"); // Optionnel : bascule d'un mode sombre si nécessaire

    const feature = document.querySelector("#feature");
    const titles = document.querySelectorAll("#title");
    const paras = document.querySelectorAll("#p");

    // Change l'arrière-plan du feature
    feature.style.backgroundColor = "#33333333";

    // Change la couleur des titres
    titlesWhite = !titlesWhite;
    titles.forEach(title => {
      title.style.color = titlesWhite ? 'white' : 'black';
    });

    // Ajuste la couleur des paragraphes si besoin
    paras.forEach(para => {
      para.style.color = "#2B2C2CFF";
    });
  });
});






$(document).ready(function() {
  $('#submitComment').on('click', function() {
      const comment = $('#commentText').val();
      const newsId = $(this).data('news-id');

      $.ajax({
          url: 'add_comment.php',
          type: 'POST',
          data: {
              news_id: newsId,
              comment: comment
          },
          success: function(response) {
              // Réinitialiser le champ de texte
              $('#commentText').val('');
              // Ajouter le nouveau commentaire à la liste (facultatif, peut être fait via AJAX)
          },
          error: function() {
              alert('Erreur lors de l\'ajout du commentaire.');
          }
      });
  });
});

$('.like-comment-btn').on('click', function() {
  const commentId = $(this).data('comment-id');
  const likeCountSpan = $(this).find('.like-count');
  let currentLikes = parseInt(likeCountSpan.text());

  $.ajax({
      url: 'like_comment.php',
      type: 'POST',
      data: {
          comment_id: commentId
      },
      success: function(response) {
          // Incrémentez ou décrémentez le nombre de likes selon la réponse
          if (response === 'liked') {
              likeCountSpan.text(currentLikes + 1);
          } else if (response === 'unliked') {
              likeCountSpan.text(currentLikes - 1);
          }
      },
      error: function() {
          alert('Erreur lors de la mise à jour du like.');
      }
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.read-more').forEach(function (button) {
      button.addEventListener('click', function () {
          const content = this.previousElementSibling; // Description complète
          const preview = content.previousElementSibling; // Aperçu

          if (content.classList.contains('d-none')) {
              preview.classList.add('d-none');
              content.classList.remove('d-none');
              this.textContent = 'Read Less';
          } else {
              preview.classList.remove('d-none');
              content.classList.add('d-none');
              this.textContent = 'Read More';
          }
      });
  });
});

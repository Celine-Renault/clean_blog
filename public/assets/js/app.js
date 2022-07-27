/*!
* Start Bootstrap - Clean Blog v6.0.8 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/


let btnComment = document.getElementById('btn-comment');

let containerComment = document.getElementById('txtarea-comment'); // je recupere mon element textearea
let postId = containerComment.getAttribute('data-id'); // je recupere l'attribut data-id du textearea


btnComment.addEventListener('click', Valider)

function Valider() {
    
    fetch('/comment/create/' + postId, {
        method: 'POST',
        headers: {'content-type': 'Application/json'},
        body: JSON.stringify({ 'textareaComment': containerComment.value })
    }) // + postId je recupere l'attribut data-id de textarea
    .then(function (response) {
        return response.json();
    }).then(function (data) { // data c'est $allComments
        
        let comments = document.getElementById('comments');

            comments.innerHTML = ''; //  je vide, je supprime le contenu de la div
           
            for (comment of data) {
                comments.innerHTML += '<div class="comment"><span class="user-commentaire">'+comment.user+'</span><p class="contenu-commentaire">'+comment.content+'</p><span class="date-commentaire">Published on '+comment.createdAt+'</span></div>'
            }

        })

}

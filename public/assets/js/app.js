/*!
* Start Bootstrap - Clean Blog v6.0.8 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/


let btnComment = document.getElementById('btn-comment');
let inputComment = document.getElementById('input-comment');

btnComment.addEventListener('click', Valider)

function Valider() {
  
    fetch('/comment/create').then(function(res){
        return res.json();
    }).then(function(data){
        console.log(data);
    })
    }
  
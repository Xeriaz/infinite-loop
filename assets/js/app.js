require('bootstrap');
const $ = require('jquery');
const List = require('list.js');


$(document).ready(function() {
    const challengeList = new List('challenge-list', {
        valueNames: ['js-name','js-description','js-type', 'js-dateEnd','js-dateStart'],
        page: 5,
        pagination: true

    });
    const commentsList = new List('comments-list', {
        valueNames: ['js-user','js-commentDate','js-commentText'],
        page: 10,
        pagination: true

    });
    const searchList = new List('search-list', {
        valueNames: ['js-type','js-dateEnd','js-dateStart'],
        page: 6,
        pagination: true

    });


});


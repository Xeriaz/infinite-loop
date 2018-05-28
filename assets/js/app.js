require('bootstrap');
const $ = require('jquery');
const List = require('list.js');


$(document).ready(function() {

    if ($("#challenge-list").length !==0 ) {
        const challengeList = new List('challenge-list', {
            valueNames: [
                            'js-name',
                            'js-description',
                            'js-type',
                            'js-dateEnd',
                            'js-dateStart'],

            page: 5,
            pagination: true

        });

        $('#form_Search').on('keyup', function() {
            let searchString = $(this).val();
            challengeList.search(searchString);
        });

    }
    if ($("#comments-list").length !==0 ) {
        const commentsList = new List('comments-list', {
            valueNames: ['js-user', 'js-commentDate', 'js-commentText'],
            page: 10,
            pagination: true

        });
    }

    if ($("#search-list").length !==0 ) {
        const searchList = new List('search-list', {
            valueNames: ['js-type', 'js-dateEnd', 'js-dateStart'],
            page: 6,
            pagination: true

        });
    }



});


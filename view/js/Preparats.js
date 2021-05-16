$(document).ready(function () {
            $('.collapse')
                .on('shown.bs.collapse', function() {
                	console.log("collapse")
                    $(this)
                        .parent()
                        .find(".fa-caret-square-o-down")
                        .removeClass("fa-caret-square-o-down")
                        .addClass("fa-caret-square-o-up");
                })
                .on('hidden.bs.collapse', function() {
                    $(this)
                        .parent()
                        .find(".fa-caret-square-o-up")
                        .removeClass("fa-caret-square-o-up")
                        .addClass("fa-caret-square-o-down");
                });
        });
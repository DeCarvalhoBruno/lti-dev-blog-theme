$(document).ready(function () {
    if (typeof window.lti != 'undefined') {
        window.lti.PageInfo = function () {
            this.winTop = (screen.height / 2);
            this.winLeft = (screen.width / 2);
            this.posTop = this.winTop - this.winTop / 2;
            this.posLeft = this.winLeft - this.winLeft / 2;
            this.popup = function (target) {
                window.open(
                    target,
                    '_blank',
                    'top=' + this.posTop + ',left=' + this.posLeft + ',toolbar=0,status=0,width=' + this.winLeft + ',height=' + this.winTop
                );
            };
            this.shareCounter = function () {
                $.ajax(
                    {
                        type: 'GET',
                        url: window.lti.vars.api_url + 'shares?url=' + encodeURI(window.lti.vars.tested_url) + '&token=' + window.lti.vars.api_token,
                        dataType: 'jsonp',
                        jsonpCallback: 'cQWE0c4fmjSRkO0',
                        success: function (data) {
                            if (typeof data == "object") {
                                $('#facebook_share_link').find(".share-counter").text(data.facebook);
                                $('#gplus_share_link').find(".share-counter").text(data.gplus);
                                $('#twitter_share_link').find(".share-counter").text(data.twitter);
                                $('#linkedinshare_link').find(".share-counter").text(data.linkedin);
                                $('#pinterest_link').find(".share-counter").text(data.pinterest);
                            }
                        },
                        contentType: "application/json",
                        cache: true
                    }
                );
            };
        };
        var page = new window.lti.PageInfo();
        $('.share-button.new-window').find('a').on('click', function (e) {
            e.preventDefault();
            var link = this.href;
            if (typeof link != 'undefined' && link) {
                page.popup(link);
            }
        });
        page.shareCounter();
    }
});
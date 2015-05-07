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
                                if (data.facebook > 0) {
                                    $('#facebook_share_link').find(".share-counter").text(data.facebook);
                                }
                                if (data.gplus > 0) {
                                    $('#gplus_share_link').find(".share-counter").text(data.gplus);
                                }
                                if (data.twitter > 0) {
                                    $('#twitter_share_link').find(".share-counter").text(data.twitter);
                                }
                                if (data.linkedin > 0) {
                                    $('#linkedin_share_link').find(".share-counter").text(data.linkedin);
                                }
                                if (data.pinterest > 0) {
                                    $('#pinterest_share_link').find(".share-counter").text(data.pinterest);
                                }
                            }
                        },
                        contentType: "application/json",
                        cache: true
                    }
                );
            };
            this.githubCounter = function () {
                var timeConverter = function (timestamp) {
                    var a = new Date(timestamp * 1000);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var year = a.getFullYear();
                    var month = months[a.getMonth()];
                    return month + ' ' + year;
                };
                $.ajax(
                    {
                        type: 'GET',
                        url: window.lti.vars.api_url + 'github' + '?token=' + window.lti.vars.api_token,
                        dataType: 'jsonp',
                        jsonpCallback: 'dA6dFgp2n5Dxm2w',
                        success: function (data) {
                            if (typeof data == "object") {
                                var tableCells = $('.github-data');
                                for (var key in data) {
                                    var nbCommits = data[key].nbCommits;
                                    if (nbCommits > 0) {
                                        $('.' + key + '-nc').html(nbCommits);
                                    }
                                    var lastCommit = data[key].lastCommit;
                                    if (lastCommit > 0) {
                                        lastCommit = timeConverter(lastCommit);
                                    } else {
                                        lastCommit = 'N/A';
                                    }
                                    $('.' + key + '-lc').html(lastCommit);
                                }
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
        if ($('#lti-dev-projects').length>0) {
            page.githubCounter();
        }

    }
});

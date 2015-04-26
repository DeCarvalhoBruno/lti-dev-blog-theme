SyntaxHighlighter.all({'gutter': false, 'toolbar': false});
$('#navbar-toc').affix({
    offset: {
        top: 250,
        bottom: function () {
            var commentsArea = 0;
            var regularCommentsArea = $('.comments-area');
            if (regularCommentsArea.length) {
                commentsArea = regularCommentsArea.outerHeight(true);
            }
            return (this.bottom = ($('.site-footer').outerHeight(true) + commentsArea + 200));
        }
    }
});


(function() {

    var tagColors = ['am-badge-primary', 'am-badge-secondary', 'am-badge-success', 'am-badge-warning', 'am-badge-danger', ''];
    
    $(".am-panel-bd .am-badge").each(function() {
        var index = parseInt(Math.random() * tagColors.length);
        $(this).addClass(tagColors[index]);
    });

    if ($(".ac-msg-sorry").length) {
        var max_photo_id = 27;
        var photo_url = 'http://source.aicode.cc/photograph/';
        var item_pools = [];
        while (item_pools.length < 5) {
            var _index = parseInt(Math.random() * max_photo_id);
            if (_index == 0) {
                continue;
            }
            if (item_pools.indexOf(_index) == -1) {
                item_pools.push(_index);
            }
        }

        var img_list = '';
        for (var item in item_pools) {
            img_list += '<li><img src="' + photo_url + 'IMG_' + item_pools[item] + '.jpg"/></li>'
        }

        $(".ac-msg-sorry").append('<div class="am-slider am-slider-default" data-am-flexslider>' +
        '<ul class="am-slides">' + img_list + '</ul></div>');
    }

    if ($("form[role=search]").length) {
        $("form[role=search]").on('submit', function() {
            var input = $('form[role=search] input[name=wd]');
            input.val(input.val() + ' site:aicode.cc');
            return true;
        });
    }

    $(".am-topbar-brand").hover(function() {
        $(this).find('a').click();
    });
})();
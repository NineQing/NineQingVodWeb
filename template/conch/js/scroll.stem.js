(function($) {
    $.fn.navbarscroll = function(p) {
        var q = {
            className: 'cur',
            clickScrollTime: 300,
            duibiScreenWidth: 0.4,
            scrollerWidth: 3,
            SelectName: '.active',
            fingerClick: 0,
            endClickScroll: function(a) {}
        };
        var r = $.extend(q, p);
        this.each(function() {
            var f = $(this);
            var g = $(window);
            var h = g.width(),
                _wrapper_width = f.width(),
                _wrapper_off_left = f.offset().left;
            var j = h - _wrapper_off_left - _wrapper_width;
            var k = f.children('.scroller');
            var l = k.children('ul');
            var m = l.children('li');
            var n = 0;
            m.css({
                "margin-left": "0",
                "margin-right": "0"
            });
            for (var i = 0; i < m.length; i++) {
                n += m[i].offsetWidth
            }
            k.width(n + r.scrollerWidth);
            var o = new IScroll('#' + f.attr('id'), {
                eventPassthrough: true,
                scrollX: true,
                scrollY: false,
                preventDefault: false
            });
            _init($(r.SelectName));
            m.click(function() {
                _init($(this))
            });
            f[0].addEventListener('touchmove', function(e) {
                e.preventDefault()
            }, false);

            function _init(a) {
                var b = a;
                var c = r.duibiScreenWidth * h / 10,
                    this_index = b.index(),
                    this_off_left = b.offset().left,
                    this_pos_left = b.position().left,
                    this_width = b.width(),
                    this_prev_width = b.prev('li').width(),
                    this_next_width = b.next('li').width();
                var d = h - this_off_left - this_width;
                if (n + 2 > _wrapper_width) {
                    if (r.fingerClick === 1) {
                        if (this_index === 1) {
                            o.scrollTo(-this_pos_left + this_prev_width, 0, r.clickScrollTime)
                        } else if (this_index === 0) {
                            o.scrollTo(-this_pos_left, 0, r.clickScrollTime)
                        } else if (this_index === m.length - 2) {
                            o.scrollBy(d - j - this_width, 0, r.clickScrollTime)
                        } else if (this_index === m.length - 1) {
                            o.scrollBy(d - j, 0, r.clickScrollTime)
                        } else {
                            if (this_off_left - _wrapper_off_left - (this_width * r.fingerClick) < c) {
                                o.scrollTo(-this_pos_left + this_prev_width + (this_width * r.fingerClick), 0, r.clickScrollTime)
                            } else if (d - j - (this_width * r.fingerClick) < c) {
                                o.scrollBy(d - this_next_width - j - (this_width * r.fingerClick), 0, r.clickScrollTime)
                            }
                        }
                    } else {
                        if (this_index === 1) {
                            o.scrollTo(-this_pos_left + this_prev_width, 0, r.clickScrollTime)
                        } else if (this_index === m.length - 1) {
                            if (d - j > 1 || d - j < -1) {
                                o.scrollBy(d - j, 0, r.clickScrollTime)
                            }
                        } else {
                            if (this_off_left - _wrapper_off_left < c) {
                                o.scrollTo(-this_pos_left + this_prev_width, 0, r.clickScrollTime)
                            } else if (d - j < c) {
                                o.scrollBy(d - this_next_width - j, 0, r.clickScrollTime)
                            }
                        }
                    }
                }
                b.addClass(r.className).siblings('li').removeClass(r.className);
                r.endClickScroll.call(this, b)
            }
        })
    }
})(jQuery);
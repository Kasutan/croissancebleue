!function(i){i(document).ready(function(){i(".equipier .toggle").click(function(a){var e=i("#"+i(this).attr("aria-controls")),t=i(this).siblings("button");"false"==i(this).attr("aria-expanded")?(i(".equipier .toggle").attr("aria-expanded","false"),i(".equipier .volet").slideUp("slow"),i(this).attr("aria-expanded","true"),i(t).attr("aria-expanded","true"),i(e).slideDown("slow")):(i(this).attr("aria-expanded","false"),i(t).attr("aria-expanded","false"),i(e).slideUp("slow"))})})}(jQuery);
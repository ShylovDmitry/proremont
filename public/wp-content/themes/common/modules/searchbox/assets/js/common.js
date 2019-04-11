jQuery(function ($) {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    $('.catalog-search-input').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'catalog',
            limit: 10,
            source: substringMatcher(Object.keys(ProRemontSearchbox.catalogs))
        });

    $('.section-search-input').typeahead({
            hint: true,
            highlight: true,
            minLength: 0
        }, {
            name: 'section',
            limit: 100,
            source: substringMatcher(Object.keys(ProRemontSearchbox.sections))
        });



    $('#master-searchbox form').submit(function(e) {
        e.preventDefault();

        var catalog_val = $('#master-searchbox .catalog-search-input.tt-input').val();
        var catalog = ProRemontSearchbox.catalogs[catalog_val];
        if (catalog) {
            var parts = [];

            var section_val = $('#master-searchbox .section-search-input.tt-input').val();
            var section = ProRemontSearchbox.sections[section_val];
            if (section) {
                parts.push('region=' + section);
            }

            var mtype_val = $('#master-searchbox .mtype-input:checked').val();
            if (mtype_val) {
                parts.push('mtype=' + mtype_val);
            }

            window.location.href = catalog + (parts.length ? '?' + parts.join('&') : '');
        }
    });

});
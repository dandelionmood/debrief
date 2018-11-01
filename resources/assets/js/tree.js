// Story tree hierarchy plugin.
require('jstree');

jQuery(document).ready(function ($) {

    const debrief_tree = $('#debrief-universe-tree');

    if (debrief_tree.length > 0) {

        const read_url = debrief_tree.data('read-url'),
            write_url = debrief_tree.data('write-url');

        debrief_tree.jstree({
            'core': {
                'data': {
                    "url": read_url,
                    "data": function (node) {
                        return {"id": node.id};
                    }
                },
                "check_callback": function (operation, node, parent, position, more) {
                    return true; // allow everything else
                },
                // 'dblclick_toggle': false,
                'multiple': false,
                'themes': {
                    'name': 'proton',
                    // 'icons': false,
                    // 'dots': false,
                    'responsive': true,
                    // 'stripes': true,
                },
                'dnd': {
                    'copy': false,
                    'use_html5': true,
                    'inside_pos': 'last',
                },
                'state': {
                    "key": "demo2"
                }
            },
            'plugins': ['dnd', 'state', 'search']
        }).on('move_node.jstree', function (e, data) {

            $.ajax(write_url, {
                'method': 'PUT',
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data': {
                    'node_id': data.node.id,
                    'parent_node': data.parent,
                    'node_position': data.position,
                },
                'complete': function (e) {
                    // console.log(e);
                },
                'dataType': 'json'
            });

        }).on('activate_node.jstree', function (e, data) {

            // Nav handling

            debrief_tree.jstree('save_state');
            location.href = data.node.a_attr.href;

        }).on('ready.jstree', function () {

            // Restoration of the previous state of the tree,
            // selection of the chosen node.
            debrief_tree.jstree('restore_state');

            let current_node = debrief_tree.data('current-node');
            if (!current_node) {
                current_node = debrief_tree.find('> ul > li:eq(0)').attr('id');
            }

            // We need to wait a bit before carrying on.
            const chrono = setInterval(function () {
                clearInterval(chrono);
                debrief_tree.jstree('deselect_all');
                debrief_tree.jstree('open_node', current_node, function () {
                    debrief_tree.jstree('select_node', current_node);
                });
            }, 500);

        });

    }


    // Search in tree …………
    function search(q) {
        debrief_tree.jstree('search', q);
    };

    let chrono_search;
    $('#search-input').keypress(function (e) {
        let elm = $(this);
        clearInterval(chrono_search);
        let chrono_search = setInterval(function () {
            clearInterval(chrono_search);
            search(elm.val());
        }, 500);
    });
    // / Search in tree …………

});
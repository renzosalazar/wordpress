( function ( blocks, element, blockEditor, components  ) {
    var el = element.createElement;
    var rText = blockEditor.RichText;
    var radioGrpCtrl = components.RadioControl;
    var rangeCtrl = components.RangeControl;
    var textBoxCtrl = components.TextControl;
    var useBlockProps = blockEditor.useBlockProps;
    blocks.registerBlockType( 'block-getting-started/block-getting-started-1', {    
        edit: function ( props ) {
            var blockProps = useBlockProps();
            var content = props.attributes.content;
            var check_filters = ( props.attributes.check_filters == 'y' || props.attributes.check_filters == 'n' ) ? props.attributes.check_filters : 'y';
            var and_or_condition = ( props.attributes.and_or_condition == 'nd' || props.attributes.and_or_condition == 'or' ) ? props.attributes.and_or_condition : 'or';
            var pagination_number =  ( props.attributes.pagination_number >= 1 || props.attributes.pagination_number <= 100 ) ? props.attributes.pagination_number : 1;
            var pagination_type = ( props.attributes.pagination_type == 'nm' || props.attributes.pagination_type == 'ajx' ) ? props.attributes.pagination_type : 'nm';
            var load_more_text = props.attributes.load_more_btn_txt;
            function onChangeContent( new_content ){
                props.setAttributes( { content: new_content } );
            }
            function typeHandler(selected_val) {
                props.setAttributes({ check_filters: selected_val });
            };
            function filterHandler(selected_val){
                props.setAttributes({ and_or_condition: selected_val });
            }
            function rangeHandler( selected_range_val ){
                props.setAttributes({ pagination_number: selected_range_val });
            }
            function paginationTypeHandler( selected_p_type ){
                props.setAttributes({ pagination_type: selected_p_type });
            }
            function loadMoreTextHandler( changed_text ){
                props.setAttributes({ load_more_btn_txt: changed_text });
            }
            return (
                el("div", {className: "commentBox"},
                    el(rText,
                        Object.assign( blockProps,{
                            tagName: "p",
                            onChange: onChangeContent,
                            value: content ,
                        }
                    ) ),
                    el(radioGrpCtrl,
                        Object.assign({
                            label: "Display filters?",
                            help: "Check whether you want display filters or not!",
                            selected: check_filters,
                            className: "display-filters",
                            options: [{
                                label: 'Yes',
                                value: 'y'
                            }, {
                                label: 'No',
                                value: 'n'
                            }],
                            onChange: typeHandler
                        }
                    )),
                    el("br"),
                    el(radioGrpCtrl,
                        Object.assign({
                            label: "AND / OR Condition",
                            help: "Condition between Authors and Publisher taxonomies!",
                            selected: and_or_condition,
                            className: "filter-condition",
                            options: [{
                                label: 'AND',
                                value: 'nd'
                            }, {
                                label: 'OR',
                                value: 'or'
                            }],
                            onChange: filterHandler
                        }
                    ) ),
                    el("br"),
                    el(rangeCtrl,
                        Object.assign({
                            label: "Pagination count",
                            help: `The number of posts displayed per page. Posts count : ${pagination_number}`,
                            value: pagination_number,
                            className: "pagination-range-control",
                            onChange: rangeHandler,
                            min : 1,
                            max : 100,
                            withInputField : false  
                        }
                    ) ),
                    el("br"),
                    el(radioGrpCtrl,
                        Object.assign({
                            label: "Pagination Type",
                            help: "Select AJAX/Normal pagination type",
                            selected: pagination_type,
                            className: "pagination-type",
                            options: [{
                                label: 'Normal',
                                value: 'nm'
                            }, {
                                label: 'AJAX / Load More',
                                value: 'ajx'
                            }],
                            onChange: paginationTypeHandler
                        }
                    ) ),
                    el('br'),
                    ( pagination_type == 'ajx' ) ? el(textBoxCtrl,
                        Object.assign({
                            label: "Load more text",
                            value: load_more_text,
                            className: "load-more-string",
                            onChange: loadMoreTextHandler  
                        }
                    ) ) : false 
                )
            );
        },
        save: function ( props ) {
            var frontProps = useBlockProps.save();
            return el(
                rText.Content,
                Object.assign( frontProps,{
                        tagName: "p",
                        value: props.attributes.content
                    }
                )
            );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );